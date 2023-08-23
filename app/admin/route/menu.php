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

/**
 * 菜单管理
 */
Route::group('/menu', function () {
    // 获取菜单列表
    Route::get('/list', '/admin/Menu/list');
    // 获取所有菜单
    Route::get('/all-menu', '/admin/Menu/allMenu');
    // 新增菜单
    Route::post('/save', '/admin/Menu/save');
    // 修改菜单
    Route::put('/edit/:id', '/admin/Menu/edit');
    // 删除菜单
    Route::delete('/delete/:id', '/admin/Menu/delete');

});