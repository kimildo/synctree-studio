<?php
/**
 * Studio PHP Generate Engine
 *
 * @author kimildo
 * @see https://packagist.org/packages/nette/php-generator
 *
 */

namespace libraries\util;

use libraries\{
    constant\CommonConst,
    constant\GeneratorConst,
    util\CommonUtil,
    log\LogMessage
};

use Nette\PhpGenerator as PGen;

class GenerateUtil
{
    private $config;
    private $fileObj;
    private $fileInfo;
    private $params;
    private $userPath;
    private $class;
    private $error = false;
    private $ci;

    /**
     * GenerateUtil constructor.
     *
     * @param       $ci
     * @param array $params
     */
    public function __construct($ci, $params = [])
    {
        $configFile = include APP_DIR . 'config/' . APP_ENV . '.php';
        $this->config = $configFile['settings']['home_path'] ?? null;

        $this->fileObj = new PGen\PhpFile;
        $this->fileObj->addComment('This file is Created by Ntuple GeneratedEngine.');
        $this->fileObj->addComment(date('Y-m-d H:i:s'));

        $this->params = $params;
        $this->userPath = str_replace(['@', '.'], '_', $params['user_id']);

        $this->ci = $ci;
    }

    /**
     * Controller 파일 생성
     *
     * @return $this
     * @throws \Exception
     */
    public function setControllerFile()
    {
        if (!empty($this->error)) {
            return $this;
        }

        $className = str_replace('.php', '', $this->fileInfo['file_name']);

        $namespace = $this->fileObj->addNamespace('controllers\\generated\\usr\\' . $this->userPath);
        $namespace
            ->addUse('Slim\Http\Request')
            ->addUse('Slim\Http\Response')
            ->addUse('Slim\Container')
            ->addUse('libraries\constant\CommonConst')
            ->addUse('libraries\constant\ErrorConst')
            ->addUse('libraries\log\LogMessage')
            ->addUse('libraries\util\CommonUtil')
            ->addUse('libraries\util\RedisUtil')
            ->addUse('controllers\generated\Synctree')
            ->addUse('Ramsey\Uuid\Uuid')
            ->addUse('Ramsey\Uuid\Exception\UnsatisfiedDependencyException')
        ;

        $this->class = $namespace->addClass($className)->setExtends('Synctree');
        $this->class->addConstant('BIZOPS', json_encode($this->params, JSON_UNESCAPED_UNICODE));
        //$class->addConstant('BUNIT_TOKEN', $this->params['token']);

        $this->class->addProperty('httpClient')->setVisibility('private');
        $this->class->addProperty('eventKey')->setVisibility('private');
        $this->class->addProperty('resultParams')->setVisibility('private');
        $this->class->addProperty('params')->setVisibility('private');
        $this->class->addProperty('promise')->setVisibility('private');
        $this->class->addProperty('httpReqTimeout', 3)->setVisibility('private');
        $this->class->addProperty('httpReqVerify', false)->setVisibility('private');


        $this->class->addMethod('__construct')->setBody('parent::__construct($ci);')->addParameter('ci')->setTypeHint('Container');

        $mainBody = <<<'SOURCE'
$result = [];
$result['result'] = ErrorConst::SUCCESS_STRING;
$startTime = CommonUtil::getMicroTime();
$result['timestamp']['start'] = CommonUtil::getDateTime() . ' ' . $startTime;
SOURCE;

        $mainBody .= PHP_EOL . PHP_EOL . 'try {' . PHP_EOL;
        $mainBody .= '    $this->params = $request->getAttribute(\'params\');';
        $mainBody .= PHP_EOL . PHP_EOL;

        //$request = ['token'];
        $request = [];
        $requestEncode = '';
        foreach ($this->params['request'] as $req) {
            $request[] = $req['req_key'];
            if ($req['req_var_type'] === CommonConst::VAR_TYPE_JSON) {
                $requestEncode .= '$this->params[\'' . $req['req_key'] . '\'] = CommonUtil::getValidJSON($this->params[\'' . $req['req_key'] . '\']);' . PHP_EOL . PHP_EOL;
            }
        }

        $request = "'" . implode("', '", $request) . "'";
        $mainBody .= '    if (false === CommonUtil::validateParams($this->params, [' . $request . '])) {' . PHP_EOL;
        $mainBody .= <<<'SOURCE'
        LogMessage::error('Not found required field');
        throw new \Exception(null, ErrorConst::ERROR_NOT_FOUND_REQUIRE_FIELD);
    }
    
