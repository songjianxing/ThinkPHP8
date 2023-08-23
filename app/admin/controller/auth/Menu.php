<?php

namespace app\admin\controller\auth;

use think\App;
use think\response\Json;
use app\admin\controller\Basic;
use hg\apidoc\annotation as Apidoc;
use app\admin\services\auth\MenuService;

#[Apidoc\Title('菜单管理')]
class Menu extends Basic
{
    /**
     * 构造函数
     * @param App $app
     * @param MenuService $service
     */
    public function __construct(App $app, MenuService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    #[
        Apidoc\Tag('列表'),
        Apidoc\Method ('GET'),
        Apidoc\Title('菜单列表'),
        Apidoc\Url ('/admin/auth/menu/list'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'pid', 'type' => 'int', 'desc' => '上级菜单'],
            ['name' => 'type', 'type' => 'int', 'desc' => '类型 1:菜单 2:功能'],
            ['name' => 'name', 'type' => 'string', 'desc' => '标题'],
            ['name' => 'auth', 'type' => 'string', 'desc' => '规则名称'],
            ['name' => 'path', 'type' => 'string', 'desc' => '路由路径'],
            ['name' => 'icon', 'type' => 'string', 'desc' => '图标'],
            ['name' => 'sort', 'type' => 'int', 'desc' => '排序'],
            ['name' => 'status', 'type' => 'int', 'desc' => '状态: 1:启用 2:禁用'],
            ['name' => 'component', 'type' => 'string', 'desc' => '组件路径'],
            ['name' => 'children', 'type' => 'object', 'desc' => '子级', 'children' => [
                ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
                ['name' => 'pid', 'type' => 'int', 'desc' => '上级菜单'],
                ['name' => 'type', 'type' => 'int', 'desc' => '类型 1:菜单 2:功能'],
                ['name' => 'name', 'type' => 'string', 'desc' => '标题'],
                ['name' => 'auth', 'type' => 'string', 'desc' => '规则名称'],
                ['name' => 'path', 'type' => 'string', 'desc' => '路由路径'],
                ['name' => 'icon', 'type' => 'string', 'desc' => '图标'],
                ['name' => 'sort', 'type' => 'int', 'desc' => '排序'],
                ['name' => 'status', 'type' => 'int', 'desc' => '状态: 1:启用 2:禁用'],
                ['name' => 'component', 'type' => 'string', 'desc' => '组件路径'],
            ]],
        ]),
    ]
    public function list(): Json
    {
        return json($this->service->list());
    }

    #[
        Apidoc\Tag('获取'),
        Apidoc\Method('GET'),
        Apidoc\Title('获取所有菜单'),
        Apidoc\Url('/admin/auth/menu/all-menu'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'pid', 'type' => 'int', 'desc' => '上级菜单'],
            ['name' => 'type', 'type' => 'int', 'desc' => '类型 1:菜单 2:功能'],
            ['name' => 'name', 'type' => 'string', 'desc' => '标题'],
            ['name' => 'children', 'type' => 'object', 'desc' => '子级', 'children' => [
                ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
                ['name' => 'pid', 'type' => 'int', 'desc' => '上级菜单'],
                ['name' => 'type', 'type' => 'int', 'desc' => '类型 1:菜单 2:功能'],
                ['name' => 'name', 'type' => 'string', 'desc' => '标题'],
            ]],
        ]),
    ]
    public function allMenu(): Json
    {
        $data = $this->service->allMenu();
        return json($data);
    }

    #[
        Apidoc\Tag('新增'),
        Apidoc\Method('POST'),
        Apidoc\Title('新增菜单'),
        Apidoc\Url('/admin/auth/menu/save'),
        Apidoc\Param(name: 'pid', type: 'int', require: true, desc: '父级ID'),
        Apidoc\Param(name: 'name', type: 'string', require: true, desc: '标题'),
        Apidoc\Param(name: 'sort', type: 'int', desc: '排序'),
        Apidoc\Param(name: 'type', type: 'int', desc: '类型 1:菜单 2:功能'),
        Apidoc\Param(name: 'status', type: 'int', desc: '状态: 1:启用 2:禁用'),
        Apidoc\Param(name: 'icon', type: 'string', desc: '图标'),
        Apidoc\Param(name: 'auth', type: 'string', desc: '规则名称'),
        Apidoc\Param(name: 'path', type: 'string', desc: '路由路径'),
        Apidoc\Param(name: 'component', type: 'string', desc: '组件路径'),
    ]
    public function save(): Json
    {
        $data = $this->service->save(input());
        return json($data);
    }

    #[
        Apidoc\Tag('修改'),
        Apidoc\Method('PUT'),
        Apidoc\Title('修改菜单'),
        Apidoc\Url('/admin/auth/menu/edit/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
        Apidoc\Param(name: 'pid', type: 'int', require: true, desc: '父级ID'),
        Apidoc\Param(name: 'name', type: 'string', require: true, desc: '标题'),
        Apidoc\Param(name: 'sort', type: 'int', desc: '排序'),
        Apidoc\Param(name: 'type', type: 'int', desc: '类型 1:菜单 2:功能'),
        Apidoc\Param(name: 'status', type: 'int', desc: '状态: 1:启用 2:禁用'),
        Apidoc\Param(name: 'icon', type: 'string', desc: '图标'),
        Apidoc\Param(name: 'auth', type: 'string', desc: '规则名称'),
        Apidoc\Param(name: 'path', type: 'string', desc: '路由路径'),
        Apidoc\Param(name: 'component', type: 'string', desc: '组件路径'),
    ]
    public function edit(): Json
    {
        $data = $this->service->edit(input());
        return json($data);
    }

    #[
        Apidoc\Tag('删除'),
        Apidoc\Method('DELETE'),
        Apidoc\Title('删除菜单'),
        Apidoc\Url('/admin/auth/menu/delete/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
    ]
    public function delete(): Json
    {
        $data = $this->service->delete(input());
        return json($data);
    }
}