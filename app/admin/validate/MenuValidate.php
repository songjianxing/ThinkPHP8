<?php

namespace app\admin\validate;

use think\Validate;

class MenuValidate extends Validate
{
    protected $rule = [
        'id|ID' => 'require',
        'pid|上级菜单' => 'require',
        'name|菜单名' => 'require|max:55',
    ];

    protected $message = [
        'id.require' => 'menu_id_require',
        'pid.require' => 'menu_pid_require',
        'name.require' => 'menu_name_require',
        'name.max' => 'menu_name_max',
    ];

    protected $scene = [
        'save' => ['pid', 'name'],
        'edit' => ['id', 'pid', 'name']
    ];
}