    $bizOps = json_decode(static::BIZOPS, true);
    $this->httpClient = new \GuzzleHttp\Client();
	
	$responseDatas = [];
    $result['request'] = [
        'actor_alias' => $bizOps['actor_alias'] ?? null,
        'request' => $this->params,
    ];
    
SOURCE;

        $mainBody .= $requestEncode;
        $mainMethod = $this->class->addMethod(GeneratorConst::GEN_MAIN_METHOD_NAME);
        $operation = [];

        //CommonUtil::showArrDump($this->params['controls']);
        foreach ($this->params['operators'] as $key => $row) {
            $operation[$key] = $row;
        }
        ksort($operation);

        $mainBodyArr = [];
        $controlInfoArr = [];

        foreach ($operation as $opSeq => $row) {

            $bindSeq = $opSeq;
            $controlInfo = null;
            if (!empty($row['control_container_code'])) {
                $controlInfo = json_decode($row['control_container_info'], true);
                $controlIndex = array_search($controlInfo['control_id'], array_column($this->params['controls'], 'control_alt_id'));
                $bindSeq = $this->params['controls'][$controlIndex]['binding_seq'];
            }

            //$args = ($bindSeq !== array_key_first($operation)) ? '($request, $response, $params, $this->resultParams[\'response\']);' : '($request, $response, $params);';
            $args = '($request, $response);';
            $subMethodName = GeneratorConst::GEN_SUB_METHOD_NAME . strtoupper($row['operation_key']) . $opSeq;
            $resSourceText = '    $responseDatas[] = $this->resultParams = $this->' . $subMethodName . $args;
            if (!empty($row['control_container_code'])) {
                $mainBodyArr[$bindSeq][$opSeq] = $resSourceText;
                $controlInfoArr[$opSeq] = $controlInfo;
            } else {
                $mainBodyArr[$opSeq] = $resSourceText;
            }

            // 모든 오퍼레이터 서브메소드 생성
            if (false === $this->_makeSubfuntion($subMethodName, $row, $opSeq)) {
                $this->error = 'Error While Make Subfunction';
                LogMessage::error($this->error);
                return $this;
            }

        } // end of $operation foreach

        //CommonUtil::showArrDump($mainBodyArr);
        // 메인메소드 조건문 or Response 호출 생성
        $controlOperators = CommonConst::CONTROLL_OPERATORS;
        foreach ($mainBodyArr as $key => $row) {
            // if alt
            if (is_array($row)) {

                $mainBody .= PHP_EOL . '    switch (true) {' . PHP_EOL;
                foreach ($row as $opSeq => $source) {

                    $controlInfo = $controlInfoArr[$opSeq];
                    $controlIndex = array_search($controlInfo['control_id'], array_column($this->params['controls'], 'control_alt_id'));

                    $parameterKeyName = $this->params['controls'][$controlIndex]['parameter_key_name'];
                    $parameterJson = (!empty($this->params['controls'][$controlIndex]['sub_parameter_path']))
                                   ? $this->_jsonPathToArrayString($this->params['controls'][$controlIndex]['sub_parameter_path']) : '';

                    $parameterFrom = (!empty($this->params['controls'][$controlIndex]['biz_ops_id'])) ? '$params' : '$this->resultParams[\'response\']';
                    $targetValue = (is_int($controlInfo['value'])) ? (int)$controlInfo['value'] : '\'' . $controlInfo['value'] . '\'';

                    //if ($key === array_key_last($row)) {
                    //    $mainBody .= '        default : ' . PHP_EOL . '      ' . $source . PHP_EOL;
                    //} else {
                        $mainBody .= '        case ('. $parameterFrom .'[\'' . $parameterKeyName . '\']' . $parameterJson . ' ' . $controlOperators[$controlInfo['operator']]
                                  . ' ' . $targetValue . ') :'  . PHP_EOL
                                  . '          ' . $source . PHP_EOL
                                  . '              break;' . PHP_EOL
                                  ;
                    //}
                }

                $mainBody .= '        default : ' . PHP_EOL . '      ' . PHP_EOL;
                $mainBody .= '    }' . PHP_EOL;

            } else {
                $mainBody .= $row . PHP_EOL;
            }
        }

