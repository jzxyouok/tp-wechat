<?php
namespace Common\Wechat;

class Menu extends BaseWechat
{

    public function __construct()
    {
        parent::__construct();

    }

    public function getMenu($access_token)
    {
        $data = Curl::callWebServer($this->baseUrl . 'menu/get?access_token=' . $access_token, '', 'GET');

        if ($data['errcode'] != 0) {
            dump($data['errcode'] . '|' . C("ERR_CODE")[$data['errcode']]);
        } else {
            dump($data);
        }
    }
}
