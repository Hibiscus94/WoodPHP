<?php
/**
 * ,__,
 * (oo)_____
 * (__)     )\
 * ````||---|| *
 * 入口文件 <br>
 * @author mutou <br>
 * @version 1.0.0
 * @date 2017/10/25 <br>
 */
date_default_timezone_set("Asia/Shanghai");

define('DEBUG', true);//调试模式

// 加载composer
require_once('../vendor/autoload.php');

WoodPHP::setAppDir('../app');
WoodPHP::setDefaultModule('home');
WoodPHP::setDefaultPage('index');
WoodPHP::setDefaultEntry('index');
WoodPHP::setSplitFlag('/');

\core\lib\Db::setConfigFile('../app/config/db.ini.php');

// 应用初始化
WoodPHP::run();