<?php
namespace Common\Wechat;

class AccessToken extends BaseWechat
{
    //单例
    private static $_instance;

    protected $appid;
    protected $secretKey;
    protected $baseUrl;
    protected $getAccessTokenUrl;

    protected function __construct($appid, $secretKey)
    {
        parent::__construct();
        $this->appid     = $appid;
        $this->secretKey = $secretKey;
    }

    public function __clone()
    {
        throw new Exception("Singleton Class Can Not Be Cloned");
    }

    public static function getInstance($appid, $secretKey)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AccessToken($appid, $secretKey);
        }
        return self::$_instance;
    }

    public function getAccessToken()
    {
        $this->getAccessTokenUrl = $this->baseUrl . 'token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secretKey;

        if (S('access_token_' . $this->appid)) {
            \Think\Log::record("get access_token from cache", 'INFO');

        } else {
            \Think\Log::record("get new access_token by curl", 'INFO');

            $data = Curl::callWebServer($this->getAccessTokenUrl, '', 'GET');
            if ($data['access_token']) {
                S('access_token_' . $this->appid, $data['access_token'], C('ACCESS_TOKEN_EXPIRE_TIME'));

                M('Account')->where(array('appid' => $this->appid))->data(array('access_token' => $data['access_token'], 'expire_time' => time() + C('ACCESS_TOKEN_EXPIRE_TIME')))->save();
            }

        }

        return S('access_token_' . $this->appid);
    }
}
