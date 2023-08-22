<?php

namespace app\admin\controller;

use think\App;
use think\response\Json;
use utils\captcha\Captcha;
use basics\BaseController;
use hg\apidoc\annotation as Apidoc;
use app\admin\services\LoginService;

#[Apidoc\Title('后台登录')]
class Login extends BaseController
{
    /**
     * 构造函数
     * @param App $app
     * @param LoginService $service
     */
    public function __construct(App $app, LoginService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    #[
        Apidoc\Tag('登录'),
        Apidoc\Method('POST'),
        Apidoc\Title('登录后台'),
        Apidoc\Url('/admin/login/login'),
        Apidoc\Param(name: 'key', type: 'string', require: true, desc: '验签'),
        Apidoc\Param(name: 'code', type: 'string', require: true, desc: '验证码'),
        Apidoc\Param(name: 'username', type: 'string', require: true, desc: '账户'),
        Apidoc\Param(name: 'password', type: 'string', require: true, desc: '密码'),
    ]
    public function login(): Json
    {
        $data = $this->service->login(input());
        return json($data);
    }

    #[
        Apidoc\Tag('验证码'),
        Apidoc\Method('GET'),
        Apidoc\Title('获取登录验证码'),
        Apidoc\Url('/admin/login/captcha'),
        Apidoc\Returned(name: 'key', type: 'string', require: true, desc: '验证Key'),
        Apidoc\Returned(name: 'img', type: 'string', require: true, desc: '图片Base64'),
    ]
    public function captcha(): Json
    {
        $captcha = new Captcha();
        $captcha = $captcha->create();
        return json(success($captcha));
    }
}