        $mainBody .= <<<'SOURCE'
            
    $result['data'] = $responseDatas;

} catch (\Exception $ex) {
    $result = $this->_getErrorMessage($ex);
}

$endTime = CommonUtil::getMicroTime();
$result['timestamp']['end'] = CommonUtil::getDateTime() . ' ' . $endTime;
$result['timestamp']['runtime'] = $endTime - $startTime;

try {
    $this->_saveLog('logBiz-' . $bizOps['biz_id'] . '-access', json_encode($result, JSON_UNESCAPED_UNICODE), $bizOps['app_id'], $bizOps['biz_id']);
} catch (\Exception $ex) {
    LogMessage::error('Save Log Fail (biz:: ' . $bizOps['biz_id'] . ') - ' . json_encode($this->_getErrorMessage($ex), JSON_UNESCAPED_UNICODE));
}

unset($result['timestamp']);
unset($result['result']);

return $response->withJson($result, ErrorConst::SUCCESS_CODE);
SOURCE;

        $mainMethod->addComment($this->params['biz_name'] . " Main Method\n");

        $mainMethod->setBody($mainBody);
        $mainMethod->addParameter('request')->setTypeHint('Request');
        $mainMethod->addParameter('response')->setTypeHint('Response');

        $mainMethod->addComment("@param Request \$request\n");
        $mainMethod->addComment("@param Response \$response\n");

        if ($this->params['req_method'] == CommonConst::REQ_METHOD_GET_STR) {
            $mainMethod->addParameter('args')->setTypeHint('array');
            $mainMethod->addComment("@param args \$args\n");
        }

        $mainMethod->addComment("@return Response\n");
        $mainMethod->addComment("@throws \\Exception\n");

        return $this;

    }

    /**
     * 라우트 파일 소스 생성
     *
     * @return $this
     */
    public function setRouteFile()
    {
        if (!empty($this->error)) {
            return $this;
        }

        //LogMessage::debug('fileInfo :: ' . json_encode($this->fileInfo));
        $sourceText = '<?php' . PHP_EOL . PHP_EOL;
        $sourceText .= '$app->group(\'/Gen' . $this->params['biz_uid'] . '\', function () {' . PHP_EOL;
        $sourceText .= PHP_EOL . '    $this->post(\'' . CommonConst::GET_COMMAND_URL . '\', \'controllers\\generated\\usr\\' . $this->userPath . '\\'
            . $this->fileInfo['template_name'] . $this->params['biz_uid'] . 'Controller:getCommand\')->setName(\'getCommand\');';

        /*
        $sourceText .= PHP_EOL . '    $this->' . ($this->params['req_method'] == 'P' ? 'post' : 'get') . '(\'';
        if ($this->params['req_method'] == 'G' && !empty($this->params['request'])) {
            foreach ($this->params['request'] as $row) {
                $sourceText .= '/{' . $row['req_key'] . '}';
            }
        }
        $sourceText .= '/{token}\', ';
        */

        $reqMethod = ($this->params['req_method'] === CommonConst::REQ_METHOD_GET_CODE) ? CommonConst::REQ_METHOD_GET : CommonConst::REQ_METHOD_POST ;
        $reqMethod = strtolower($reqMethod);

        $sourceText .= PHP_EOL . '    $this->' . $reqMethod . '(\'\', ';
        $sourceText .= '\'controllers\\generated\\usr\\' . $this->userPath . '\\' . $this->fileInfo['template_name'] . $this->params['biz_uid']
            . 'Controller:'. GeneratorConst::GEN_MAIN_METHOD_NAME .'\')->setName(\''. GeneratorConst::GEN_MAIN_METHOD_NAME .'\');';
        $sourceText .= PHP_EOL . '    $this->' . $reqMethod . '(\'/\', ';
        $sourceText .= '\'controllers\\generated\\usr\\' . $this->userPath . '\\' . $this->fileInfo['template_name'] . $this->params['biz_uid']
            . 'Controller:'. GeneratorConst::GEN_MAIN_METHOD_NAME .'\')->setName(\''. GeneratorConst::GEN_MAIN_METHOD_NAME .'\');' . PHP_EOL;

        $sourceText .= PHP_EOL . '})->add(new \middleware\Common($app->getContainer(), APP_ENV === APP_ENV_PRODUCTION));';

        $this->fileObj = $sourceText;

        return $this;
    }


    /**
     * 파일 이름 얻기
     *
     * @param string $type
     * @param string $templateName
     *
     * @return $this|bool
     */
    public function getFileName($type = 'CONTROLLER', $templateName = GeneratorConst::GEN_FILE_PREFIX)
    {

        try {

            $filePath = $this->config . GeneratorConst::PATH_RULE[$type]['PATH'] . $this->userPath . '/';
            $fileName = ucfirst(strtolower($templateName)) . $this->params['biz_uid'] . GeneratorConst::PATH_RULE[$type]['SUBFIX'];

            if ( ! file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }

            $this->fileInfo = [
                'file_path'     => $filePath,
                'file_name'     => $fileName,
                'template_name' => $templateName
            ];

        } catch (\Exception $ex) {
            $this->error = 'Fail to get filename';
            LogMessage::error($this->error);
        }

        return $this;
    }

    /**
     * 파일쓰기
     *
     * @param string $mode
     *
     * @return string
     */
    public function writeFile($mode = 'w')
    {
        try {

            if (!empty($this->error)) {
                throw new \Exception($this->error);
            }

            $fileContents = $this->_refining($this->fileObj);
            $generatedFile = fopen($this->fileInfo['file_path'] . $this->fileInfo['file_name'], $mode);
            fwrite($generatedFile, $fileContents);
            fclose($generatedFile);

        } catch (\Exception $ex) {
            LogMessage::error('Fail to write file :: ' . $this->fileInfo['file_path'] . $this->fileInfo['file_name']);
            return false;
        }

        return $this->fileInfo['file_name'];
    }

    public function exportBizUnit()
    {
        return false;
    }

    /**
     * 오퍼레이션에 따른 서브메소드 생성
     *
     * @param $methodName
     * @param $row
     * @param $bindingSeq
     *
     * @return bool
     * @throws \Exception
     */
    private function _makeSubfuntion($methodName, $row, $bindingSeq)
    {
        $subBody = '';

        if (false === ($op = AppsUtil::getOperationInfo($this->ci, $this->params['account_id'], $this->params['team_id'], $row['operation_id']))) {
            LogMessage::error('Error Get Operator - File Generator');
            return false;
        }

        // 해당 오퍼레이션에 전달 인자 목록을 조회 (request)
        $result = CommonUtil::callProcedure($this->ci, 'executeGetArgumentList', [
            'account_id'     => $this->params['account_id'],
            'team_id'        => $this->params['team_id'],
            'application_id' => $this->params['app_id'],
            'biz_ops_id'     => $this->params['biz_id'],
            'binding_seq'    => $bindingSeq,
            'operation_id'   => $row['operation_id']
        ]);

        if (0 !== $result['returnCode']) {
            LogMessage::error('DB Error GetArgumentList - File Generator');
            return false;
        }

        $opDb = $result['data'][1];
        //$subBody = 'return true;';
        $subBody .= '$targetUrl = \'' . $op['target_url'] . (( ! empty($op['target_method'])) ? '/' . $op['target_method'] : '') . '\';' . PHP_EOL;

        switch ($op['req_method']) {
            case CommonConst::REQ_METHOD_POST_STR :
                $opReqType = CommonConst::REQ_METHOD_POST;
                $opReqTypeVar = 'form_params';
                break;
            default :
                $opReqType = CommonConst::REQ_METHOD_GET;
                $opReqTypeVar = 'query';
        }

        switch ($op['header_transfer_type_code']) {
            case CommonConst::HTTP_HEADER_CONTENTS_TYPE_JSON_CODE :
                $opReqTypeVar = strtolower(CommonConst::VAR_TYPE_JSON_TEXT);
                break;
            case CommonConst::HTTP_HEADER_CONTENTS_TYPE_WWW_FORM_URLENCODED_CODE :
                $subBody .= '$options[\'headers\'] = [\'Content-Type\' => \''. CommonConst::HTTP_HEADER_CONTENTS_TYPE_WWW_FORM_URLENCODED_STR .'\'];' . PHP_EOL;
                break;
            case CommonConst::HTTP_HEADER_CONTENTS_TYPE_XML_CODE :
                $subBody .= '$options[\'headers\'] = [\'Content-Type\' => \''. CommonConst::HTTP_HEADER_CONTENTS_TYPE_XML_STR .'\'];' . PHP_EOL;
                $opReqTypeVar = 'body';
                break;
        }

        if ( ! empty($op['auth_type_code']) && ! empty($row['auth_keys']) ) {

            if (null === ($authKeys = CommonUtil::getValidJSON($row['auth_keys']))) {
                LogMessage::error('Auth_keys Error Not valid JSON - File Generator');
                return false;
            }

            switch ($op['auth_type_code']) {
                case CommonConst::API_AUTH_BASIC :
                    $subBody .= '$options[\'auth\'] = [\'' . $authKeys[0]['username'] . '\', \'' . $authKeys[0]['password'] . '\'];' . PHP_EOL;
                    break;
                case CommonConst::API_AUTH_BEARER_TOKEN :
                    $subBody .= '$options[\'headers\'][\'Authorization\'] = \'Bearer ' . $authKeys[0]['token'] . '\';' . PHP_EOL;
                    break;
            }
        }

        $subBody .= '$options[\'verify\'] = $this->httpReqVerify;' . PHP_EOL;
        $subBody .= '$options[\'timeout\'] = $this->httpReqTimeout;' . PHP_EOL;

        //CommonUtil::showArrDump($row['operation_id'], false);
        //CommonUtil::showArrDump($opDb);

        if ( ! empty($opDb)) {
            $subBodyReqs = '';
            foreach ($opDb as $reqs) {
                $reqVal = '\'' . $reqs['argument_value'] . '\'';
                if ( ! empty($reqs['relay_flag'])) {

                    //$reqVal = ( ! empty($reqs['relay_biz_ops_id'])) ? '$params[\'' . $reqs['relay_parameter_key_name'] . '\']'
                    //        : '$responseDatas[\'' . $reqs['relay_parameter_key_name'] . '\']'
                    //        ;

                    $reqVal = ( ! empty($reqs['relay_biz_ops_id'])) ? '$this->params[\'' . $reqs['relay_parameter_key_name'] . '\']'
                            : '$this->resultParams[\'response\'][\'' . $reqs['relay_parameter_key_name'] . '\']'
                            ;

                    // 파라미터 타입이 JSON인 경우
                    if ($reqs['relay_parameter_type_code'] === CommonConst::VAR_TYPE_JSON_CODE && !empty($reqs['relay_sub_parameter_path'])) {
                        $reqVal .= $this->_jsonPathToArrayString($reqs['relay_sub_parameter_path']);
                    }

                    $reqVal .= ' ?? null';
                }

                $subBodyReqs .= '    \'' . $reqs['parameter_key_name'] . '\' => ' . $reqVal . ',' . PHP_EOL;
            }
        }

        if (!empty($subBodyReqs)) {
            $subBody .= '$options[\'' . $opReqTypeVar . '\'] = [' . PHP_EOL;
            $subBody .= $subBodyReqs;
            $subBody .= '];' . PHP_EOL;
        }

        if ($op['method'] == CommonConst::PROTOCOL_TYPE_SECURE) {
            $subBody .= PHP_EOL . '$uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, session_id() . time());' . PHP_EOL;
            $subBody .= '$this->eventKey = strtoupper(\'event-\' . $uuid->toString());' . PHP_EOL;
            $subBody .= '$datas = [\'event_key\' => $this->eventKey, \'params\' => $options[\'' . $opReqTypeVar . '\']];' . PHP_EOL;
            $subBody .= 'RedisUtil::setDataWithExpire($this->redis, CommonConst::REDIS_SECURE_PROTOCOL_COMMAND, $this->eventKey, CommonConst::REDIS_SESSION_EXPIRE_TIME_MIN_5, $datas);'
                . PHP_EOL;
            $subBody .= '' . PHP_EOL;
        }

        $subBody .= 'try { ' . PHP_EOL;

        if ($op['method'] == CommonConst::PROTOCOL_TYPE_SECURE) {
            $subBody .= '    $secureData[\'' . $opReqTypeVar . '\'] = [\'event_key\' => $this->eventKey];' . PHP_EOL;
            $subBody .= '    $ret = $this->httpClient->request(\'' . $opReqType . '\', $targetUrl, $secureData);' . PHP_EOL;
        } else {
            $subBody .= '    $ret = $this->httpClient->request(\'' . $opReqType . '\', $targetUrl, $options);' . PHP_EOL;
        }

        $subBody .= <<<'SOURCE'
        
    $resData = $ret->getBody()->getContents();
    $resData = strip_tags($resData);
    $resData = CommonUtil::getValidJSON($resData);
    $resStatus = $ret->getStatusCode() . ' ' . $ret->getReasonPhrase();

} catch (\GuzzleHttp\Exception\ServerException $e) {
    preg_match('/`(5[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
    $resStatus = $output[1];
} catch (\GuzzleHttp\Exception\ClientException $e) {
    preg_match('/`(4[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
    $resStatus = $output[1];
} catch (\Exception $e) {
    $resStatus = "Name or service not known";
}
SOURCE;

        $subBody .= PHP_EOL . PHP_EOL . '$result = [' . PHP_EOL;
        $subBody .= '    \'op_name\' => \'' . $op['op_name'] . '\',' . PHP_EOL;
        $subBody .= '    \'request_target_url\' => $targetUrl,' . PHP_EOL;
        $subBody .= '    \'server_status\' => $resStatus,' . PHP_EOL;

        if ($op['method'] == CommonConst::PROTOCOL_TYPE_SIMPLE_HTTP) {
            $subBody .= '    \'request\' => $options[\'' . $opReqTypeVar . '\'],' . PHP_EOL;
        }

        $subBody .= '    \'response\' => [' . PHP_EOL;

        foreach ($op['response'] as $ress) {
            $subBody .= '        \'' . $ress['res_key'] . '\' => $resData[\'' . $ress['res_key'] . '\'] ?? null,' . PHP_EOL;
        }

        $subBody .= '    ]' . PHP_EOL;
        $subBody .= '];' . PHP_EOL;
        $subBody .= 'return $result;' . PHP_EOL;

        // 하위 메소드 생성
        $method = $this->class->addMethod($methodName)->setVisibility('private');
        $method->setBody($subBody);
        $method->addParameter('request')->setTypeHint('Request');
        $method->addParameter('response')->setTypeHint('Response');
        //$method->addParameter('params')->setTypeHint('array');
        //if ($bindingSeq > 1) {
        //    $method->addParameter('responseDatas')->setTypeHint('array');
        //}

        $method->addComment('Operation Name : ' . $op['op_name']);
        $method->addComment('ID : ' . $op['op_id']);
        $method->addComment('Description : ' . $op['op_desc']);
        $method->addComment('Binding Seq : ' . $bindingSeq);

        return true;
    }

    /**
     * jsonpath 를 배열스트링으로 변환해 반환
     *
     * @param $jsonPath
     *
     * @return string
     */
    private function _jsonPathToArrayString($jsonPath)
    {
        $arrayString = '';
        //$relayJson = json_decode($reqs['relay_sub_parameter_format'], true);
        $relayJsonPath = str_replace('$.', '', $jsonPath);

        $tmp = explode('.', $relayJsonPath);
        foreach ($tmp as $tpKey) {
            if (!empty(strpos($tpKey, '['))) {
                $tpKeyTemp = explode('[', $tpKey);
                $arrayString .= '[\'' . $tpKeyTemp[0] . '\']' . '[' . str_replace(']', '' , $tpKeyTemp[1]) . ']';
            } else {
                $arrayString .= '[\'' . $tpKey . '\']';
            }
        }

        return $arrayString;


    }

    private function _refining($file)
    {
        $file = str_replace([
            'extends \\Synctree',
            '(\\Container',
            '(\\Request $request, \\Response $response',
            '(\\Request $request, \\Response $response, \\$args',
        ], [
            'extends Synctree',
            '(Container',
            '(Request $request, Response $response',
            '(Request $request, Response $response, $args',
        ], $file);

        return $file;
    }

}