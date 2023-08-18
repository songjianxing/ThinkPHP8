<?php

namespace app\admin\controller;

use JetBrains\PhpStorm\NoReturn;
use think\App;
use think\response\Json;
use app\admin\services\AdminService;

class Admin extends Basic
{

    public function __construct(App $app, AdminService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    /**
     * 管理员列表
     * @return Json
     */
    public function list(): Json
    {
        $data = $this->service->getList(input('param.'));
        return json($data);

    }

    /**
     * 添加管理员
     * @return Json
     */
    public function save(): Json
    {
        $data = $this->service->save(input('post.'));
        return json($data);
    }

    /**
     * 编辑管理员
     * @return Json
     */
    public function edit(): Json
    {
        $data = $this->service->editAdmin(input('post.'));
        return json($data);
    }

    /**
     * 删除管理员
     * @return Json
     */
    public function del(): Json
    {
        $data = $this->service->delAdmin(input('param.id'));
        return json($data);
    }
}