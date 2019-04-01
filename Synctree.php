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
use libraries\{constant\CommonConst,
    constant\ErrorConst,
    log\LogMessage,
    util\CommonUtil,
    util\RedisUtil,
    util\AwsUtil};

class Synctree extends SynctreeAbstract
{
    protected $ci;
    protected $logger;
    protected $renderer;
    protected $redis;
    protected $jsonResult;
    protected $httpClient;
    protected $promise;
    protected $promiseResponseData;
    protected $httpReqTimeout = 3;
    protected $httpReqVerify = false;


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
            $this->ci = $ci;
            $this->logger = $ci->get('logger');
            $this->renderer = $ci->get('renderer');
            $this->redis = $ci->get('redis');
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
        $result = false;

        if (false === CommonUtil::validateParams($params, ['target_url', 'event_key'])) {
            return $result;
        }

        $options = [
            'verify' => $this->httpReqVerify,
            'timeout' => $this->httpReqTimeout,
            'json' => ['event_key' => $params['event_key']]
        ];

        $result = $this->_httpRequest($params['target_url'], $options);

        $resStatus = $result['res_status'];
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function _httpRequest($targetUrl, $options, $method = 'POST')
    {
        $resData = null;
        $resStatus = null;

        try {

            if (empty($this->httpClient) || ! is_object($this->httpClient)) {
                $this->httpClient = new \GuzzleHttp\Client();
            }

            $ret = $this->httpClient->request($method, $targetUrl, $options);
            $resData = $ret->getBody()->getContents();
            $resData = strip_tags($resData);
            $resData = CommonUtil::getValidJSON($resData);
            $resStatus = $ret->getStatusCode() . ' ' . $ret->getReasonPhrase();

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            preg_match('/`(5[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
            $resStatus = $output[1];
            LogMessage::error('url :: ' . $targetUrl . ', error :: ' . $resStatus . ', options :: ' . json_encode($options, JSON_UNESCAPED_UNICODE));
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            preg_match('/`(4[0-9]{2}[a-z\s]+)`/i', $e->getMessage(), $output);
            $resStatus = $output[1];
            LogMessage::error('url :: ' . $targetUrl . ', error :: ' . $resStatus);
        } catch (\Exception $e) {
            $resStatus = "Name or service not known";
            LogMessage::error('url :: ' . $targetUrl . ', error :: ' . $resStatus);
        }

        return [
            'res_status' => $resStatus,
            'res_data'   => $resData,
        ];

    }

    /**
     * 비동기 호출
     *
     * @param array $asyncRequests
     * @param int $concurrency
     * @param bool $wait
     *
     * @return array
     *
     * $domainArr = [
            [
            'url' => 'https://3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io/getJson',
            'method' => 'POST'
            ],
            [
            'url' => 'https://www.naver.com/efwefwe',
            'method' => 'POST'
            ],
            [
            'url' => 'https://www.daum.net/ffff',
            'method' => 'GET'
            ],
            [
            'url' => 'https://3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io/getJson',
            'method' => 'GET'
            ]
       ];
        $responseDatas['async'] = $this->_httpAsyncRequest($domainArr);
     */
    protected function _httpAsyncRequest(array $asyncRequests, $wait = true, $concurrency = 5)
    {
        $this->promiseResponseData = [];

        try {

            if (empty($this->httpClient) || ! is_object($this->httpClient)) {
                $this->httpClient = new \GuzzleHttp\Client();
            }

            if (true === $wait) {

                $requestPromises = function ($targets) {
                    foreach ($targets as $target) {
                        yield function() use ($target) {
                            return $this->httpClient->requestAsync($target['method'], $target['url'], $target['options'] ?? [] );
                        };
                    }
                };

                $pool = new \GuzzleHttp\Pool($this->httpClient, $requestPromises($asyncRequests), [
                    'concurrency' => $concurrency,
                    'fulfilled'   => function ($response, $index) {
                        // this is delivered each successful response
                        $resData = json_decode($response->getBody()->getContents(), true);
                        $this->promiseResponseData['seq'][] = $index;
                        $this->promiseResponseData['data'][] = $resData;

                        $generatedFile = fopen('/home/ubuntu/apps/secure/upload/' . $index . '.txt', 'w');
                        fwrite($generatedFile, json_encode($resData, JSON_UNESCAPED_UNICODE));
                        fclose($generatedFile);

                    },
                    'rejected'    => function ($reason, $index) {
                        // this is delivered each failed request
                    },
                ]);

                $promise = $pool->promise();
                $promise->wait();

            } else {

                foreach ($asyncRequests as $index => $target) {
                    $this->promiseResponseData['seq'][] = $index;
                    $promise[] = $this->httpClient->requestAsync($target['method'], $target['url'], $target['options'] ?? [] );
                }
                //$pool = new \GuzzleHttp\Pool($this->httpClient, $requestPromises($asyncRequests));
            }

            //CommonUtil::showArrDump($promise);

        } catch (\Exception $e) {

        }

        return $this->promiseResponseData;

    }


    /**
     * 로그 S3 업로드
     * @todo 추후 로그서버를 별도로 구축, 비동기로 전환
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
