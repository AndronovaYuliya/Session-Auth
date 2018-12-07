<?php
include_once  dirname(__FILE__,2).'/models/Authorization.php';
include_once  dirname(__FILE__,2).'/models/Session.php';
FormController::actionForm();
//контроллер кнопки
class FormController
{
    //переменные формы
    private static $login='';
    private static $password='';
    private static $userId=false;
    private static $errors=[];
    /*
     * Action для формы
     */
    public static function actionForm()
    {
        //обработка формы
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            self::$errors=false;

            //авторизация
            if (isset($_POST['sign_in']))
            {
                self::$userId=false;
                self::$login=$_POST['inputLogin'];
                self::$password=$_POST['inputPassword'];
                //Валидация логина
                if(!Authorization::checkLogin(self::$login))
                {
                    self::$errors[]='Enter a valid username';
                }
                //Валидация пароля
                if(!Authorization::checkPass(self::$password))
                {
                    self::$errors[]='Enter the correct password';
                }


                //проверка существования пользователя
                self::$userId=Authorization::auth(self::$login, self::$password);

                if(self::$userId)
                {
                    Session::startSession();
                    header('Location:  ../index.php');
                    exit();
                }
                else
                {
                    self::$errors[]='Wrong login or password';
                }
            }
        }

            //проверка на авторизацию
        if (isset($_POST['is_auth']))
            {
                if(Authorization::isAuth())
                {
                    header('Location:  ../index.php');
                    exit();
                }
                else
                {
                    self::$errors[]='You are not logged in';
                }
            }

            //logout
        if(isset($_POST['logout']))
        {
            if(Authorization::isAuth())
            {
                //Authorization::logout();
                header('Location:  ../index.php');
                exit();
            }
            else
            {
                self::$errors[]='You are not logged in';
            }
        }
    }
}