<?php

namespace app\admin\services;

use think\App;
use app\model\AdminModel;
use app\admin\validate\AdminValidate;
use think\exception\ValidateException;

class AdminService extends BasicService
{
    public function __construct(App $app, AdminModel $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 获取管理员列表
     * @param $param
     * @return array
     */
    public function list($param): array
    {
        $this->setParam($param);
        $limit = $this->getParam('limit', 0);
        $user_name = $this->getParam('username', '');

        $where = [];
        if (!empty($user_name)) {
            $where[] = ['username', '=', $user_name];
        }
        try {
            $list = $this->model->with('role')->where($where)
                ->order('id desc')->paginate($limit)
                ->toArray();
            return success($list);
        } catch (\Exception $e) {
            return failed($e->getMessage());
        }
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
        $has = $this->model->where(['username' => $user_name])->find();
        if (!empty($has)) return failed('该登录名已存在');

        $param['salt'] = uniqid();
        $param['create_time'] = nowDate();
        $param['password'] = makePass($param['password'], $param['salt']);
        $resp = $this->model->insertGetId($param);
        if ($resp <= 0) return failed('添加失败,请重新操作');

        // 事件记录操作日志
        event('AdminLog');

        return success();
    }

    /**
     * 编辑管理员
     * @param $param
     * @return array
     */
    public function edit($param): array
    {
        try {
            validate(AdminValidate::class)->scene('edit')->check($param);
        } catch (ValidateException $e) {
            return dataReturn(-1, $e->getError());
        }

        // 检查唯一
        $adminModel = new SysAdmin();
        $has = $adminModel->checkUnique(['username' => $param['username']], $param['id'])['data'];
        if (!empty($has)) {
            return dataReturn(-2, '该登录名已存在');
        }

        $param['update_time'] = now();

        if (!empty($param['password'])) {
            $param['salt'] = uniqid();
            $param['password'] = makePassword($param['password'], $param['salt']);
        } else {
            unset($param['password']);
        }

        $res = $adminModel->updateById($param, $param['id']);
        if ($res['code'] != 0) {
            return $res;
        }

        return dataReturn(0, '编辑成功');
    }

    /**
     * 删除管理员
     * @param $id
     * @return array
     */
    public function del($id): array
    {
        if ($id == 0) {
            return dataReturn(-1, '不可以删除超级管理员');
        }

        $adminModel = new SysAdmin();
        return $adminModel->delById($id);
    }
}