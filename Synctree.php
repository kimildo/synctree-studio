<?php
/**
 * 생성된 파일의 부모 클래스
 * 이 클래스는 추상 클래스를 부모로 둔다.
 *
 * @author kimildo
 */


namespace controllers\generated;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use abstraction\classes\SynctreeAbstract;
use libraries\{
    constant\CommonConst,
    constant\ErrorConst,
    log\LogMessage,
    util\CommonUtil,
    util\RedisUtil,
    util\AwsUtil
};

class Synctree extends SynctreeAbstract
{
    protected $ci;
    protected $logger;
    protected $renderer;
    protected $redis;
    protected $jsonResult;
    protected $httpClient;


    /**
     * Synctree constructor.
     *
     * @param Container $ci
     *
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $ci)
    {
        $this->ci = $ci;

        try {
            $this->ci       = $ci;
            $this->logger   = $ci->get('logger');
            $this->renderer = $ci->get('renderer');
            $this->redis    = $ci->get('redis');
        } catch (\Exception $ex) {
            LogMessage::error($ex->getMessage());
        }

        $this->jsonResult = [
            'result' => ErrorConst::SUCCESS_CODE,
            'data'   => [
                'message' => '',
            ]
        ];
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function getCommand(Request $request, Response $response)
    {
        $results = $this->jsonResult;

        try {

            $params = $request->getAttribute('params');
            if (false === CommonUtil::validateParams($params, ['event_key'])) {
                throw new \Exception(null, ErrorConst::ERROR_NOT_FOUND_REQUIRE_FIELD);
            }

            // get redis data
            if (false === ($redisData = RedisUtil::getDataWithDel($this->redis, $params['event_key'], CommonConst::REDIS_SECURE_PROTOCOL_COMMAND))) {
                throw new \Exception(null, ErrorConst::ERROR_RDB_NO_DATA_EXIST);
            }

            $results['data'] = $redisData;

        } catch (\Exception $ex) {
            $results = $this->_getErrorMessage($ex);
        }

        return $response->withJson($results, ErrorConst::SUCCESS_CODE);
    }


    /**
     * 역방향 보안프로토콜을 위한 리스너
     *
     * @param $params
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function _eventListener($params)
    {
        $httpClient = new \GuzzleHttp\Client();
        $result = false;

        try {

            if (false === CommonUtil::validateParams($params, ['target_url', 'event_key'])) {
                return $result;
            }

            $secureData['json'] = ['event_key' => $params['event_key']];
            $ret = $httpClient->request('POST', $params['target_url'], $secureData);
            $resData = $ret->getBody()->getContents();
            $resData = strip_tags($resData);
            $resData = json_decode($resData, true);
            $resStatus = $ret->getStatusCode() . ' ' . $ret->getReasonPhrase();
            $result = $resData;

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            preg_match('/`(5[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
            $resStatus = $output[1];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            preg_match('/`(4[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
            $resStatus = $output[1];
        } catch (\Exception $e) {
            $resStatus = "Name or service not known";
        }

        LogMessage::info('_eventListener :: ' . $resStatus);
        return $result;
    }

    /**
     * guzzle request
     *
     * @param        $targetUrl
     * @param        $options
     * @param string $method
     *
     * @return array
     */
    protected function _httpRequest($targetUrl, $options, $method = 'POST' )
    {
        $resData = null;

        if (empty($this->httpClient)) {
            return [];
        }

        try {

            $ret = $this->httpClient->request($method, $targetUrl, $options);
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

        return [
            'res_status' => $resStatus,
            'res_data' => $resData,
        ];

    }


    /**
     * 로그 S3 업로드
     *
     * @param $fileName
     * @param $contents
     * @param $appId
     * @param $bizId
     *
     * @return bool
     */
    protected function _saveLog($fileName, $contents, $appId, $bizId)
    {
        try {

            $filePath = BASE_DIR . '/logs/biz/';
            $fileName = $fileName . CommonUtil::getMicroTime() . '-' . APP_ENV . '.log';
            $file = $filePath . $fileName;

            $logfile = fopen($file, 'w');
            fwrite($logfile, $contents);
            fclose($logfile);

            $s3FileName = date('Y/m/d');
            $s3FileName .= '/' . $appId . '/' . $bizId . '/' . $fileName;

            if (APP_ENV === APP_ENV_PRODUCTION) {
                if (true === ($s3Result = AwsUtil::s3FileUpload($s3FileName, $file, 's3Log'))) {
                    @unlink($file);
                    return true;
                }
            }

            $result = true;

        } catch (\Exception $ex) {
            $result = false;
        }

        return $result;


    }

    /**
     * 에러메세지 출력
     *
     * @param \Exception $ex
     *
     * @return array
     */
    protected function _getErrorMessage(\Exception $ex)
    {
        $results = [
            'result' => ErrorConst::FAIL_CODE,
            'data'   => [
                'message' => CommonUtil::getErrorMessage($ex),
            ]
        ];

        return $results;
    }


}
