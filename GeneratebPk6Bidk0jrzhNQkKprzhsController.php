<?php

/**
 * This file is Created by Ntuple GeneratedEngine.
 * 2019-03-22 12:50:42
 */

namespace controllers\generated\usr\owner_nntuple_com;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use controllers\generated\Synctree;
use libraries\constant\CommonConst;
use libraries\constant\ErrorConst;
use libraries\log\LogMessage;
use libraries\util\CommonUtil;
use libraries\util\RedisUtil;

class GeneratebPk6Bidk0jrzhNQkKprzhsController extends Synctree
{
	const BIZOPS = '{"app_id":5,"biz_id":51,"biz_uid":"bPk6Bidk0jrzhNQkKprzhs","biz_name":"DEV_BIZ3","biz_desc":"DEV_BIZ3_DESC","actor_alias":"DEV-Consumer","method":2,"req_method":1,"reg_date":"2019-03-05 16:14:50","request":[{"param_id":642,"req_key":"biz_user_key","req_var_type":"INT","req_desc":"description"},{"param_id":643,"req_key":"biz_user_name","req_var_type":"STR","req_desc":"description"},{"param_id":816,"req_key":"biz_user_json","req_var_type":"JSN","req_desc":""}],"operators":{"1":{"binding_seq":1,"operation_id":77,"operation_key":"w0EZbM1hWM8WLmzIQ9HhWg","operation_namespace_id":13,"operation_namespace_name":"AIG11","header_transfer_type_code":1,"operation_name":"테스트 OP","operation_description":"테스트 OP","protocol_type_code":2,"request_method_code":2,"auth_type_code":0,"auth_keys":null,"control_container_code":0,"control_container_info":null},"2":{"binding_seq":2,"operation_id":82,"operation_key":"BfggMp7j42btsj2redIKKA","operation_namespace_id":1,"operation_namespace_name":"AIG","header_transfer_type_code":1,"operation_name":"테스트 OP45654","operation_description":"테스트 OP","protocol_type_code":1,"request_method_code":2,"auth_type_code":0,"auth_keys":"[{\"env\": \"dev\", \"token\": \"eeee\"}]","control_container_code":0,"control_container_info":null},"4":{"binding_seq":4,"operation_id":23,"operation_key":"CoKHczND6B6B_SZj3J2Izw","operation_namespace_id":2,"operation_namespace_name":"AIG1","header_transfer_type_code":1,"operation_name":"dev_op1","operation_description":"dev_op1","protocol_type_code":2,"request_method_code":2,"auth_type_code":1,"auth_keys":null,"control_container_code":1,"control_container_info":"{\"value\": \"10\", \"operator\": 2, \"control_id\": 36}"},"5":{"binding_seq":5,"operation_id":24,"operation_key":"uTSEARaPB0_7X7q2d5cr1w","operation_namespace_id":1,"operation_namespace_name":"AIG","header_transfer_type_code":1,"operation_name":"dev_opt2","operation_description":"dev_opt2","protocol_type_code":2,"request_method_code":2,"auth_type_code":2,"auth_keys":null,"control_container_code":1,"control_container_info":"{\"value\": \"10\", \"operator\": 5, \"control_id\": 36}"}},"lines":[],"user_id":"owner@nntuple.com","account_id":5,"team_id":1,"controls":[{"control_alt_id":36,"binding_seq":3,"parameter_id":640,"object_code":1,"biz_ops_id":null,"biz_ops_name":null,"operation_id":82,"operation_namespace_id":1,"operation_name":"테스트 OP45654","direction_code":2,"parameter_key_name":"bicycle_store","parameter_type_code":5,"sub_parameter_format":"{\"bicycle\": {\"color\": \"red\", \"price\": 19.95, \"available\": true}}","sub_parameter_path":"$.bicycle.price","control_alt_description":"dsfewfwfwefwefwef"}]}';

	private $httpClient;

	private $eventKey;

	private $resultParams;

	private $params;

	private $promise;

	private $httpReqTimeout = 3;

	private $httpReqVerify = false;


	public function __construct(Container $ci)
	{
		parent::__construct($ci);
	}


