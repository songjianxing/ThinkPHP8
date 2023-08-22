<?php
declare (strict_types = 1);

namespace app\event\index\listener;

class AdminLog
{
    /**
     * 事件监听处理
     *
     * @return void
     */
    public function handle($event): void
    {
        echo "事件监听\n";	// 我们编写的代码
    }
}
