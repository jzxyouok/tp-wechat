<?php
namespace Common\Wechat;

class Material extends BaseWechat
{

    public function __construct()
    {
        parent::__construct();

    }

    public function getUserList($access_token)
    {
        $data = Curl::callWebServer($this->baseUrl . 'user/get?access_token=' . $access_token . '&next_openid=', '', 'GET');

        if ($data['errcode'] != 0) {
            dump($data['errcode'] . '|' . C("ERR_CODE")[$data['errcode']]);
        } else {
            dump($data);
        }
    }
}
