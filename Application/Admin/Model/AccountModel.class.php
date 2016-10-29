<?php
namespace Admin\Model;

use Think\Model;

class AccountModel extends Model
{
    protected $_validate = array(
        array('appid', '', 'appid已经存在', 0, 'unique', 3),
        array('url', '', 'URL不能重复，否则消息接收处理会混乱', 0, 'unique', 3),
    );

    protected $_auto = array(
        array('update_time', 'time', 3, 'function'),
    );

    public function getData($map)
    {
        $accounts = $this->where($map)->select();
        return $accounts;
    }

    public function getDataById($id)
    {
        $account = $this->where(array('id' => $id))->find();
        return $account;
    }

    public function addData()
    {
        $data = I('post.');
        if (!$this->create($data)) {
            return $this->getError();
        } else {
            return $this->data($data)->add();
        }

    }

    public function editData($id, $data)
    {
        if (!$this->create($data)) {
            return $this->getError();
        } else {
            $map    = array("id" => $id);
            $result = $this->where($map)->data($data)->save();
            return true;
        }

    }

    public function deleteData($map)
    {
        $this->where($map)->delete();
    }
}
