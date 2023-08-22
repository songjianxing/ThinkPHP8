<?php
declare (strict_types=1);

namespace app\event\admin\listener;

use think\facade\Db;
use Chance\Log\facades\OperationLog;

class AdminLog
{
    /**
     * 日志记录事件
     * @param $param
     * @return bool
     */
    public function handle($param): bool
    {
        if (!$param) {
            $info = $this->write();
        } else {
            $info = $this->login($param);
        }

        return $info;
    }

    /**
     * 操作事件日志记录
     * @return bool
     */
    private function write(): bool
    {
        // 无操作数据返回
        $data = OperationLog::getLog();
        if (empty($data)) return false;
        // 无用户信息返回
        $user = getJWT(getHeaderToken());
        if (!$user) return false;

        $param = [
            'data' => $data,
            'title' => '后台操作',
            'ip' => request()->ip(),
            'url' => request()->url(),
            'admin_id' => $user['id'],
            'create_time' => nowDate(),
            'username' => $user['nickname'],
            'user_agent' => isset(request()->header()['user-agent']) ? request()->header()['user-agent'] : '',
        ];
        $resp = Db::name('admin_log')->insert($param);
        if (!$resp) return false;

        return true;
    }

    /**
     * 登录事件日志记录
     * @param $param
     * @return bool
     */
    private function login($param): bool
    {
        $param = [
            'title' => '管理员登录',
            'ip' => request()->ip(),
            'url' => request()->url(),
            'create_time' => nowDate(),
            'admin_id' => $param['admin_id'],
            'username' => $param['username'],
            'data' => "管理员:{$param['username']} (用户ID:{$param['admin_id']}) 登录后台!",
            'user_agent' => isset(request()->header()['user-agent']) ? request()->header()['user-agent'] : '',
        ];
        $resp = Db::name('admin_log')->insert($param);
        if (!$resp) return false;

        return true;
    }
}
