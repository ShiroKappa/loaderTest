<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shirokappa
 * Date: 12/07/16
 * Time: 0:24
 * To change this template use File | Settings | File Templates.
 */
namespace testClasses\testClass2;

use testClasses\testClass1\testClass1;

class testClass2
{

    public function __construct() {
        $a = new testClass1();
        $b = new \testClasses\testClass3\testClass3();
    }
}
