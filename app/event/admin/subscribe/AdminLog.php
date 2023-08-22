<?php
declare (strict_types=1);

namespace app\event\admin\subscribe;

use think\Event;

class AdminLog
{
    public function onSubscription1($user)
    {
        echo "订阅事件 1\n";
    }

    public function onSubscription2($user)
    {
        echo "订阅事件 2\n";
    }

    public function subscribe(Event $event)
    {
        $event->listen('Subscription1', [$this, 'onSubscription1']);
        $event->listen('Subscription2', [$this, 'onSubscription2']);
    }
}
