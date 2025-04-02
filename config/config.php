<?php
session_start(); // Bắt đầu session
// Xác định URL root động
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);
    $path = str_replace('/app/config', '', $path); // Điều chỉnh dựa vào cấu trúc thư mục của bạn
    
    return $protocol . $domainName . $path;
}
// Cấu hình URL
define('URLROOT', getBaseUrl());
define('SITENAME', 'PHP MVC Framework');
define('APPROOT', dirname(dirname(__FILE__)));