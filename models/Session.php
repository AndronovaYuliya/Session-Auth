<?php

class Session
{
    private static $cookieName='sid';
    private static $started=false;
    private static $lifeTime=86400;

    public static function isCreated():bool
    {
        return (!empty($_COOKIE[self::$cookieName]));
    }

    /*
    *@ Return void
    */
    public static function startSession()
    {
        if(!self::$started) {
            session_set_cookie_params(self::$lifeTime);
            session_save_path(dirname($_SERVER['DOCUMENT_ROOT']) . '/Shop/var/session');
            session_name(self::$cookieName);
            session_start();
            self::$started = true;
        }
    }

    /*
     *@ Return void
     */
    public static function set($name, $value)
    {
        if(self::$started)
        {
            $_SESSION[$name]=$value;
        }
    }

    /*
     * @ Return Mixed
     */
    public static function get($name)
    {
        if(self::$started)
        {
            return $_SESSION[$name];
        }
        return null;
    }


    public static function delete($name)
    {
        if(self::$started)
        {
            unset($_SESSION[$name]);
        }
    }

    /*
   *@ Return bool
   */
    public static function destroySession():bool
    {
        if(self::$started)
        {
            setcookie(self::$cookieName,'',time()-1, '/');
            session_destroy();
            unset($_SESSION);
            self::$started=false;
            return true;
        }
        return false;
    }

    /*
   *@ Return bool
   */
    public static function checkCookie():bool
    {
        if(!empty($_COOKIE[self::$cookieName]))
        {
            if($_SESSION['user_agent']==$_SERVER['HTTP_USER_AGENT'] && $_SESSION['remote_addr']==$_SERVER['REMOTE_ADDR'])
            {
                return true;
            }
            else
            {
                self::destroySession();
                return false;
            }
        }
    }

    public static function getSession():array
    {
        if(self::$started)
        {
            return $_SESSION;
        }
    }
}