<?php
/**
 * Created by JetBrains PhpStorm.
 * User: shirokappa
 * Date: 12/07/08
 * Time: 21:54
 * To change this template use File | Settings | File Templates.
 */
namespace ShiroKappa\lib\ClassLoader;

class SimpleClassLoader
{

    /**
     * @var array
     */
    protected $namespaces;
    /**
     * @var boolean
     */
    protected $debug;
    /**
     * @var integer
     */
    public $fileSearchCount;
    /**
     * @var integer
     */
    public $classSearchCount;
    /**
     * @var array
     */
    public $readStuck;

    /**
     * @return SimpleClassLoader
     */
    public function __construct()
    {
        $this->namespaces = array();
        $this->fileSearchCount = 0;
        $this->classSearchCount = 0;
        $this->readStuck = array();
    }


    /**
     * @param bool $prepend
     * @return void
     */
    public function register($prepend = FALSE) {
        spl_autoload_register(array($this,'loadClass'),TRUE,$prepend);
    }


    /**
     * @param array $namespaces
     * @return void
     */
    public function registerNamespaces(array $namespaces) {
        foreach ($namespaces as $namespace => $filePath) {
            $this->namespaces[$namespace] = $filePath;
        }
    }


    /**
     * @param string $namespace
     * @param string $filePath
     * @return void
     */
    public function registerNamespace($namespace,$filePath) {
        $this->namespaces[$namespace] = $filePath;
    }


    /**
     * @param string $class
     * @return void
     */
    public function loadClass($class) {
        if (TRUE === $this->debug) {
            $this->classSearchCount++;
            $this->readStuck[] = 'class ' . $this->classSearchCount . ':' . $class;
        }
        $file = $this->findFile($class);
        if (0 !== strlen($file)) {
            require($file);
        }
    }


    /**
     * @param string $class
     * @return string
     */
    protected function findFile($class) {
        $lastBackSlashPosition = strrpos($class,'\\');
        $namespace = substr($class,0,$lastBackSlashPosition);
        $convertedNamespace = str_replace('\\',DIRECTORY_SEPARATOR,$namespace);
        foreach ($this->namespaces as $ns => $path) {
            if (0 !== strpos($namespace,$ns)) {
                continue;
            }
            $className = substr($class,$lastBackSlashPosition + 1);
            $file = $path . DIRECTORY_SEPARATOR . $convertedNamespace . DIRECTORY_SEPARATOR . $className . '.php';
            if (TRUE === $this->debug) {
                $this->fileSearchCount++;
                $this->readStuck[] = 'file  ' . $this->fileSearchCount . ':' . $file;
            }
            if (TRUE === is_readable($file)) {
                return $file;
            }
        }
        return '';
    }


    /**
     * @param boolean $mode
     * @return void
     */
    public function setDebug($mode = FALSE) {
        $this->debug = $mode;
    }
}
