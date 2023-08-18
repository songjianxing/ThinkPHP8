<?php

namespace app\admin\controller;

use think\App;
use think\response\Json;
use app\admin\services\MenuService;

class Menu extends Basic
{

    public function __construct(App $app, MenuService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    /**
     * 菜单列表
     * @return Json
     */
    public function index(): Json
    {
        $data = $this->service->getAllMenu();
        return json($data);
    }

    /**
     * 添加菜单
     * @return Json
     */
    public function add(): Json
    {

        $data = $this->service->addMenu(input('post.'));
        return json($data);
    }

    /**
     * 菜单编辑
     * @return Json
     */
    public function edit(): Json
    {
        $data = $this->service->editMenu(input('post.'));
        return json($data);
    }

    /**
     * 菜单删除
     * @return Json
     */
    public function del(): Json
    {
        $data = $this->service->delMenu(input('param.id'));
        return json($data);
    }

    /**
     * 获取所有菜单
     * @return Json
     */
    public function getAllMenu(): Json
    {
        $data = $this->service->getAllMenuList();
        return json($data);
    }
}