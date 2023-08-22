<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group('/admin', function () {
    // 获取管理员列表
    Route::get('/list', '/admin/Admin/list');
    // 新增管理员
    Route::post('/save', '/admin/Admin/save');
    // 修改管理员
    Route::put('/edit/:id', '/admin/Admin/edit');
    // 删除管理员
    Route::delete('/delete/:id', '/admin/Admin/delete');
});