<?php

namespace app\admin\controller\auth;

use think\App;
use think\response\Json;
use app\admin\controller\Basic;
use hg\apidoc\annotation as Apidoc;
use app\admin\services\auth\RoleService;

#[Apidoc\Title('角色管理')]
class Role extends Basic
{

    /**
     * 构造函数
     * @param App $app
     * @param RoleService $service
     */
    public function __construct(App $app, RoleService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    #[
        Apidoc\Tag('列表'),
        Apidoc\Method ('GET'),
        Apidoc\Title('角色列表'),
        Apidoc\Url ('/admin/auth/role/list'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'name', 'type' => 'string', 'desc' => '角色名'],
            ['name' => 'rule', 'type' => 'array', 'desc' => '拥有的权限'],
            ['name' => 'status', 'type' => 'int', 'desc' => '状态: 1 正常 2 禁用'],
            ['name' => 'create_time', 'type' => 'datetime', 'desc' => '创建时间'],
            ['name' => 'update_time', 'type' => 'datetime', 'desc' => '更新时间'],
        ]),
    ]
    public function list(): Json
    {
        $data = $this->service->list(input());
        return json($data);
    }

    #[
        Apidoc\Tag('获取'),
        Apidoc\Method('GET'),
        Apidoc\Title('获取所有角色'),
        Apidoc\Url('/admin/auth/role/all-role'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'name', 'type' => 'string', 'desc' => '角色名'],
            ['name' => 'rule', 'type' => 'string', 'desc' => '拥有的权限'],
            ['name' => 'status', 'type' => 'int', 'desc' => '状态: 1 正常 2 禁用'],
            ['name' => 'create_time', 'type' => 'datetime', 'desc' => '创建时间'],
            ['name' => 'update_time', 'type' => 'datetime', 'desc' => '更新时间'],
        ]),
    ]
    public function allRole(): Json
    {
        $data = $this->service->allRole();
        return json($data);
    }

    #[
        Apidoc\Tag('新增'),
        Apidoc\Method('POST'),
        Apidoc\Title('新增角色'),
        Apidoc\Url('/admin/auth/role/save'),
        Apidoc\Param(name: 'name', type: 'string', require: true, desc: '角色名'),
        Apidoc\Param(name: 'rule', type: 'array', desc: '权限ID'),
        Apidoc\Param(name: 'status', type: 'int', desc: '状态: 1:启用 2:禁用'),
    ]
    public function save(): Json
    {
        $data = $this->service->save(input());
        return json($data);
    }

    #[
        Apidoc\Tag('修改'),
        Apidoc\Method('PUT'),
        Apidoc\Title('修改角色'),
        Apidoc\Url('/admin/auth/role/edit/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
        Apidoc\Param(name: 'name', type: 'string', require: true, desc: '角色名'),
        Apidoc\Param(name: 'rule', type: 'array', desc: '权限ID'),
        Apidoc\Param(name: 'status', type: 'int', desc: '状态: 1:启用 2:禁用'),
    ]
    public function edit(): Json
    {
        $data = $this->service->editRole(input());
        return json($data);
    }

    #[
        Apidoc\Tag('删除'),
        Apidoc\Method('DELETE'),
        Apidoc\Title('删除角色'),
        Apidoc\Url('/admin/auth/role/delete/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
    ]
    public function delete(): Json
    {
        $data = $this->service->delete(input());
        return json($data);
    }
}