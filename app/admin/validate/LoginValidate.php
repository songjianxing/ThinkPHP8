<?php

namespace app\admin\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'username|登录账号' => 'require|max:55',
        'password|密码' => 'require|max:32',
        'code|验证码' => 'require'
    ];

    protected $message = [
        'username.max' => 'login_username_max',
        'username.require' => 'login_username_require',
        'password.max' => 'login_password_max',
        'password.require' => 'login_password_require',
        'code.require' => 'login_code_require',
    ];
}