<?php

namespace app\admin\services;

use think\App;
use app\model\AdminModel;
use app\admin\validate\AdminValidate;
use think\exception\ValidateException;
use think\facade\Db;

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
    public function getList($param): array
    {
        $where = [];
        if (!empty($param['username'])) {
            $where[] = ['username', '=', $param['username']];
        }
        try {
            $list = $this->model->with('role')->where($where)
                ->order('id desc')->paginate($param['limit'])
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
     */
    public function save($param): array
    {
        try {
            validate(AdminValidate::class)->scene('save')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }
        // 检查唯一
        $has = $this->model->where(['username' => $param['username']])->find();
        var_dump(
            $has
        );
die;

        $has = $this->model->checkUnique(['username' => $param['username']])['data'];
        if (!empty($has)) {
            return dataReturn(-2, '该登录名已存在');
        }

        $param['create_time'] = now();
        $param['salt'] = uniqid();
        $param['password'] = makePassword($param['password'], $param['salt']);

        $res = $adminModel->insertOne($param);
        if ($res['code'] != 0) {
            return $res;
        }

        return dataReturn(0, '添加成功');
    }

    /**
     * 编辑管理员
     * @param $param
     * @return array
     */
    public function editAdmin($param): array
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
    public function delAdmin($id): array
    {
        if ($id == 0) {
            return dataReturn(-1, '不可以删除超级管理员');
        }

        $adminModel = new SysAdmin();
        return $adminModel->delById($id);
    }
}