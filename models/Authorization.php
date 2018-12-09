<?php

class Authorization
{
    private static $login = 'admin';
    private static $password = '$2y$10$rDpsG13U3NrTAyhr2s4HfugXK8lHrZx/hDS.IVdHFDTgW3TChaOgC';//admin
    private static $logged = false;
    private static $user = null;

    /**
     * @return string $login
     */
    public static function getLogin():string
    {
        return self::$login;
    }

    /**
     * @return string $password
     */
    private static function getPassword():string
    {
        return self::$password;
    }

    /**
     * @return bool
     */
    public static function login($login, $password):bool
    {
        if($login==self::$login && password_verify($password,self::$password))
        {
            self::$logged=true;
            self::$user=self::$login;
            Session::startSession();
            self::addToSession();
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function isAuth():bool
    {
        Session::startSession();
        $data=Session::get(self::$login);

        if (!empty($data) && Session::checkCookie())
        {
            self::$logged=true;
            session_decode($data);
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function logout():bool
    {
        return Session::destroySession();
    }

    /*
     * @return bool
    */
    public static function checkLogin($login):bool
    {
        return preg_match('/^[a-z0-9]{3,20}$/i', trim($login));
    }

    /*
     * @return bool
    */
    public static function checkPass($pass):bool
    {
        return true;
    }

    /*
     * @void
    */
    private static function addToSession()
    {
        Session::set('remote_addr', $_SERVER['REMOTE_ADDR']);
        Session::set('user_agent', $_SERVER['HTTP_USER_AGENT']);
        Session::set(self::$login, session_encode());
    }
}