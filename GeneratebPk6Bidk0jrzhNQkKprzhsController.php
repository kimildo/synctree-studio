<?php

/**
 * This file is Created by Ntuple GeneratedEngine.
 * 2019-03-25 12:33:03
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
	const BIZOPS = '{"app_id":5,"biz_id":51,"biz_uid":"bPk6Bidk0jrzhNQkKprzhs","biz_name":"DEV_BIZ3","biz_desc":"DEV_BIZ3_DESC","actor_alias":"DEV-Consumer","method":2,"req_method":1,"reg_date":"2019-03-05 16:14:50","request":[{"param_id":642,"req_key":"biz_user_key","req_var_type":"INT","req_desc":"description"},{"param_id":643,"req_key":"biz_user_name","req_var_type":"STR","req_desc":"description"},{"param_id":816,"req_key":"biz_user_json","req_var_type":"JSN","req_desc":""}],"operators":{"1":{"binding_seq":1,"operation_id":77,"operation_key":"w0EZbM1hWM8WLmzIQ9HhWg","operation_namespace_id":13,"operation_namespace_name":"AIG11","header_transfer_type_code":1,"operation_name":"테스트 OP","operation_description":"테스트 OP","protocol_type_code":2,"request_method_code":2,"auth_type_code":0,"auth_keys":null,"control_container_code":0,"control_container_info":null,"op_id":77,"op_key":"w0EZbM1hWM8WLmzIQ9HhWg","op_name":"테스트 OP","op_ns_name":"AIG11","op_desc":"테스트 OP","method":2,"req_method":"P","regist_date":"2019-03-04 11:12:42","modify_date":"2019-03-21 14:09:46","target_url":"https:\/\/3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io\/getJson","request":[{"param_id":627,"param_seq":1,"req_key":"user_key","req_var_type":"INT","req_desc":"user_key","sub_parameter_format":null},{"param_id":775,"param_seq":2,"req_key":"user_name","req_var_type":"STR","req_desc":"user_name","sub_parameter_format":null},{"param_id":818,"param_seq":3,"req_key":"user_ename","req_var_type":"STR","req_desc":"","sub_parameter_format":null}],"response":[{"param_id":628,"param_seq":4,"res_key":"book_store","res_var_type":"JSN","res_desc":"result json","sub_parameter_format":{"book":[{"price":8.95,"title":"Sayings of the Century","author":"Nigel Rees","category":"reference","available":true},{"price":12.99,"title":"Sword of Honour","author":"Evelyn Waugh","category":"fiction","available":false},{"isbn":"0-553-21311-3","price":8.99,"title":"Moby Dick","author":"Herman Melville","category":"fiction","available":true},{"isbn":"0-395-19395-8","price":22.99,"title":"The Lord of the Rings","author":"J. R. R. Tolkien","category":"fiction","available":false}]}},{"param_id":771,"param_seq":5,"res_key":"bicycle_store","res_var_type":"JSN","res_desc":"","sub_parameter_format":{"bicycle":{"color":"red","price":19.95,"available":true}}}],"arguments":[{"parameter_id":627,"parameter_seq":1,"parameter_key_name":"user_key","parameter_type_code":1,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":2,"relay_operation_id":null,"relay_biz_ops_id":51,"relay_object_name":"DEV_BIZ3","relay_parameter_id":642,"relay_parameter_key_name":"biz_user_key","relay_parameter_type_code":1,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":775,"parameter_seq":2,"parameter_key_name":"user_name","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":2,"relay_operation_id":null,"relay_biz_ops_id":51,"relay_object_name":"DEV_BIZ3","relay_parameter_id":816,"relay_parameter_key_name":"biz_user_json","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"name\": \"\", \"token\": \"\", \"userId\": 0, \"nameEng\": \"\"}","relay_sub_parameter_path":"$.name"},{"parameter_id":818,"parameter_seq":3,"parameter_key_name":"user_ename","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":2,"relay_operation_id":null,"relay_biz_ops_id":51,"relay_object_name":"DEV_BIZ3","relay_parameter_id":816,"relay_parameter_key_name":"biz_user_json","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"name\": \"\", \"token\": \"\", \"userId\": 0, \"nameEng\": \"\"}","relay_sub_parameter_path":"$.nameEng"}]},"2":{"binding_seq":2,"operation_id":82,"operation_key":"BfggMp7j42btsj2redIKKA","operation_namespace_id":1,"operation_namespace_name":"AIG","header_transfer_type_code":1,"operation_name":"테스트 OP45654","operation_description":"테스트 OP","protocol_type_code":1,"request_method_code":2,"auth_type_code":0,"auth_keys":"[{\"env\": \"dev\", \"token\": \"eeee\"}]","control_container_code":0,"control_container_info":null,"op_id":82,"op_key":"BfggMp7j42btsj2redIKKA","op_name":"테스트 OP45654","op_ns_name":"AIG","op_desc":"테스트 OP","method":1,"req_method":"P","regist_date":"2019-03-05 16:02:58","modify_date":"2019-03-22 12:50:38","target_url":"https:\/\/3069d955-08a7-4052-8f61-a83f488a32a6.mock.pstmn.io\/getJson","request":[{"param_id":639,"param_seq":1,"req_key":"bicycle_price","req_var_type":"INT","req_desc":"bicycle_price","sub_parameter_format":null},{"param_id":647,"param_seq":2,"req_key":"bicycle_color","req_var_type":"STR","req_desc":"bicycle_color","sub_parameter_format":null},{"param_id":772,"param_seq":3,"req_key":"book_title","req_var_type":"STR","req_desc":"","sub_parameter_format":null},{"param_id":773,"param_seq":4,"req_key":"book_price","req_var_type":"INT","req_desc":"","sub_parameter_format":null}],"response":[{"param_id":640,"param_seq":5,"res_key":"bicycle_store","res_var_type":"JSN","res_desc":"result json","sub_parameter_format":{"bicycle":{"color":"red","price":19.95,"available":true}}}],"arguments":[{"parameter_id":639,"parameter_seq":1,"parameter_key_name":"bicycle_price","parameter_type_code":1,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":1,"relay_operation_id":77,"relay_biz_ops_id":null,"relay_object_name":"테스트 OP","relay_parameter_id":771,"relay_parameter_key_name":"bicycle_store","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"bicycle\": {\"color\": \"red\", \"price\": 19.95, \"available\": true}}","relay_sub_parameter_path":"$.bicycle.price"},{"parameter_id":647,"parameter_seq":2,"parameter_key_name":"bicycle_color","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":1,"relay_operation_id":77,"relay_biz_ops_id":null,"relay_object_name":"테스트 OP","relay_parameter_id":771,"relay_parameter_key_name":"bicycle_store","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"bicycle\": {\"color\": \"red\", \"price\": 19.95, \"available\": true}}","relay_sub_parameter_path":"$.bicycle.color"},{"parameter_id":772,"parameter_seq":3,"parameter_key_name":"book_title","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":1,"relay_operation_id":77,"relay_biz_ops_id":null,"relay_object_name":"테스트 OP","relay_parameter_id":628,"relay_parameter_key_name":"book_store","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"book\": [{\"price\": 8.95, \"title\": \"Sayings of the Century\", \"author\": \"Nigel Rees\", \"category\": \"reference\", \"available\": true}, {\"price\": 12.99, \"title\": \"Sword of Honour\", \"author\": \"Evelyn Waugh\", \"category\": \"fiction\", \"available\": false}, {\"isbn\": \"0-553-21311-3\", \"price\": 8.99, \"title\": \"Moby Dick\", \"author\": \"Herman Melville\", \"category\": \"fiction\", \"available\": true}, {\"isbn\": \"0-395-19395-8\", \"price\": 22.99, \"title\": \"The Lord of the Rings\", \"author\": \"J. R. R. Tolkien\", \"category\": \"fiction\", \"available\": false}]}","relay_sub_parameter_path":"$.book[0].title"},{"parameter_id":773,"parameter_seq":4,"parameter_key_name":"book_price","parameter_type_code":1,"sub_parameter_format":null,"relay_flag":1,"argument_value":null,"relay_object_code":1,"relay_operation_id":77,"relay_biz_ops_id":null,"relay_object_name":"테스트 OP","relay_parameter_id":628,"relay_parameter_key_name":"book_store","relay_parameter_type_code":5,"relay_sub_parameter_format":"{\"book\": [{\"price\": 8.95, \"title\": \"Sayings of the Century\", \"author\": \"Nigel Rees\", \"category\": \"reference\", \"available\": true}, {\"price\": 12.99, \"title\": \"Sword of Honour\", \"author\": \"Evelyn Waugh\", \"category\": \"fiction\", \"available\": false}, {\"isbn\": \"0-553-21311-3\", \"price\": 8.99, \"title\": \"Moby Dick\", \"author\": \"Herman Melville\", \"category\": \"fiction\", \"available\": true}, {\"isbn\": \"0-395-19395-8\", \"price\": 22.99, \"title\": \"The Lord of the Rings\", \"author\": \"J. R. R. Tolkien\", \"category\": \"fiction\", \"available\": false}]}","relay_sub_parameter_path":"$.book[0].price"}]},"4":{"binding_seq":4,"operation_id":23,"operation_key":"CoKHczND6B6B_SZj3J2Izw","operation_namespace_id":2,"operation_namespace_name":"AIG1","header_transfer_type_code":1,"operation_name":"dev_op1","operation_description":"dev_op1","protocol_type_code":2,"request_method_code":2,"auth_type_code":1,"auth_keys":null,"control_container_code":1,"control_container_info":"{\"value\": \"15\", \"operator\": 2, \"control_id\": 37}","op_id":23,"op_key":"CoKHczND6B6B_SZj3J2Izw","op_name":"dev_op1","op_ns_name":"AIG1","op_desc":"dev_op1","method":2,"req_method":"P","regist_date":"2019-01-08 16:17:29","modify_date":"2019-03-05 16:09:45","target_url":"https:\/\/www.naver.com\/efwefwe","request":[{"param_id":118,"param_seq":1,"req_key":"userKey","req_var_type":"INT","req_desc":"","sub_parameter_format":null},{"param_id":205,"param_seq":2,"req_key":"signCode","req_var_type":"STR","req_desc":"token","sub_parameter_format":null},{"param_id":295,"param_seq":3,"req_key":"userName","req_var_type":"STR","req_desc":"","sub_parameter_format":null},{"param_id":296,"param_seq":4,"req_key":"userBirth","req_var_type":"STR","req_desc":"","sub_parameter_format":null}],"response":[{"param_id":126,"param_seq":5,"res_key":"result","res_var_type":"JSN","res_desc":"","sub_parameter_format":null}],"arguments":[{"parameter_id":118,"parameter_seq":1,"parameter_key_name":"userKey","parameter_type_code":1,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":205,"parameter_seq":2,"parameter_key_name":"signCode","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":295,"parameter_seq":3,"parameter_key_name":"userName","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":296,"parameter_seq":4,"parameter_key_name":"userBirth","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null}]},"5":{"binding_seq":5,"operation_id":24,"operation_key":"uTSEARaPB0_7X7q2d5cr1w","operation_namespace_id":1,"operation_namespace_name":"AIG","header_transfer_type_code":1,"operation_name":"dev_opt2","operation_description":"dev_opt2","protocol_type_code":2,"request_method_code":2,"auth_type_code":2,"auth_keys":null,"control_container_code":1,"control_container_info":"{\"value\": \"15\", \"operator\": 5, \"control_id\": 37}","op_id":24,"op_key":"uTSEARaPB0_7X7q2d5cr1w","op_name":"dev_opt2","op_ns_name":"AIG","op_desc":"dev_opt2","method":2,"req_method":"P","regist_date":"2019-01-09 14:41:14","modify_date":"2019-03-22 16:36:06","target_url":"http:\/\/ec2-52-78-170-92.ap-northeast-2.compute.amazonaws.com\/ga\/getInsurancePremium","request":[{"param_id":83,"param_seq":1,"req_key":"req_user_key","req_var_type":"INT","req_desc":"key","sub_parameter_format":null},{"param_id":84,"param_seq":2,"req_key":"req_usr_name","req_var_type":"STR","req_desc":"name","sub_parameter_format":null},{"param_id":206,"param_seq":3,"req_key":"req_result","req_var_type":"STR","req_desc":"","sub_parameter_format":null}],"response":[{"param_id":85,"param_seq":4,"res_key":"data","res_var_type":"JSN","res_desc":"","sub_parameter_format":{"message":""}}],"arguments":[{"parameter_id":83,"parameter_seq":1,"parameter_key_name":"req_user_key","parameter_type_code":1,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":84,"parameter_seq":2,"parameter_key_name":"req_usr_name","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null},{"parameter_id":206,"parameter_seq":3,"parameter_key_name":"req_result","parameter_type_code":2,"sub_parameter_format":null,"relay_flag":null,"argument_value":null,"relay_object_code":null,"relay_operation_id":null,"relay_biz_ops_id":null,"relay_object_name":null,"relay_parameter_id":null,"relay_parameter_key_name":null,"relay_parameter_type_code":null,"relay_sub_parameter_format":null,"relay_sub_parameter_path":null}]}},"lines":[],"user_id":"owner@nntuple.com","account_id":5,"team_id":1,"controls":[{"control_alt_id":37,"binding_seq":3,"parameter_id":640,"object_code":1,"biz_ops_id":null,"biz_ops_name":null,"operation_id":82,"operation_namespace_id":1,"operation_name":"테스트 OP45654","direction_code":2,"parameter_key_name":"bicycle_store","parameter_type_code":5,"sub_parameter_format":"{\"bicycle\": {\"color\": \"red\", \"price\": 19.95, \"available\": true}}","sub_parameter_path":"$.bicycle.price","control_alt_description":"price"}]}';

	private $eventKey;

	private $resultParams;

	private $params;


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

			$responseDatas = [];
		    $result['request'] = [
		        'actor_alias' => $bizOps['actor_alias'] ?? null,
		        'request' => $this->params,
		    ];
		    $this->params['biz_user_json'] = CommonUtil::getValidJSON($this->params['biz_user_json']);

		    $responseDatas[] = $this->resultParams = $this->_subW0EZBM1HWM8WLMZIQ9HHWG1($request, $response);
		    $responseDatas[] = $this->resultParams = $this->_subBFGGMP7J42BTSJ2REDIKKA2($request, $response);

		    switch (true) {
		        case ($this->resultParams['response']['bicycle_store']['bicycle']['price'] > '15') :
		              $responseDatas[] = $this->resultParams = $this->_subCOKHCZND6B6B_SZJ3J2IZW4($request, $response);
		              break;
		        case ($this->resultParams['response']['bicycle_store']['bicycle']['price'] <= '15') :
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

		$ret = $this->_httpRequest($targetUrl, $options, 'POST');

		$result = [
		    'op_name' => '테스트 OP',
		    'request_target_url' => $targetUrl,
		    'server_status' => $ret['res_status'],
		    'request' => $options['form_params'],
		    'response' => [
		        'book_store' => $ret['res_data']['book_store'] ?? null,
		        'bicycle_store' => $ret['res_data']['bicycle_store'] ?? null,
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

		$secureData['form_params'] = ['event_key' => $this->eventKey];
		$ret = $this->_httpRequest($targetUrl, $secureData, 'POST');

		$result = [
		    'op_name' => '테스트 OP45654',
		    'request_target_url' => $targetUrl,
		    'server_status' => $ret['res_status'],
		    'response' => [
		        'bicycle_store' => $ret['res_data']['bicycle_store'] ?? null,
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
		    'userKey' => '',
		    'signCode' => '',
		    'userName' => '',
		    'userBirth' => '',
		];

		$ret = $this->_httpRequest($targetUrl, $options, 'POST');

		$result = [
		    'op_name' => 'dev_op1',
		    'request_target_url' => $targetUrl,
		    'server_status' => $ret['res_status'],
		    'request' => $options['form_params'],
		    'response' => [
		        'result' => $ret['res_data']['result'] ?? null,
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
		    'req_user_key' => '',
		    'req_usr_name' => '',
		    'req_result' => '',
		];

		$ret = $this->_httpRequest($targetUrl, $options, 'POST');

		$result = [
		    'op_name' => 'dev_opt2',
		    'request_target_url' => $targetUrl,
		    'server_status' => $ret['res_status'],
		    'request' => $options['form_params'],
		    'response' => [
		        'data' => $ret['res_data']['data'] ?? null,
		    ]
		];

		return $result;
	}
}
