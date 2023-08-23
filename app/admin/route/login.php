<?php
use think\facade\Route;

/**
 * 登录管理
 */
Route::group('/login', function () {
    // 后台登录
    Route::post('/login', '/admin/Login/login');
    // 获取验证码
    Route::get('/captcha', '/admin/Login/captcha');
});