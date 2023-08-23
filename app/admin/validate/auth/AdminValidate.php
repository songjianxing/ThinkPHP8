<?php

namespace app\admin\validate\auth;

use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'id|ID' => 'require',
        'email|邮箱' => 'email',
        'phone|电话' => 'mobile',
        'nickname|昵称' => 'chsAlpha',
        'role_id|角色' => 'require|number',
        'password|密码' => 'require|max:16',
        'username|登录账号' => 'require|alphaNum|max:55',
    ];

    protected $message = [
        'id.require' => 'admin_id_require',
        'email' => 'admin_email_error',
        'phone' => 'admin_phone_error',
        'nickname.chsAlpha' => 'admin_nickname_chs_alpha',

        'role_id.number' => 'admin_role_id_number',
        'role_id.require' => 'admin_role_id_require',

        'password.max' => 'admin_password_max',
        'password.require' => 'admin_password_require',

        'username.max' => 'admin_username_max',
        'username.require' => 'admin_username_require',
        'username.alphaNum' => 'admin_username_alpha_num',
    ];

    protected $scene = [
        'edit' => ['id', 'role_id', 'username', 'email', 'phone', 'nickname'],
        'save' => ['role_id', 'username', 'password', 'email', 'phone', 'nickname'],
        'delete' => ['id'],
    ];
}