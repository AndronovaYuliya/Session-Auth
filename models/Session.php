<?php

class Session
{
    private static $cookieName='';
    private static $started=false;
    private static $lifeTime=6000;

    //проверка на существование сессии
    public static function isCreated()
    {
      return (!empty($_COOKIE[self::$cookieName]));
    }

    //старт сессии
    public static function startSession()
    {
        if(!self::$started)
        {
            session_set_cookie_params(self::$lifeTime, '/', false, true);
           // session_save_path(dirname($_SERVER['DOCUMENT_ROOT']).'/Shop/var/session');

            if(!empty($_COOKIE[self::$cookieName])){
                unset($_COOKIE[self::$cookieName]);
            }
            //session_name(self::$cookieName);
            session_start();
            self::set('remote_addr', $_SERVER['REMOTE_ADDR']);
            self::set('user_agent', $_SERVER['HTTP_USER_AGENT']);
            self::$started=true;
        }
    }

    //установка параметров сессии
    public static function set($name, $value)
    {
        if(self::$started)
        {
            $_SESSION[$name]=$value;
        }
    }

    //получение параметров сессии
    public static function get($name):?string
    {
        if(self::$started)
        {
            return isset($_SESSION[$name])?$_SESSION[$name]:null;
        }
    }


    //удаление параметров сессии
    public static function delete($name)
    {
        if(self::$started)
        {
            unset($_SESSION[$name]);
        }
    }

    //удаление сессии
    public static function destroySession()
    {
        if(self::$started)
        {
            unset($_COOKIE[self::$cookieName]);
            setcookie(self::$cookieName,'',1, '/');
            session_destroy();
            self::$started=false;
        }
    }

    //проверка на кражу cookie
    private static function checkCookie():bool
    {
       return ($_SESSION['ua']==$_SERVER['HTTP_USER_AGENT'] && $_SESSION['remote_addr']==$_SERVER['REMOTE_ADDR']);
    }

}