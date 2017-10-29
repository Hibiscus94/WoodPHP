<?php
namespace app\home\controller;

use app\model\UserModel;

/**
 * ,__,
 * (oo)_____
 * (__)     )\
 * ````||---|| *
 * Class ${NAME}   <br>
 * @author mutou <br>
 * @version 1.0.0
 * @description todo <br>
 * @date 2017/10/29 <br>
 */
 class IndexController
 {
     public function index($inPath)
     {
         var_dump($inPath);
         echo 'this is index';
     }

     public function hello($inPath)
     {
         echo 'this is hello';
         $userModel = new UserModel();
         $userModel->index();
     }

     public function __call($name, $arguments)
     {
         echo $_GET['page'];
         echo  112;
     }
 }