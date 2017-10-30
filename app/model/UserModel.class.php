<?php

namespace app\model;

use \Medoo\Medoo;
/**
 * ,__,
 * (oo)_____
 * (__)     )\
 * ````||---|| *
 * Class model   <br>
 * @author mutou <br>
 * @version 1.0.0
 * @description todo <br>
 * @date 2017/10/29 <br>
 */


class UserModel extends Medoo
{
    public function index($inPath)
    {
        dump($inPath);
        echo 'usermodel';
    }
}