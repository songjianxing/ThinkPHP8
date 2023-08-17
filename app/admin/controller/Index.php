<?php
declare (strict_types = 1);

namespace app\admin\controller;

class Index extends Basics
{
    public function index(): string
    {
        return '您好！这是一个[admin]示例应用';
    }
}
