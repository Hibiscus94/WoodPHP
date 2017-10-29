<?php

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
class WoodPHP
{
    public static $classMap = array();

    public static $appDir = '.';

    public static $module;

    public static $page;

    public static $entry;

    public static $defaultModule = 'home';

    public static $defaultPage = 'index';

    public static $defaultEntry = 'index';

    public static $pathInfo = '';

    public static $splitFlag = "/";

    public static $moduleAlias = array();

    /**
     * @return string
     */
    public static function getAppDir()
    {
        return self::$appDir;
    }

    /**
     * @param string $appDir
     */
    public static function setAppDir($appDir)
    {
        self::$appDir = $appDir;
    }

    /**
     * @return string
     */
    public static function getDefaultModule()
    {
        return self::$defaultModule;
    }

    /**
     * @param string $defaultModule
     */
    public static function setDefaultModule($defaultModule)
    {
        self::$defaultModule = $defaultModule;
    }

    /**
     * @return string
     */
    public static function getDefaultPage()
    {
        return self::$defaultPage;
    }

    /**
     * @param string $defaultPage
     */
    public static function setDefaultPage($defaultPage)
    {
        self::$defaultPage = $defaultPage;
    }

    /**
     * @return string
     */
    public static function getDefaultEntry()
    {
        return self::$defaultEntry;
    }

    /**
     * @param string $defaultEntry
     */
    public static function setDefaultEntry($defaultEntry)
    {
        self::$defaultEntry = $defaultEntry;
    }

    /**
     * @return string
     */
    public static function getPathInfo()
    {
        return self::$pathInfo;
    }

    /**
     * @param string $pathInfo
     */
    public static function setPathInfo($pathInfo)
    {
        self::$pathInfo = $pathInfo;
    }

    /**
     * @return string
     */
    public static function getSplitFlag()
    {
        return self::$splitFlag;
    }

    /**
     * @param string $splitFlag
     */
    public static function setSplitFlag($splitFlag)
    {
        self::$splitFlag = $splitFlag;
    }

    /**
     * @return mixed
     */
    public static function getModuleAlias()
    {
        return self::$moduleAlias;
    }

    /**
     * @param mixed $moduleAlias
     */
    public static function setModuleAlias($moduleAlias)
    {
        self::$moduleAlias = $moduleAlias;
    }


    public static function run($path = '')
    {
        $splitFlag = preg_quote(self::$splitFlag, "/");
        $pathArray = array();
        $hasPath = false;
        if (!empty($path)) {
            $hasPath = true;
        } else {
            if (!empty($_SERVER['PATH_INFO'])) {
                $path = $_SERVER["PATH_INFO"];
            } elseif (!empty($_SERVER['REQUEST_URI'])) {
                $path = $_SERVER["REQUEST_URI"];
            } else {
                self::debug("path not set in params or server.path_info, server.request_uri");
                return false;
            }
        }

        $pathArray = preg_split("/[$splitFlag\/]/", parse_url($path, PHP_URL_PATH), -1, PREG_SPLIT_NO_EMPTY);

        $module = empty($pathArray[0]) ? self::$defaultModule : $pathArray[0];
        $page = empty($pathArray[1]) ? self::$defaultPage : $pathArray[1];
        $entry = empty($pathArray[2]) ? self::$defaultEntry : $pathArray[2];

        // 如果有module别名，获取真实的module
        if (self::$module && ($key = array_search($module, self::$moduleAlias)) !== false) {
            $module = $key;
        }

        if (!$hasPath) {
            self::$module = $module;
            self::$page = $page;
            self::$entry = $entry;
        } else {
            if (self::$module == $module && self::$page == $page && self::$entry == $entry) {
                self::debug("ignored [$path]");
                return false;
            }
        }
        $bootNamespace = str_replace(array('.', '/'), array('', '\\'), self::$appDir);
        $className = $bootNamespace . '\\' . $module . '\\controller' . '\\' . $page . 'Controller';
        if (!class_exists($className)) {
            self::debug("class[$className] not exists");
            return false;
        }
        $classInstance = new $className();
        $pathArray[0] = $module;
        $pathArray[1] = $page;
        $pathArray[2] = $entry;
        $method = $entry;
        return call_user_func(array(&$classInstance, $method), $pathArray);
    }


    /**
     * @param string $debug_msg
     */
    private static function debug($debug_msg)
    {
        if (defined('DEBUG')) {
            error_log($debug_msg);
            echo "woodPHP debug: " . $debug_msg;
        }
    }

    // 自动加载类库
    public static function autoload($class)
    {
        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $path = str_replace("\\", "/", $class);
            $file = '../' . $path . ".class.php";
            if (is_file($file)) {
                self::$classMap[$class] = $class;
                require_once($file);
            } else {
                return false;
            }
        }
    }
}

spl_autoload_register('WoodPHP::autoload');