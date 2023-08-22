<?php

namespace app\admin\services;

use think\facade\Db;
use utils\captcha\Captcha;
use app\admin\validate\LoginValidate;
use think\exception\ValidateException;

class LoginService extends BasicService
{

    /**
     * 管理员登录
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($param): array
    {
        try {
            validate(LoginValidate::class)->check($param);
        } catch (ValidateException $e) {
            return failed($e->getError());
        }

        $this->setParam($param);
        $key = $this->getParam('key', '');
        $code = $this->getParam('code', '');
        $username = $this->getParam('username', '');
        $password = $this->getParam('password', '');

        // TODO 验证码展示注释 后续打开
        //$captcha = new Captcha();
        //if (!$captcha->check($code, $key)) return failed('Verification code error');

        // 检查用户是否存在
        $user = Db::name('admin')->where(['username' => $username])->find();
        if (!$user) return failed('The account does not exist');

        // 验证密码是否正确
        if (makePass($password, $user['salt']) != $user['password']) {
            return failed('Password error');
        }

        // 验证用户是否禁用
        if ($user['status'] == 2){
            return failed('This account has been disabled');
        }

        // 验证角色是否禁用
        if ($user['role_id'] != 1) {
            $role = Db::name('role')->where(['id' => $user['role_id'], 'status' => 1])->find();
            if (!$role) return failed('The account role has been disabled');
        }

        $token = setJWT([
            'id' => $user['id'],
            'avatar' => $user['avatar'],
            'role_id' => $user['role_id'],
            'nickname' => $user['nickname'],
        ]);

        // 获取权限菜单
        $menu_list = (new MenuService)->getMyMenu($user['role_id']);

        // 记录权限map后续校验用
        if ($user['id'] != 1) {
            $auth_map = [];
            foreach ($menu_list as $item) {
                if (empty($item['auth'])) continue;
                $auth_map[$item['auth']] = 1;
            }
            cache("{$user['id']}_auth_map", $auth_map);
        }

        // 更新登录时间,登录IP
        Db::name('admin')->where(['id' => $user['id']])->update([
            'last_login_ip' => getIP(),
            'update_time' => nowDate(),
            'last_login_time' => nowDate(),
        ]);

        // 事件记录操作日志
        event('AdminLog', ['admin_id' => $user['id'], 'username' => $user['username']]);

        return success([
            'token' => $token,
            'user_info' => [
                'id' => $user['id'] ?? 0,
                'avatar' => $user['avatar'] ?? '',
                'role_id' => $user['role_id'] ?? 0,
                'nick_name' => $user['nickname'] ?? '',
            ],
            'menu_list' => makeTree($menu_list),
        ]);
    }
}