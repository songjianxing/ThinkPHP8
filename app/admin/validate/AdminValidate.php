<?php

namespace app\admin\validate;

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

    protected $scene = [
        'edit' => ['id', 'role_id', 'username', 'email', 'phone', 'nickname'],
        'save' => ['role_id', 'username', 'password', 'email', 'phone', 'nickname'],
        'delete' => ['id'],
    ];
}