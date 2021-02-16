<?php 

class Autoloader {

    static public function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    static public function autoload($classname)
    {
        $path = str_replace('App', 'src', $classname);
        $path = str_replace('\\', '/', $path);

        if (file_exists('../' . $path . '.php')){
            require '../' . $path . '.php';
        }
    }
}