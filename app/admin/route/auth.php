<?php

use think\facade\Route;

/**
 * 权限模块
 */
Route::group('/auth', function () {

    // 管理员管理
    Route::group('/admin', function () {
        // 获取管理员列表
        Route::get('/list', '/admin/auth.Admin/list');
        // 新增管理员
        Route::post('/save', '/admin/auth.Admin/save');
        // 修改管理员
        Route::put('/edit/:id', '/admin/auth.Admin/edit');
        // 删除管理员
        Route::delete('/delete/:id', '/admin/auth.Admin/delete');
    });

    // 登录管理
    Route::group('/login', function () {
        // 后台登录
        Route::post('/login', '/admin/auth.Login/login');
        // 获取验证码
        Route::get('/captcha', '/admin/auth.Login/captcha');
    });

    // 日志管理
    Route::group('/logs', function () {
        // 获取管理员日志列表
        Route::get('/admin-list', '/admin/auth.Logs/adminList');
    });

    // 菜单管理
    Route::group('/menu', function () {
        // 获取菜单列表
        Route::get('/list', '/admin/auth.Menu/list');
        // 获取所有菜单
        Route::get('/all-menu', '/admin/auth.Menu/allMenu');
        // 新增菜单
        Route::post('/save', '/admin/auth.Menu/save');
        // 修改菜单
        Route::put('/edit/:id', '/admin/auth.Menu/edit');
        // 删除菜单
        Route::delete('/delete/:id', '/admin/auth.Menu/delete');
    });

    //角色管理
    Route::group('/role', function () {
        // 获取角色列表
        Route::get('/list', '/admin/auth.Role/list');
        // 获取所有角色
        Route::get('/all-role', '/admin/auth.Role/allRole');
        // 新增角色
        Route::post('/save', '/admin/auth.Role/save');
        // 修改角色
        Route::put('/edit/:id', '/admin/auth.Role/edit');
        // 删除角色
        Route::delete('/delete/:id', '/admin/auth.Role/delete');
    });
});