<?php
declare (strict_types=1);

namespace app\admin\controller;


use think\facade\Db;
use think\facade\Request;
use think\response\Json;

class Index extends Basics
{
    public function index()
    {
//        var_dump(Request::header());
return \json(lang('test'));
//       var_dump( );
//        return '您好！这是一个[admin]示例应用';
    }
}
