<?php

//namespace core\lib;

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
class WoodPHP2
{
    public static $classMap = array();

    public static function run()
    {
        //$route = new Route();
        echo 111;
    }

    // 自动加载类库
    public static function autoload($class)
    {
        //echo $class;die;
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