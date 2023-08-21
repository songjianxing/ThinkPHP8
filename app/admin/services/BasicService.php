<?php
declare (strict_types=1);

namespace app\admin\services;

use think\App;
use think\Request;
use helper\ValidateHelper;
use think\helper;


/**
 * 服务基础类
 */
class BasicService
{



    /**
     * 应用实例
     * @var App
     */
    protected App $app;

    protected mixed $param;

    protected object $model;

    /**
     * Request实例
     * @var Request
     */
    protected Request $request;

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;
        // 控制器初始化
        $this->initialize();
    }

    /**
     * 初始化
     * @return void
     */
    protected function initialize()
    {
    }

    protected function setParam(array $param): void
    {
        $this->param = &$param;
    }


    /**
     * @param $key
     * @param $default
     * @return array|int|mixed|string|null
     */
    protected function getParam($key, $default = null): mixed
    {
        $key = explode('.', $key);
        $param = &$this->param;

        foreach ($key as $k) {
            if (!isset($param[$k])) return $default;
            $param = &$param[$k];
        }

        return (is_int($default) ? ValidateHelper::number_filter($param, $default) : (is_string($param) ? trim($param) : $param));
    }
}
