<?php
//Подключение файлов системы
define('ROOT', dirname(__FILE__));
include_once (ROOT.'/components/Autoload.php');

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    $errors=false;
    $msg='';
    //авторизация
    if (isset($_POST['sign_in']))
    {
        $userId=false;
        $login=$_POST['inputLogin'];
        $password=$_POST['inputPassword'];
        //Валидация логина
        if(!Authorization::checkLogin($login))
        {
            $errors[]='Enter a valid username';
        }
        //Валидация пароля
        if(!Authorization::checkPass($password))
        {
            $errors[]='Enter the correct password';
        }

        //проверка существования пользователя
        $userId=Authorization::login($login, $password);
        if($userId)
        {
            $msg='Hola '.Authorization::getLogin().'!';
        }
        else
        {
            $errors[]='Wrong login or password';
        }
    }

    //проверка на авторизацию
    if (isset($_POST['is_auth']))
    {
        if(Authorization::isAuth())
        {
            $msg='You are logged in!';
        }
        else
        {
            Authorization::logout();
            $errors[]='You are not logged in';
        }
    }

    //logout
    if(isset($_POST['logout']))
    {
        if(Authorization::isAuth())
        {
            Authorization::logout();
            $errors[]='See you later!';
        }
        else
        {
            Authorization::logout();
            $errors[]='You are not logged in';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="AndronovaYuliya">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <title>AndronovaShop</title>
</head>


<body class="text-center">

    <form class="form-signin" role="form" method="post">
        <?php if(isset($msg)) echo $msg;?>
        <table>
            <?php foreach($errors as $key=>$value): ?>
                <tr>
                    <td><?php echo $value; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputLogin" class="sr-only">Login</label>
        <input type="text" id="inputLogin" class="form-control" placeholder="James Bond" name="inputLogin" value="<?php echo $_POST['inputLogin']?>" autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="inputPassword" value="">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="sign_in">Enter</button>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="is_auth">Is auth</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="logout">Logout</button>
    </form>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>