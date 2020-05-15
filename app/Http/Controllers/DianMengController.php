<?php
/**
 * Created by PhpStorm.
 * User: linlin
 * Date: 2019-09-10
 * Time: 17:09
 */
namespace App\Http\Controllers;

use App\Extensions\DMBizMsgCrypt;

class DianMengController extends Controller{


    public function test(){
    // 第三方发送消息给公众平台
        $encodingAesKey = "ey5PibbjucdWKEso1qqlsOGwPm1MmWYbIxStVBBXHDm";
        $timeStamp = time();
        $nonce = $this->getRandCode();
        $appId = "1159401917542096897";
    //【attention】加密的消息体为json格式
        $text = "{\"spmc\":\"办公用品\",\"num\":1,\"size\":10}";

    //【attention】此处入参参数key 和appid
        $pc = new DMBizMsgCrypt($encodingAesKey, $appId);
        $encryptMsg = '';
        list($errCode,$encrypt,$signature) = $pc->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
        if ($errCode == 0) {
            $json_arr = [
                'appId'=>'1159401917542096897',
                'encrypt'=>$encrypt,
                'sign'=>$signature,
                'nonce'=>$nonce,
                'timeStamp'=>$timeStamp,
            ];
            $json = json_encode($json_arr,true);
            echo '<pre>';
            print_r($json);
            exit;
            //print("加密后: " . $encrypt . "\n"."签名：".$signature);
        } else {
            print($errCode . "\n");
        }
        exit;
    //【attention】加密后调用接口的入参参数格式  参考店盟开放平台加解密文档 以及电子发票接口文档



    }

    public function testDecrypt(){

        $encodingAesKey = "ey5PibbjucdWKEso1qqlsOGwPm1MmWYbIxStVBBXHDm";
        $timeStamp = '1568107667';//time();
        $nonce = 'gnCS871rPaR20aXQ';//$this->getRandCode();
        $appId = "1159401917542096897";
        //【attention】加密的消息体为json格式

        $pc = new DMBizMsgCrypt($encodingAesKey, $appId);
        $from_data = '';
    // 第三方收到公众号平台发送的消息
        $msg = '';
    //【attention】from_data 对应加密后的密文数据

        //测试数据
        $msg_sign = '3f40b1d733fcafb8688e348daacf27720c08909a';
        $from_data = '4Z6qSZbb8Olw6yb1iMBm24SpTLFYWSrAOtm41ZbVTtqcXgMW9RKreQqFNHh1rO0/dkGu3nqsNioimCjHWoUfBwMVVJ5u2OMpQnGokmHN3r/1Pz4ExTJe61VSMubvTVM+';
        //解密了请求参数

        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_data, $msg);
        if ($errCode == 0) {
            print("解密后: " . $msg . "\n");
        } else {
            print($errCode . "\n");
        }
    }

    public function getRandCode()
    {
        $charts = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz0123456789";
        $max = strlen($charts);
        $noncestr = "";
        for($i = 0; $i < 16; $i++)
        {
            $noncestr .= $charts[mt_rand(0, $max)];
        }


        return $noncestr;
    }
}