<?php

namespace app\admin\services;

use think\App;
use app\model\AdminLogModel;

class AdminLogService extends BasicService
{

    /**
     * 构造函数
     * @param App $app
     * @param AdminLogModel $model
     */
    public function __construct(App $app, AdminLogModel $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    /**
     * 管理员日志列表
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function adminList($param): array
    {
        $this->setParam($param);
        $page = $this->getParam('page', 1);
        $limit = $this->getParam('limit', 20);
        $user_name = $this->getParam('username', '');

        $where = [];
        if (!empty($user_name)) $where[] = ['username', '=', $user_name];

        $field = ['id', 'admin_id', 'username', 'url', 'title', 'data', 'ip', 'user_agent', 'create_time'];
        $model = $this->model->field($field)->where($where)->order(['id' => 'desc']);
        $count = $model->count('id');
        $list = $model->page($page, $limit)->select()->toArray();

        return success([
            'list' => $list,
            'page' => $page,
            'limit' => $limit,
            'count' => $count,
        ]);
    }
}