<?php

namespace app\admin\services\auth;

use think\App;
use app\model\AdminModel;
use app\admin\services\BasicService;
use think\exception\ValidateException;
use app\admin\validate\auth\AdminValidate;

class AdminService extends BasicService
{
    /**
     * 构造函数
     * @param App $app
     * @param AdminModel $model
     */
    public function __construct(App $app, AdminModel $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 获取管理员列表
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function list($param): array
    {
        $this->setParam($param);
        $page = $this->getParam('page', 1);
        $limit = $this->getParam('limit', 20);
        $user_name = $this->getParam('username', '');

        $where = [];
        if (!empty($user_name)) $where[] = ['username', '=', $user_name];

        $order = ['id' => 'desc'];
        $field = [
            'id', 'role_id', 'username', 'nickname', 'avatar', 'email', 'phone',
            'login_failure', 'last_login_time', 'last_login_ip', 'status', 'create_time'
        ];
        $model = $this->model->with('role')->field($field)->where($where)->order($order);
        $count = $model->count('id');
        $list = $model->page($page, $limit)->select()->toArray();

        return success([
            'list' => $list,
            'page' => $page,
            'limit' => $limit,
            'count' => $count,
        ]);
    }

    /**
     * 添加管理员
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save($param): array
    {
        try {
            validate(AdminValidate::class)->scene('save')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }
        // 参数提取
        $this->setParam($param);
        $user_name = $this->getParam('username', '');

        // 检查唯一
        if ($this->model->where(['username' => $user_name])->find()) {
            return failed('This account already exists');
        }

        $param['salt'] = uniqid();
        $param['create_time'] = nowDate();
        $param['password'] = makePass($param['password'], $param['salt']);
        if (!$this->model->insertGetId($param)) {
            return failed('The operation failed, please try again');
        }

        // 事件记录操作日志
        event('AdminLog');

        return success();
    }

    /**
     * 编辑管理员
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit($param): array
    {
        try {
            validate(AdminValidate::class)->scene('edit')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }

        // 参数提取
        $this->setParam($param);
        $id = $this->getParam('id', '');

        // 密码处理
        if (empty($param['password'])) {
            unset($param['password']);
        } else {
            $param['salt'] = uniqid();
            $param['password'] = makePass($param['password'], $param['salt']);
        }
        $param['update_time'] = nowDate();
        if (!$this->model->where(['id' => $id])->update($param)) {
            return failed('The operation failed, please try again');
        }

        return success();
    }

    /**
     * 删除管理员
     * @param $param
     * @return array
     */
    public function delete($param): array
    {
        try {
            validate(AdminValidate::class)->scene('delete')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }

        // 参数提取
        $this->setParam($param);
        $id = $this->getParam('id', '');
        if ($id == 1) return failed('Cannot delete super administrator');

        $param['is_delete'] = 1;
        $param['update_time'] = nowDate();
        if (!$this->model->where(['id' => $id])->update($param)) {
            return failed('The operation failed, please try again');
        }
        return success();
    }
}