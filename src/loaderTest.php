<?php

namespace src;

use testClasses\testClass2\testClass2;
use testClasses\testClass4\testClass4;

class loaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \ShiroKappa\lib\ClassLoader\SimpleClassLoader;
     */
    protected $loader;

    public function setUp() {

        $loaderPath = __DIR__ . '/../ShiroKappa/lib/ClassLoader/SimpleClassLoader.php';
        if ('/' !== DIRECTORY_SEPARATOR) {
            $loaderPath = str_replace('/',DIRECTORY_SEPARATOR,$loaderPath);
        }
        $loaderPath = realpath($loaderPath);
        require_once($loaderPath);

        $this->loader = new \ShiroKappa\lib\ClassLoader\SimpleClassLoader();
        $this->loader->setDebug(TRUE);

        $kappaBasePath = __DIR__ . DIRECTORY_SEPARATOR . '..';
        $realKappaBasePath = realpath($kappaBasePath);
        $this->loader->registerNamespace('ShiroKappa\lib',$realKappaBasePath);

        $sampleBasePath = __DIR__;
        $this->loader->registerNamespace('testClasses',$sampleBasePath);
        $this->loader->register();
    }


    /**
     * @test
     */
    public function countRead() {
        $this->assertSame(0,$this->loader->classSearchCount);
        $test = new testClass4();
        $this->assertSame(1,$this->loader->classSearchCount);
        $test = new \testClasses\testClass1\testClass1();
        $this->assertSame(2,$this->loader->classSearchCount);
        $test = new testClass2();
        $this->assertSame(4,$this->loader->classSearchCount);
    }
}
