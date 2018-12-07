<?php

class Authorization
{
    protected static $login = 'admin';
    protected static $password = '$2y$10$rDpsG13U3NrTAyhr2s4HfugXK8lHrZx/hDS.IVdHFDTgW3TChaOgC';//admin
    protected static $logged = false;

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
     * сверка данных
     */
    public static function auth($login, $password):bool
    {
       return ($login==self::$login && password_verify($password,self::$password));
    }

    /**
     * @return bool
     * Проверка авторизации
     */
    public static function isAuth():bool
    {
        return self::$logged;
    }

    /**
     * @return bool
     */
    public static function logout():bool
    {
        Session::destroySession();
        header('Location:  ../index.php');
        exit();
    }

    /*
     * @return bool
     * Валидация логина
    */
    public static function checkLogin($login):bool
    {
        return preg_match('/^[a-z0-9]{3,20}$/i', trim($login));
    }

    /*
     * @return bool
     * Валидация пароля
    */
    public static function checkPass($pass):bool
    {
        return true;
    }
}