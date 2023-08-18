<?php
declare (strict_types=1);

namespace app\index\controller\v1;

use app\index\controller\Basics;
use think\facade\Lang;

class Index extends Basics
{
    public function index()
    {
        var_dump(cookie('think_lang'));
        return json(lang('100'));
        return '您好！这是一个[index/v1]示例应用';
    }
}
