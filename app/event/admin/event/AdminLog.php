<?php
declare (strict_types = 1);

namespace app\event\admin\event;

class AdminLog
{
    public function handle()
    {
        echo "事件绑定\n";
    }
}
