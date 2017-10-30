<?php

namespace core\lib;

/**
 * ,__,
 * (oo)_____
 * (__)     )\
 * ````||---|| *
 * Class WoodPHP   <br>
 * @author mutou <br>
 * @version 1.0.0
 * @description todo <br>
 * @date 2017/10/25 <br>
 */
class Db
{
    private static $engines = ["mysql", "pdo_mysql", "pdo_new_mysql", "mssql", "pdo_mssql"];

    private static $configCache = [];

    private static $configFile;

    private static $defaultSummary = 'default';

    private static $configFilesLoaded = [];

    // 获取数据库引擎
    public static function getDbEngine($engine)
    {

    }

    // 设置数据库配置文件
    public static function setConfigFile($file)
    {
        if (!($file && is_readable($file))) {
            return false;
        }
        if (in_array($file, self::$configFilesLoaded)) {

            echo 1222;
            return true;
        }
        if (self::parseConfigFile($file)) {
            self::$configFile = $file;
            self::$configFilesLoaded[] = $file;
            return true;
        } else {
            return false;
        }
    }

    // 获取数据库配置文件
    public static function getConfigFile()
    {
        return self::$configFile;
    }

    public static function getConfig($summary, $type = "main")
    {
        $cache = self::$configCache;
        if (isset($cache[$summary])) {
            $db = $cache[$summary];
        } elseif (isset($cache[self::$defaultSummary])) {
            $db = $cache[self::$defaultSummary];
        } else {
            return null;
        }
        //不存在query的配置则使用main的配置
        if (!isset($db[$type])) {
            $type = "main";
        }
        if (isset($db[$type])) {
            $i = array_rand($db[$type]);
            return $db[$type][$i];
        } else {
            return null;
        }
    }

    private static function parseConfigFile($file)
    {
        $fileData = parse_ini_file(realpath($file), true);
        if (!$fileData) {
            return false;
        }
        foreach ($fileData as $summaryName => $summaryData) {
            foreach ($summaryData as $configType => $configString) {
                if (strpos($configType, "main") !== false) {
                    $index = "main";
                } elseif (strpos($configType, "query") !== false) {
                    $index = "query";
                } else {
                    continue;
                }
                $configString = str_replace(":", "=", $configString);
                $configString = str_replace(",", "&", $configString);
                parse_str($configString, $configData);
                if ($configData) {
                    self::$configCache[$summaryName][$index][] = $configData;
                }
            }
        }
        return true;
    }
}