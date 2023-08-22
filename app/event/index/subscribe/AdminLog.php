<?php
declare (strict_types=1);

namespace app\event\admin\subscribe;

use think\Event;

class AdminLog
{
    public function onAdminLog3($user)
    {
        echo "onAdminLog3\n";
    }

    public function onAdminLog4($user)
    {
        echo "onAdminLog4\n";
    }

    public function subscribe(Event $event)
    {
        $event->listen('AdminLog3', [$this, 'onAdminLog3']);
        $event->listen('AdminLog4', [$this, 'onAdminLog4']);
    }
}
