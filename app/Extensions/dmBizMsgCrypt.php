<?php

/**
 * 对公众平台发送给公众账号的消息加解密示例代码.
 */

namespace App\Extensions;

use App\Extensions\SHA1;
use App\Extensions\pkcs7Encoder;
use App\Extensions\Prpcrypt;
use App\Extensions\errorCode;
/**
 * 1.第三方回复加密消息给公众平台；
 * 2.第三方收到公众平台发送的消息，验证消息的安全性，并对消息进行解密。
 */
class DMBizMsgCrypt
{

	private $token;
	private $encodingAesKey;
	private $appId;

	/**
	 * 构造函数
	 * @param $token string 
	 * @param $encodingAesKey string 公众平台上，开发者设置的EncodingAESKey
	 * @param $appId string 公众平台的appId
	 */
	public function __construct($encodingAesKey, $appId)
	{
		//【attention】将key赋值给token
		$this->token = $encodingAesKey;

		$this->encodingAesKey = $encodingAesKey;
		$this->appId = $appId;
	}

	/**
	 * 将公众平台回复用户的消息加密打包.

	 *
	 * @param $replyMsg string 待加密数据
	 * @param $timeStamp string 时间戳
	 * @param $nonce string 随机串
	 * @param &$encryptMsg string 加密后的可以直接回复用户的密文，
	 *                      当return返回0时有效
	 *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function encryptMsg($replyMsg, $timeStamp, $nonce, &$encryptMsg)
	{
	    //new Prpcrypt();
		$pc = new Prpcrypt($this->encodingAesKey);

		//加密
		$array = $pc->encrypt($replyMsg, $this->appId);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}

		if ($timeStamp == null) {
			$timeStamp = time();
		}
		//【attention】加密后的字符串
		$encrypt = $array[1];

		//生成安全签名
		$sha1 = new SHA1;

		$array = $sha1->getSHA1($this->token, $timeStamp, $nonce, $encrypt);
		$ret = $array[0];
		if ($ret != 0) {
			return $ret;
		}
		$signature = $array[1];

		//【attention】需要将生成的签名 和加密后的字符串以及时间戳等信息返回 按照店盟开放平台参数要求调用接口 20190909 11:15



//		$xmlparse = new XMLParse;
//		$encryptMsg = $xmlparse->generate($encrypt, $signature, $timeStamp, $nonce);
		return array(ErrorCode::$OK,$encrypt,$signature);
	}


	/**
	 * 检验消息的真实性，并且获取解密后的明文.
	 *
	 * @param $msgSignature string 签名串
	 * @param $timestamp string 时间戳 
	 * @param $nonce string 随机串
	 * @param $postData string 密文
	 * @param &$msg string 解密后的原文，当return返回0时有效
	 *
	 * @return int 成功0，失败返回对应的错误码
	 */
	public function decryptMsg($msgSignature, $timestamp = null, $nonce, $postData, &$msg)
	{
		if (strlen($this->encodingAesKey) != 43) {
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt($this->encodingAesKey);


		//验证安全签名
		$sha1 = new SHA1;
		$array = $sha1->getSHA1($this->token, $timestamp, $nonce, $postData);
		$ret = $array[0];

		if ($ret != 0) {
			return $ret;
		}

		$signature = $array[1];
		if ($signature != $msgSignature) {
			return ErrorCode::$ValidateSignatureError;
		}
		//【attention】解密明文信息
		$result = $pc->decrypt($postData, $this->appId);
		if ($result[0] != 0) {
			return $result[0];
		}
		
		//【attention】需要返回解密后的明文信息
		$msg = $result[1];

		return array(ErrorCode::$OK,$msg);
	}

}

