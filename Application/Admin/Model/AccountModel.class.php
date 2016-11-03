<?php
namespace Admin\Model;

use Think\Model;

class AccountModel extends Model
{
    /**
     * 自动验证
     * @var array
     */
    protected $_validate = array(
        array('appid', '', 'appid已经存在', 0, 'unique', 3),
        array('url', '', 'URL不能重复，否则消息接收处理会混乱', 0, 'unique', 3),
    );

    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('update_time', 'time', 3, 'function'),
    );

    /**
     * 获取数据
     * @param  [type] $map [description]
     * @return [type]      [description]
     */
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

    /**
     * 添加数据
     */
    public function addData()
    {
        $data = I('post.');
        if (!$this->create($data)) {
            return $this->getError();
        } else {
            $result = $this->data($data)->add();
            return true;
        }

    }

    /**
     * 编辑数据
     * @param  [type] $id   [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
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

    /**
     * 删除数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteData($id)
    {
        $this->where(array("id" => $id))->delete();
    }
}
