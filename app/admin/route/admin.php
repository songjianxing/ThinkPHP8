<?php

use think\facade\Route;

/**
 * 管理员管理
 */
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