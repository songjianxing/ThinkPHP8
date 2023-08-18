<?php
declare (strict_types=1);

namespace app\index\controller\v1;

use app\index\controller\Basics;
use think\facade\Lang;

class Index extends Basics
{
    public function index()
    {
        return json(lang('100'));
    }
}
