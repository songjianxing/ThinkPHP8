<?php

namespace app\admin\services;

use think\App;
use app\model\MenuModel;
use app\admin\validate\MenuValidate;
use think\exception\ValidateException;

class MenuService extends BasicService
{
    /**
     * 构造函数
     * @param App $app
     * @param MenuModel $model
     */
    public function __construct(App $app, MenuModel $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 获取全部菜单
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function list(): array
    {
        $where = ['status' => 1];
        $order = ['sort' => 'desc'];
        $field = ['id', 'pid', 'type', 'name', 'auth', 'path', 'icon', 'component', 'sort', 'status'];
        $list = $this->model->field($field)->where($where)->order($order)->select()->toArray();
        return success(['list' => makeTree($list)]);
    }

    /**
     * 获取所有权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function allMenu(): array
    {
        $order = ['sort' => 'desc'];
        $field = ['id', 'pid', 'type', 'name'];
        $where = [['id', '>', 0], ['status', '=', 1]];
        $menu = $this->model->field($field)->where($where)->order($order)->select()->toArray();
        return success(['list' => makeTree($menu)]);
    }

    /**
     * 添加菜单
     * @param $param
     * @return array
     */
    public function save($param): array
    {
        try {
            validate(MenuValidate::class)->scene('save')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }
        $param['create_time'] = $param['update_time'] = nowDate();
        if (!$this->model->insert($param)) {
            return failed('The operation failed, please try again');
        }
        return success();
    }

    /**
     * 编辑菜单
     * @param $param
     * @return array
     */
    public function edit($param): array
    {
        try {
            validate(MenuValidate::class)->scene('edit')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }

        $this->setParam($param);
        $id = $this->getParam('id', 0);

        $param['update_time'] = nowDate();
        if (!$this->model->where(['id' => $id])->update($param)) {
            return failed('The operation failed, please try again');
        }
        return success();
    }

    /**
     * 删除菜单
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function delete($param): array
    {
        $this->setParam($param);
        $id = $this->getParam('id', 0);

        if ($this->model->where(['pid' => $id])->find()) {
            return failed('There are submenus that cannot be deleted');
        }

        if (!$this->model->where(['id' => $id])->delete()) {
            return failed('The operation failed, please try again');
        }
        return success();
    }
}