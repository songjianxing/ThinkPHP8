<?php

namespace app\admin\controller;

use app\admin\services\LoginService;
use basics\BaseController;
use think\App;
use think\response\Json;
use utils\captcha\Captcha;
use hg\apidoc\annotation as Apidoc;

/**
 * 后台登录
 */
class Login extends BaseController
{

    public function __construct(App $app, LoginService $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }


    /**
     * @Apidoc\Title("登录后台")
     * @Apidoc\Tag("验证码")
     * @Apidoc\Method ("GET")
     * @Apidoc\Url ("/admin/login/captcha")
     * @Apidoc\Returned("img", type="string", desc="图片Base64")
     * @Apidoc\Returned("key", type="string", desc="验证Key")
     */
    public function login(): Json
    {
        $data = $this->service->login(input());
        return json($data);
    }

    /**
     * @Apidoc\Title("获取登录验证码")
     * @Apidoc\Tag("验证码")
     * @Apidoc\Method ("GET")
     * @Apidoc\Url ("/admin/login/captcha")
     * @Apidoc\Returned("img", type="string", desc="图片Base64")
     * @Apidoc\Returned("key", type="string", desc="验证Key")
     */
    public function captcha(): Json
    {
        $captcha = new Captcha();
        $captcha = $captcha->create();
        return json(success($captcha));
    }
}