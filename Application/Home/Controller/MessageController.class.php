<?php
namespace Home\Controller;

use Common\Wechat\Msg;
use Think\Controller;

class MessageController extends Controller
{
    public function handler()
    {
        $account = M('Account')->where(array('appid' => I('get.appid')))->find();

        if (isset($_GET["echostr"])) {
            $echoStr = $_GET["echostr"];

            // \Think\Log::record($_GET, 'INFO');

            if ($this->checkSignature($account['token'])) {
                echo $echoStr;
                exit;
            }
        } else {
            $this->responseMsg($account);
        }
    }

    private function responseMsg($account)
    {
        $postStr = file_get_contents('php://input');

        if (!empty($postStr)) {

            // 处理用户发送过来的消息（XML格式），获取里面的变量
            libxml_disable_entity_loader(true);
            $postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername   = $postObj->ToUserName;
            $keyword      = trim($postObj->Content);
            $time         = time();
            $msgType      = $postObj->MsgType;
            $event        = $postObj->Event;
            $eventKey     = $postObj->EventKey;

            // $keyword 是用户发送的消息内容（文本）
            if (!empty($keyword)) {
                $msg = new Msg();
                echo $msg->sendText(array('fromUsername' => $toUsername, 'toUsername' => $fromUsername, 'contentStr' => 'bbbb' . $account['description']));
            } else {
                //echo "请输入一些东西";
                //如果收到用户发送过来的内容为空，可能是订阅、取消订阅事件，或者是发送了一张图片

                //处理事件
                if ($msgType == 'event') {
                    //处理订阅事件
                    if ($event == 'subscribe') {
                        $msgType    = "text";
                        $contentStr = '谢谢你订阅';
                        $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }
                }
            }

        } else {
            echo "用户发送的消息为空内容";
            exit;
        }
    }

    private function checkSignature($token)
    {
        // you must define TOKEN by yourself
        // if (!defined("TOKEN")) {
        //     throw new Exception('TOKEN is not defined!');
        // }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $token  = defined("TOKEN") ? TOKEN : $token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
