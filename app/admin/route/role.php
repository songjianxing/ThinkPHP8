<?php
use think\facade\Route;

/**
 * 角色管理
 */
Route::group('/role', function () {
    // 获取角色列表
    Route::get('/list', '/admin/Role/list');
    // 获取所有角色
    Route::get('/all-role', '/admin/Role/allRole');
    // 新增角色
    Route::post('/save', '/admin/Role/save');
    // 修改角色
    Route::put('/edit/:id', '/admin/Role/edit');
    // 删除角色
    Route::delete('/delete/:id', '/admin/Role/delete');
});