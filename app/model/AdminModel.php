<?php

namespace app\model;

use think\model\relation\HasOne;


class AdminModel extends BasicModel
{
    protected $name = 'admin';

    public function role(): HasOne
    {
        return $this->hasOne(RoleModel::class, 'id', 'role_id');
    }
}