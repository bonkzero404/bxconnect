<?php

namespace BxConnect;

class BlackxperienceAuth {

	CONST BX_SERVER	= "http://connect.blackxperience.com/development/Public/";

	private static $clientId;
	private static $callbackUrl;

	public function __construct($arrayData = array())
	{
		if (is_array($arrayData)) {
			$url = self::BX_SERVER . "auth";		
			
			session_name($arrayData["CLIENT_ID"]);
			session_start();
			
			$uniqueId = uniqid() . self::generatePassword(32) . md5(date('Y-m-d H:i:s'));

			if (@$_SESSION['uniqid'] == NULL) $_SESSION['uniqid'] = $uniqueId;

			if (@$_SESSION['bxkey'] == NULL) {

				$data = array (
					'cid' => $arrayData["CLIENT_ID"],
				    'ckey' => $arrayData["CLIENT_KEY"],
				    'cname' => $arrayData["CLIENT_APP_NAME"],
				    'fbAppId' => $arrayData["FB_APP_ID"],
				    'fbAppSecret' => $arrayData["FB_APP_SECRET"],
				    'twConsumerId' => $arrayData["TW_CONSUMER_ID"],
				    'twConsumerSecret' => $arrayData["TW_CONSUMER_SECRET"],
				    'tokenAvailable' => false,
				    'uniqid' => $_SESSION['uniqid']
				);
			}
			else {
				$data = array (
					'cid' =>  $arrayData["CLIENT_ID"],
				    'ckey' =>  $arrayData["CLIENT_KEY"],
				    'cname' =>  $arrayData["CLIENT_APP_NAME"],
				    'fbAppId' =>  $arrayData["FB_APP_ID"],
				    'fbAppSecret' =>  $arrayData["FB_APP_SECRET"],
				    'twConsumerId' =>  $arrayData["TW_CONSUMER_ID"],
				    'twConsumerSecret' =>  $arrayData["TW_CONSUMER_SECRET"],
				    'tokenAvailable' => $_SESSION['bxkey'],
				    'uniqid' => $_SESSION['uniqid']
				);
			}

			$data = self::objectToArray(json_decode(self::curlData($url, $data)));
			$_SESSION['bxkey'] = $data['tokenKey'];

			return $data;
		}
	}

	public static function setCallbackUrl($callback)
	{
		self::$callbackUrl = $callback;
		return self::$callbackUrl;
	}

	public static function userAuth($sessid)
	{
		$url = self::BX_SERVER . "fetch-user";

		$data = array(
			'BX_USER_DATA' => $_SESSION['bxkey'],
			'BX_UNIQ_ID' => $_SESSION['uniqid']
		);

		return self::objectToArray(json_decode(self::curlData($url, $data)));
	}

	public static function getUserData()
	{
		if (isset($_SESSION['bxkey'])) {
			$data = self::userAuth($_SESSION['bxkey']);

			if (isset($data['signal'])) {
				return false;
			}
			else {
				return $data;
			}
		}
		else {
			return false;
		}
	}

	public static function logoutData()
	{
		$url = self::BX_SERVER . "logout-user";

		$data = array(
			'BX_USER_DATA' => $_SESSION['bxkey']
		);

		$cData = self::curlData($url, $data);
		unset ($_SESSION['bxkey']);
		unset ($_SESSION['uniqid']);

		return json_decode($cData);
	}

	private static function getErrorStatus($status_code)
	{
		if ($status_code == '1000') {
			$data = array (
				'code' => '1000',
				'status' => 'Access denied'
			);
		}
		else if ($status_code == '1010') {
			$data = array (
				'code' => '1010',
				'status' => 'Client does not registered'
			);
		}
		else if ($status_code == '1020') {
			$data = array (
				'code' => '1020',
				'status' => 'All fields is required'
			);
		}

		return (array) $data;
	}

	public static function getForgotPassUrl()
	{
		return self::BX_SERVER . 'forgot-password/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	public static function getEmailLoginUrl()
	{
		return self::BX_SERVER . 'user-login/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	public static function twitterUrl()
	{
		return self::BX_SERVER . 'twitter-login/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	public static function facebookUrl()
	{
		return self::BX_SERVER . 'facebook-login/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	public static function registerUrl()
	{
		return self::BX_SERVER . 'register/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	public static function updateUserUrl()
	{
		$userdata = self::getUserData();
		return self::BX_SERVER . 'profile/' . $userdata['username'] . '/' . $_SESSION['bxkey'] . '?callback_url=' . self::$callbackUrl;
	}

	private static function curlData($url, $data)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		$contents = curl_exec($ch);
		curl_close($ch);

		return $contents;
	}

	private static function objectToArray($data)
	{
	    if (is_array($data) || is_object($data))
	    {
	        $result = array();
	        foreach ($data as $key => $value)
	        {
	            $result[$key] = self::objectToArray($value);
	        }
	        return $result;
	    }
	    return $data;
	}

	private static function generatePassword($length = 10)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
}