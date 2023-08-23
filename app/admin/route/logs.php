<?php

use think\facade\Route;

/**
 * 日志管理
 */
Route::group('/logs', function () {
    // 获取管理员日志列表
    Route::get('/admin-list', '/admin/Logs/adminList');
});