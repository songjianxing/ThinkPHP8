<?php

use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use think\facade\Log;

/**
 * 错误信息
 * @param string $msg
 * @param int $code
 * @return array
 */
function failed(string $msg = 'failed', int $code = 0): array
{
    return ['code' => $code, 'msg' => lang($msg), 'data' => new stdClass()];
}

/**
 * 成功信息
 * @param array $data
 * @param int $code
 * @return array
 */
function success(array $data = [], int $code = 200): array
{
    if (empty($data)) $data = new stdClass();
    return ['code' => $code, 'msg' => 'success', 'data' => $data];
}

/**
 * 生成密码
 * @param $password
 * @param string $salt
 * @return string
 */
function makePass($password, string $salt = ''): string
{
    return sha1(md5(md5($password . $salt)));
}

/**
 * 设置jwt
 * @param $data
 * @return string
 */
function setJWT($data): string
{
    $jwt = new JWT();
    $token = [
        'iat' => time(), // 签发时间
        'nbf' => time(), // 生效时间
        'data' => $data, // 加签数据
        // 签发者
        'iss' => 'https://www.xxx.com',
        // 认证者
        'aud' => 'https://www.xxx.com',
        // 过期时间  7天后的时间戳
        'exp' => (time() + env('jwt_exp_time', 604800)),
    ];

    return $jwt::encode($token, env('jwt_exp_key', ''), 'HS256');
}

/**
 * 获取token中的信息
 * @param $token
 * @return array|null
 */
function getJWT($token): ?array
{
    $jwt = new JWT();
    try {
        $jwtData = $jwt::decode($token, new Key(env('jwt_exp_key', ''), 'HS256'));
        $data = (array)($jwtData->data);
    } catch (\Exception $e) {
        Log::write($e->getMessage(), 'error');
        return null;
    }
    return $data;
}

/**
 * 从头部获取token
 * @return string
 */
function getHeaderToken(): string
{
    $header = request()->header();
    if (!isset($header['authorization'])) return '';
    return $header['authorization'];
}

/**
 * 生成子孙树
 * @param $data
 * @return array
 */
function makeTree($data): array
{
    $resp = $tree = [];
    // 整理数组
    foreach ($data as $vo) {
        $resp[$vo['id']] = $vo;
    }
    unset($data);

    // 查询子孙
    foreach ($resp as $vo) {
        if ($vo['pid'] == 0) continue;
        $resp[$vo['pid']]['children'][] = &$vo;
    }

    // 去除杂质
    foreach ($resp as $vo) {
        if ($vo['pid'] != 0) continue;
        $tree[] = $vo;
    }
    unset($resp);

    return $tree;
}

/**
 * 跨域
 * @return void
 */
function crossDomain(): void
{
    header("access-control-allow-headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With");
    header("access-control-allow-methods: OPTIONS,GET, POST, PATCH, PUT, DELETE");
    header("access-control-allow-origin: *");
}

/**
 * 获取当前时间
 * @return string
 */
function nowDate(): string
{
    return date('Y-m-d H:i:s');
}

/**
 * 获取 IP 地址
 * @return string
 */
function getIP(): string
{
    return request()->ip();
}

/**
 * 随机数生成生成
 * @param int $length
 * @return int
 */
function getRandNumber(int $length = 6): int
{
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= rand(0, 9);
    }
    return (int)$code;
}

/**
 * 生成随机验证码
 * @param $length
 * @return int
 */
function makeRandCode($length): int
{
    $start = pow(10, $length - 1);
    $end = pow(10, $length) - 1;
    return rand($start, $end);
}

/**
 * 获取真实路径
 * @param $path
 * @return array
 */
function getRealPath($path): array
{
    $delPathMap = [];
    foreach ($path as $vo) {
        $pathMap = explode('/', $vo);
        $pathMap = array_slice($pathMap, 3);
        $delPathMap[] = implode('/', $pathMap);
    }

    return $delPathMap;
}

/**
 * 生成毫秒级时间戳
 * @return float
 */
function getMillisecond(): float
{
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

/**
 * 生成唯一id
 * @return string
 */
function uuid(): string
{
    return uniqid(md5(mt_rand()), true);
}

/**
 * post提交
 * @param $url
 * @param $data
 * @return mixed
 */
function curlPost($url, $data): mixed
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);

    return json_decode($output, true);
}

/**
 * get 提交
 * @param $url
 * @param $data
 * @return mixed
 */
function curlGet($url, $data): mixed
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($data));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);;
    $output = curl_exec($ch);
    curl_close($ch);

    return json_decode($output, true);
}
