<?php

    /*
     * функция __autoload для автоматического подключения классов
     *
     */

    function __autoload($className)
    {
        $paths=['/models/','/controllers/'];

        foreach ($paths as $path)
        {
            $path=ROOT.$path.$className.'.php';

            if(is_file($path))
            {
                require_once $path;
            }
        }
    }
