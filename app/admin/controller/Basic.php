<?php
declare (strict_types=1);

namespace app\admin\controller;

use basics\BaseController;

class Basic extends BaseController
{
    public function initialize(): void
    {
        // 校验用户的权限
        $user = getJWT(getHeaderToken());
        if (!$user) exit(json_encode(failed('Login has expired, please log in again')));

        // 路径地址
        $controller = request()->controller();
        $action = request()->action();
        $path = "{$controller}/{$action}";

        // 可直接跳过的权限
        $skip = config('auth')['skip_rule'];

        // 获取权限节点对比
        $node = cache($user['id'] . '_auth_map');
        if ($user['id'] != 1 && !isset($skip[$path]) && !isset($skip["{$controller}/*"]) && !isset($node[$path])) {
            exit(json_encode(failed('You do not have permission to operate, please contact the administrator')));
        }
    }
}
