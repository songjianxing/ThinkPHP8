<?php

namespace app\admin\validate;

use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'id|ID' => 'require',
        'name|角色名' => 'require|max:155',
        'rule|拥有的权限' => 'require',
        'status|状态' => 'require|in:1,2'
    ];

    protected $message = [
        'id.require' => 'role_id_require',
        'name.require' => 'role_name_require',
        'name.max' => 'role_name_max',
        'rule.require' => 'role_rule_require',
        'status.require' => 'role_status_require',
        'status.in' => 'role_status_in',
    ];

    protected $scene = [
        'save' => ['rule', 'name', 'status'],
        'edit' => ['id', 'rule', 'name', 'status'],
    ];
}