<?php

class Autoloader
{
    private $paths = array();

    public function addPath($path)
    {
        if (is_string($path)) {
            $path = rtrim($path, '/');
            array_push($this->paths, $path);
        }
    }

    public function register()
    {
        spl_autoload_register(array($this, 'load'), true);
    }

    public function load($className)
    {
        $className = str_replace('_', DIRECTORY_SEPARATOR, $className);
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filename  = $className . '.php';
        foreach ($this->paths as $path) {
            $fullPath = $path . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($fullPath) && is_readable($fullPath)) {
                include $filename;
                return;
            }
        }
    }
}
