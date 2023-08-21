<?php
declare (strict_types = 1);

namespace app\listener\admin;

class AdminLog
{
    /**
     * 事件监听处理
     *
     * @return mixed
     */
    public function handle($event)
    {
        echo "监听点击事件";	// 我们编写的代码
    }
}
