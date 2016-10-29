<?php
namespace Common\Wechat;

class BaseWechat
{
    protected function __construct()
    {
        $this->baseUrl = C('BASE_URL');
    }
}