	/**
	 * DEV_BIZ3 Main Method
	 *
	 * @param Request $request
	 *
	 * @param Response $response
	 *
	 * @return Response
	 *
	 * @throws \Exception
	 */
	public function main(Request $request, Response $response)
	{
		$result = [];
		$result['result'] = ErrorConst::SUCCESS_STRING;
		$startTime = CommonUtil::getMicroTime();
		$result['timestamp']['start'] = CommonUtil::getDateTime() . ' ' . $startTime;

		try {
		    $this->params = $request->getAttribute('params');

		    if (false === CommonUtil::validateParams($this->params, ['biz_user_key', 'biz_user_name', 'biz_user_json'])) {
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
		    $this->params['biz_user_json'] = json_decode($this->params['biz_user_json'], true);

		    $responseDatas[] = $this->resultParams = $this->_subW0EZBM1HWM8WLMZIQ9HHWG1($request, $response);
		    $responseDatas[] = $this->resultParams = $this->_subBFGGMP7J42BTSJ2REDIKKA2($request, $response);

		    switch (true) {
		        case ($this->resultParams['response']['bicycle_store']['bicycle']['price'] > '10') :
		              $responseDatas[] = $this->resultParams = $this->_subCOKHCZND6B6B_SZJ3J2IZW4($request, $response);
		              break;
		        case ($this->resultParams['response']['bicycle_store']['bicycle']['price'] <= '10') :
		              $responseDatas[] = $this->resultParams = $this->_subUTSEARAPB0_7X7Q2D5CR1W5($request, $response);
		              break;
		        default :

		    }

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
	}


	/**
	 * Operation Name : 테스트 OP
	 * ID : 77
	 * Description : 테스트 OP
	 * Binding Seq : 1
	 */
	private function _subW0EZBM1HWM8WLMZIQ9HHWG1(Request $request, Response $response)
	{
		$targetUrl = 'https://3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io/getJson';
		$options['verify'] = $this->httpReqVerify;
		$options['timeout'] = $this->httpReqTimeout;
		$options['form_params'] = [
		    'user_key' => $this->params['biz_user_key'] ?? null,
		    'user_name' => $this->params['biz_user_json']['name'] ?? null,
		    'user_ename' => $this->params['biz_user_json']['nameEng'] ?? null,
		];
		try {
		    $ret = $this->httpClient->request('POST', $targetUrl, $options);

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

		$result = [
		    'op_name' => '테스트 OP',
		    'request_target_url' => $targetUrl,
		    'server_status' => $resStatus,
		    'request' => $options['form_params'],
		    'response' => [
		        'book_store' => $resData['book_store'] ?? null,
		        'bicycle_store' => $resData['bicycle_store'] ?? null,
		    ]
		];
		return $result;
	}


	/**
	 * Operation Name : 테스트 OP45654
	 * ID : 82
	 * Description : 테스트 OP
	 * Binding Seq : 2
	 */
	private function _subBFGGMP7J42BTSJ2REDIKKA2(Request $request, Response $response)
	{
		$targetUrl = 'https://3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io/getJson';
		$options['verify'] = $this->httpReqVerify;
		$options['timeout'] = $this->httpReqTimeout;
		$options['form_params'] = [
		    'bicycle_price' => $this->resultParams['response']['bicycle_store']['bicycle']['price'] ?? null,
		    'bicycle_color' => $this->resultParams['response']['bicycle_store']['bicycle']['color'] ?? null,
		    'book_title' => $this->resultParams['response']['book_store']['book'][0]['title'] ?? null,
		    'book_price' => $this->resultParams['response']['book_store']['book'][0]['price'] ?? null,
		];

		$uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, session_id() . time());
		$this->eventKey = strtoupper('event-' . $uuid->toString());
		$datas = ['event_key' => $this->eventKey, 'params' => $options['form_params']];
		RedisUtil::setDataWithExpire($this->redis, CommonConst::REDIS_SECURE_PROTOCOL_COMMAND, $this->eventKey, CommonConst::REDIS_SESSION_EXPIRE_TIME_MIN_5, $datas);

		try {
		    $secureData['form_params'] = ['event_key' => $this->eventKey];
		    $ret = $this->httpClient->request('POST', $targetUrl, $secureData);

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

		$result = [
		    'op_name' => '테스트 OP45654',
		    'request_target_url' => $targetUrl,
		    'server_status' => $resStatus,
		    'response' => [
		        'bicycle_store' => $resData['bicycle_store'] ?? null,
		    ]
		];
		return $result;
	}


	/**
	 * Operation Name : dev_op1
	 * ID : 23
	 * Description : dev_op1
	 * Binding Seq : 4
	 */
	private function _subCOKHCZND6B6B_SZJ3J2IZW4(Request $request, Response $response)
	{
		$targetUrl = 'https://www.naver.com/efwefwe';
		$options['verify'] = $this->httpReqVerify;
		$options['timeout'] = $this->httpReqTimeout;
		$options['form_params'] = [
		    'userKey' => $this->params['biz_user_key'] ?? null,
		    'signCode' => 'AAAAA',
		    'userName' => $this->params['biz_user_name'] ?? null,
		    'userBirth' => '19780814',
		];
		try {
		    $ret = $this->httpClient->request('POST', $targetUrl, $options);

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

		$result = [
		    'op_name' => 'dev_op1',
		    'request_target_url' => $targetUrl,
		    'server_status' => $resStatus,
		    'request' => $options['form_params'],
		    'response' => [
		        'result' => $resData['result'] ?? null,
		    ]
		];
		return $result;
	}


	/**
	 * Operation Name : dev_opt2
	 * ID : 24
	 * Description : dev_opt2
	 * Binding Seq : 5
	 */
	private function _subUTSEARAPB0_7X7Q2D5CR1W5(Request $request, Response $response)
	{
		$targetUrl = 'http://ec2-52-78-170-92.ap-northeast-2.compute.amazonaws.com/ga/getInsurancePremium';
		$options['verify'] = $this->httpReqVerify;
		$options['timeout'] = $this->httpReqTimeout;
		$options['form_params'] = [
		    'req_user_key' => $this->params['biz_user_key'] ?? null,
		    'req_usr_name' => $this->params['biz_user_name'] ?? null,
		    'req_result' => $this->resultParams['response']['bicycle_store']['bicycle']['color'] ?? null,
		];
		try {
		    $ret = $this->httpClient->request('POST', $targetUrl, $options);

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

		$result = [
		    'op_name' => 'dev_opt2',
		    'request_target_url' => $targetUrl,
		    'server_status' => $resStatus,
		    'request' => $options['form_params'],
		    'response' => [
		        'res_result' => $resData['res_result'] ?? null,
		    ]
		];
		return $result;
	}
}
