<?php

namespace testClasses\testClass2;

use testClasses\testClass1\testClass1;

class testClass2
{

    public function __construct() {
        $a = new testClass1();
        $b = new \testClasses\testClass3\testClass3();
    }
}
