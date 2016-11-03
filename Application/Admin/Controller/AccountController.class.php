<?php
namespace Admin\Controller;

use Common\Wechat\AccessToken;
use Common\Wechat\Menu;
use Common\Wechat\User;
use Think\Controller;

class AccountController extends Controller
{
    /**
     * 公众号管理页面
     * @return [type] [description]
     */
    public function index()
    {
        $modelAccount = D('Account');

        $data['accounts'] = $modelAccount->getData();

        $this->assign($data);
        $this->display('Admin_accounts');
    }

    /**
     * 添加公众号
     */
    public function add()
    {
        D('Account')->addData();

        $this->success('操作成功', U('Account/index'));
    }

    /**
     * 编辑公众号
     * @return [type] [description]
     */
    public function edit()
    {
        $id   = I('get.id');
        $data = array(I('get.name') => I('get.value'));

        $result = D('Account')->editData($id, $data);

        $this->ajaxReturn($result === true ? array('code' => 200, 'msg' => '操作成功') : array('code' => 1001, 'msg' => '发生错误' . $result));
    }

    /**
     * 删除公众号
     * @return [type] [description]
     */
    public function delete()
    {
        D('Account')->deleteData(I('get.id'));
        $this->success('删除成功', U('Account/index'));
    }

    /**
     * 强制更新 access_token
     * @return [type] [description]
     */
    public function updateAccessToken()
    {
        $account     = D('Account')->getDataById(I('get.id'));
        $accessToken = AccessToken::getInstance($account['appid'], $account['secretkey']);

        S('access_token_' . $account['appid'], null);

        $access_token = $accessToken->getAccessToken();
    }

    /**
     * 获取菜单
     * @return [type] [description]
     */
    public function getMenu()
    {
        $account     = D('Account')->getDataById(I('get.id'));
        $accessToken = AccessToken::getInstance($account['appid'], $account['secretkey']);

        $access_token = $accessToken->getAccessToken();

        $menu = new Menu();
        $menu->getMenu($access_token);
    }

    /**
     * 获取用户列表
     * @return [type] [description]
     */
    public function getUserList()
    {
        $account     = D('Account')->getDataById(I('get.id'));
        $accessToken = AccessToken::getInstance($account['appid'], $account['secretkey']);

        $access_token = $accessToken->getAccessToken();

        $user = new User();
        $user->getUserList($access_token);
    }
}
