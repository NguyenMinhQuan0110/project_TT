<?php

// Thêm file config
require_once '../config/database.php';
require_once '../config/config.php';

// Thêm file core
require_once '../core/app.php';
require_once '../core/controller.php';
require_once '../core/database.php';
require_once '../core/model.php';
//Thêm file vendor để gửi mail
require_once '../vendor/autoload.php';
// Khởi tạo App
$app = new App();