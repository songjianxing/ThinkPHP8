<?php

namespace app\admin\controller;

use think\App;
use think\response\Json;
use hg\apidoc\annotation as Apidoc;
use app\admin\services\AdminLogService;

#[Apidoc\Title('日志管理')]
class Logs extends Basic
{

    /**
     * 构造函数
     * @param App $app
     * @param AdminLogService $service
     */
    public function __construct(App $app, AdminLogService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    #[
        Apidoc\Tag('列表'),
        Apidoc\Method ('GET'),
        Apidoc\Title('管理员日志列表'),
        Apidoc\Url ('/admin/logs/admin-list'),
        Apidoc\Query(name: 'page', type: 'int', require: true, default: 1, desc: '页码'),
        Apidoc\Query(name: 'limit', type: 'int', require: true, default: 20, desc: '每页数量'),
        Apidoc\Query(name: 'username', type: 'string', desc: '管理员账号'),

        Apidoc\Returned(name: 'page', type: 'int', require: true, desc: '页码'),
        Apidoc\Returned(name: 'limit', type: 'int', require: true, desc: '每页数量'),
        Apidoc\Returned(name: 'count', type: 'string', require: true, desc: '数据总量'),
        Apidoc\Returned(name: 'list', type: 'object', desc: '数据列表', children: [
            ['name' => 'id', 'type' => 'int', 'desc' => 'ID'],
            ['name' => 'admin_id', 'type' => 'int', 'desc' => '管理员ID'],
            ['name' => 'username', 'type' => 'string', 'desc' => '管理员用户名'],
            ['name' => 'url', 'type' => 'string', 'desc' => '路由'],
            ['name' => 'title', 'type' => 'string', 'desc' => '操作标题'],
            ['name' => 'data', 'type' => 'string', 'desc' => '操作内容'],
            ['name' => 'ip', 'type' => 'int', 'desc' => 'IP地址'],
            ['name' => 'user_agent', 'type' => 'int', 'desc' => '用户代理'],
            ['name' => 'create_time', 'type' => 'string', 'desc' => '操作时间'],
        ]),
    ]
    public function adminList(): Json
    {
        $data = $this->service->adminList(input());
        return json($data);

    }
}