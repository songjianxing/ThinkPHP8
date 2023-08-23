<?php

use think\facade\Route;

/**
 * 日志模块
 */
Route::group('/logs', function () {
    // 日志管理
    Route::group('/admin', function () {
        // 获取管理员日志列表
        Route::get('/list', '/admin/logs.Logs/adminList');
    });
});