<?php

namespace app\admin\controller;

use think\App;
use think\response\Json;
use hg\apidoc\annotation as Apidoc;
use app\admin\services\AdminService;

#[Apidoc\Title('管理员管理')]
class Admin extends Basic
{

    /**
     * 构造函数
     * @param App $app
     * @param AdminService $service
     */
    public function __construct(App $app, AdminService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    #[
        Apidoc\Tag('列表'),
        Apidoc\Method ('GET'),
        Apidoc\Title('管理员列表'),
        Apidoc\Url ('/admin/admin/list'),
        Apidoc\Query(name: 'page', type: 'int', require: true, default: 1, desc: '页码'),
        Apidoc\Query(name: 'limit', type: 'int', require: true, default: 20, desc: '每页数量'),
        Apidoc\Query(name: 'username', type: 'string', desc: '管理员账号'),

        Apidoc\Returned(name: 'page', type: 'int', require: true, desc: '页码'),
        Apidoc\Returned(name: 'limit', type: 'int', require: true, desc: '每页数量'),
        Apidoc\Returned(name: 'count', type: 'string', require: true, desc: '数据总量'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'role_id', 'type' => 'int', 'desc' => '所属角色id'],
            ['name' => 'username', 'type' => 'string', 'desc' => '用户名'],
            ['name' => 'nickname', 'type' => 'string', 'desc' => '昵称'],
            ['name' => 'avatar', 'type' => 'string', 'desc' => '头像'],
            ['name' => 'email', 'type' => 'string', 'desc' => '邮箱'],
            ['name' => 'phone', 'type' => 'int', 'desc' => '手机'],
            ['name' => 'login_failure', 'type' => 'int', 'desc' => '登录失败次数'],
            ['name' => 'last_login_ip', 'type' => 'string', 'desc' => '登录IP'],
            ['name' => 'last_login_time', 'type' => 'datetime', 'desc' => '登录时间'],
            ['name' => 'status', 'type' => 'int', 'desc' => '状态:1.启用 2.禁用'],
            ['name' => 'create_time', 'type' => 'datetime', 'desc' => '创建时间'],
            ['name' => 'role', 'type' => 'object', 'desc' => '', 'children' => [
                ['name' => 'id', 'type' => 'int', 'desc' => '角色ID'],
                ['name' => 'name', 'type' => 'string', 'desc' => '角色名'],
                ['name' => 'status', 'type' => 'int', 'desc' => '角色状态: 1.正常 2.禁用'],
            ]],
        ]),
    ]
    public function list(): Json
    {
        $data = $this->service->list(input());
        return json($data);

    }

    #[
        Apidoc\Tag('新增'),
        Apidoc\Method('POST'),
        Apidoc\Title('新增管理员'),
        Apidoc\Url('/admin/admin/save'),
        Apidoc\Param(name: 'role_id', type: 'int', require: true, desc: '角色'),
        Apidoc\Param(name: 'username', type: 'string', require: true, desc: '账号'),
        Apidoc\Param(name: 'password', type: 'string', require: true, desc: '密码'),
        Apidoc\Param(name: 'nickname', type: 'string', desc: '昵称'),
        Apidoc\Param(name: 'email', type: 'string', desc: '邮箱'),
        Apidoc\Param(name: 'phone', type: 'int', desc: '电话'),
    ]
    public function save(): Json
    {
        $data = $this->service->save(input());
        return json($data);
    }

    #[
        Apidoc\Tag('修改'),
        Apidoc\Method('PUT'),
        Apidoc\Title('修改管理员'),
        Apidoc\Url('/admin/admin/edit/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
        Apidoc\Param(name: 'role_id', type: 'int', require: true, desc: '角色'),
        Apidoc\Param(name: 'username', type: 'string', require: true, desc: '账号'),
        Apidoc\Param(name: 'password', type: 'string', desc: '密码'),
        Apidoc\Param(name: 'nickname', type: 'string', desc: '昵称'),
        Apidoc\Param(name: 'email', type: 'string', desc: '邮箱'),
        Apidoc\Param(name: 'phone', type: 'int', desc: '电话'),
    ]
    public function edit(): Json
    {
        $data = $this->service->edit(input());
        return json($data);
    }

    #[
        Apidoc\Tag('删除'),
        Apidoc\Method('DELETE'),
        Apidoc\Title('删除管理员'),
        Apidoc\Url('/admin/admin/delete/:id'),
        Apidoc\Query(name: 'id', type: 'int', require: true, desc: 'ID'),
    ]
    public function delete(): Json
    {
        $data = $this->service->delete(input());
        return json($data);
    }
}