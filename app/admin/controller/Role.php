<?php

namespace app\admin\controller;

use think\App;
use think\response\Json;
use app\admin\services\RoleService;

class Role extends Basic
{

    public function __construct(App $app, RoleService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    public function index(): Json
    {
        $data = $this->service->getList(input('param.'));
        return json($data);
    }

    /**
     * 获取全部角色
     * @return Json
     */
    public function getAllRole(): Json
    {
        $data = $this->service->getAllRoleList();
        return json($data);
    }

    /**
     * 添加角色
     * @return Json
     */
    public function add(): Json
    {
        $data = $this->service->addRole(input('post.'));
        return json($data);
    }

    /**
     * 编辑角色
     * @return Json
     */
    public function edit(): Json
    {
        $data = $this->service->editRole(input('post.'));
        return json($data);
    }

    /**
     * 删除角色
     * @return Json
     */
    public function del(): Json
    {
        $data = $this->service->delRole(input('param.id'));
        return json($data);
    }
}