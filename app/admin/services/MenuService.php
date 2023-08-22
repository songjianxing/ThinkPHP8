<?php

namespace app\admin\services;

use app\admin\model\MenuModel;
use app\admin\model\RoleModel;
use app\admin\validate\MenuValidate;
use JetBrains\PhpStorm\NoReturn;
use think\exception\ValidateException;
use think\facade\Db;

class MenuService
{
    /**
     * 获取我的权限菜单
     * @param $role_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMyMenu($role_id): array
    {
        $order = ['sort' => 'desc'];
        $field = ['id', 'pid', 'auth', 'type', 'name', 'path', 'icon', 'component'];
        $menu_model = Db::name('menu')->field($field)->order($order);
        if ($role_id == 1) {
            $menu_model->where(['status' => 1]);
        } else {
            $role_ids = Db::name('role')->where(['id' => $role_id])->value('rule');
            $role_arr = explode(',', $role_ids);
            $menu_model->where([['status', '=', 1], ['id', 'in', $role_arr]]);
        }
        $menu_list = $menu_model->select()->toArray();

        foreach ($menu_list as &$item) {
            $item['meta'] = [
                'type' => 'menu',
                'icon' => $item['icon'],
                'title' => $item['name'],
                'hidden' => ($item['type'] == 2)
            ];
            if ($item['pid'] != 0) continue;
            unset($item['component']);
        }

        return $menu_list;
    }


    /**
     * 获取全部菜单
     * @return array
     */
    public function getAllMenu(): array
    {
        $menuModel = new MenuModel();
        $menuList = $menuModel->getAllList(['status' => 1], '*', 'sort desc')['data'];

        return dataReturn(0, 'success', makeTree($menuList->toArray()));
    }

    /**
     * 添加菜单
     * @param $param
     * @return array
     */
    public function addMenu($param): array
    {
        try {
            validate(MenuValidate::class)->scene('add')->check($param);
        } catch (ValidateException $e) {
            return dataReturn(-1, $e->getError());
        }

        $param['create_time'] = now();

        $menuModel = new MenuModel();
        return $menuModel->insertOne($param);
    }

    /**
     * 编辑菜单
     * @param $param
     * @return array
     */
    public function editMenu($param): array
    {
        try {
            validate(MenuValidate::class)->check($param);
        } catch (ValidateException $e) {
            return dataReturn(-1, $e->getError());
        }

        $param['update_time'] = now();

        $menuModel = new MenuModel();
        return $menuModel->updateById($param, $param['id']);
    }

    /**
     * 删除菜单
     * @param $id
     * @return array
     */
    public function delMenu($id): array
    {
        $menuModel = new MenuModel();
        $hasChild = $menuModel->findOne(['pid' => $id])['data'];
        if (!empty($hasChild)) {
            return dataReturn(-1, '该菜单下有子菜单不可删除');
        }

        return $menuModel->delById($id);
    }

    /**
     * Notes: 获取所有权限
     * Author: LJS
     * @return array
     */
    public function getAllMenuList(): array
    {
        $menuModel = new MenuModel();
        $menu = $menuModel->getAllList([['id', '>', 0], ['status', '=', 1]], ['id', 'pid', 'type', 'name'], 'sort desc')['data']->toArray();

        return dataReturn(0, 'success', makeTree($menu));
    }
}