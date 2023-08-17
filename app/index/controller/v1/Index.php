<?php
declare (strict_types=1);

namespace app\index\controller\v1;

use app\index\controller\Basics;

class Index extends Basics
{
    public function index(): string
    {
        return '您好！这是一个[index/v1]示例应用';
    }
}
