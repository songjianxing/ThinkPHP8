<?php

namespace app\model;

use think\model\relation\HasOne;


class AdminModel extends BasicModel
{
    protected $name = 'admin';

    /**
     * Role模型关联
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(RoleModel::class, 'id', 'role_id')
            ->field(['id', 'name', 'rule', 'status']);
    }
}