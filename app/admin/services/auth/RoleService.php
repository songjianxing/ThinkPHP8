<?php

namespace app\admin\services\auth;

use think\App;
use app\model\RoleModel;
use app\admin\services\BasicService;
use think\exception\ValidateException;
use app\admin\validate\auth\RoleValidate;

class RoleService extends BasicService
{

    /**
     * 构造函数
     * @param App $app
     * @param RoleModel $model
     */
    public function __construct(App $app, RoleModel $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 获取角色列表
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function list($param): array
    {
        $this->setParam($param);
        $name = $this->getParam('name', '');
        $page = $this->getParam('page', 1);
        $limit = $this->getParam('limit', 20);

        $where[] = ['id', '>', 1];
        if (!empty($name)) $where[] = ['name', '=', $name];

        $order = ['id' => 'desc'];
        $field = ['id', 'name', 'rule', 'status', 'create_time', 'update_time'];
        $model = $this->model->field($field)->where($where)->order($order);
        $count = $model->count('id');
        $list = $model->page($page, $limit)->select()->toArray();

        foreach ($list as &$item) {
            $item['rule'] = explode(',', $item['rule']);
        }

        return success(['page' => $page, 'limit' => $limit, 'count' => $count, 'list' => $list]);
    }

    /**
     * 获取所有角色
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function allRole(): array
    {
        $order = ['id' => 'desc'];
        $where = [['id', '>', 1]];
        $field = ['id', 'name', 'rule', 'status', 'create_time', 'update_time'];
        $list = $this->model->field($field)->where($where)->order($order)->select();
        return success(['list' => $list]);
    }

    /**
     * 添加角色
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function save($param): array
    {
        try {
            validate(RoleValidate::class)->scene('save')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }
        $this->setParam($param);
        $rule = $this->getParam('rule', []);
        $name = $this->getParam('name', '');

        // 检查唯一
        if ($this->model->where(['name' => $name])->find()) {
            return failed('The role name already exists');
        }

        $param['rule'] = join(',', $rule);
        $param['create_time'] = $param['update_time'] = nowDate();

        if (!$this->model->insert($param)) {
            return failed('The operation failed, please try again');
        }
        return success();
    }

    /**
     * 编辑角色
     * @param $param
     * @return array
     */
    public function editRole($param): array
    {
        try {
            validate(RoleValidate::class)->scene('edit')->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }

        $this->setParam($param);
        $id = $this->getParam('id', 0);

        $param['update_time'] = nowDate();
        $param['rule'] = join(',', $param['rule']);;

        if (!$this->model->where(['id' => $id])->update($param)) {
            return failed('The operation failed, please try again');
        }

        return success();
    }

    /**
     * 删除角色
     * @param $param
     * @return array
     */
    public function delete($param): array
    {
        $this->setParam($param);
        $id = $this->getParam('id', 0);
        if ($id == 1) {
            return failed('The Super Admin role cannot be deleted');
        }
        if (!$this->model->where(['id' => $id])->delete()) {
            return failed('The operation failed, please try again');
        }
        return success();
    }
}