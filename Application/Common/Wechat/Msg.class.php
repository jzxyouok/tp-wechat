<?php
namespace Common\Wechat;

class Msg extends BaseWechat
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendText($data)
    {
        $tpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
        $msgType = "text";
        $time    = time();

        $resultStr = sprintf($tpl, $data['toUsername'], $data['fromUsername'], $time, $msgType, $data['contentStr']);
        \Think\Log::record($resultStr);
        return $resultStr;
    }

    public function sendImage($data)
    {
        $tpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Image>
							<MediaId><![CDATA[$s]]></MediaId>
							</Image>
							<FuncFlag>0</FuncFlag>
							</xml>";
        $msgType = "image";
        $time    = time();

        $resultStr = sprintf($textTpl, $data['toUsername'], $data['fromUsername'], $time, $msgType, $data['mediaId']);
        \Think\Log::record($resultStr);
        return $resultStr;
    }

    public function sendVoice($data)
    {

    }

    public function sendVideo($data)
    {

    }

    public function sendNews($data)
    {

    }

}
