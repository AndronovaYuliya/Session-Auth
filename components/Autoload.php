<?php

    /*
     * функция __autoload для автоматического подключения классов
     *
     */

function myAutoload($classname){
    $filename=ROOT.'/models/'.$classname.'.php';
    include_once $filename;
}

//регистрируем загрузчик
spl_autoload_register('myAutoload');