<?php

// Initialize the session (создаем новую сессию)
session_start();
 header('Content-Type: text/html; charset=utf-8');
// Check if the user is already logged in, if yes then redirect him to welcome page
// (проверяем, были ли установлены переменные входа в систему)
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    // если да, перенаправляем на страницу приветствия
    header("location: login_welcome.php");
    exit;
}
 
// Include config file (подключаем файлы)
require_once "login_config.php";
require_once "login_role.php";
                        
// Define variables and initialize with empty values
// (очищаем переменные)
$username = $user_password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
// (выполняем обработку, когда пользователь отправил данные формы)
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if username is empty (проверка поля "username")
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    }
    else
    {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty (проверка поля "пароль")
    if(empty(trim($_POST["user_password"])))
    {
        $password_err = "Please enter your password.";
    }
    else
    {
        $user_password = trim($_POST["user_password"]);
    }
    
    // Validate credentials (проверка логин-пароля)
    if(empty($username_err) && empty($password_err))
    {
        // Prepare a select statement (формируем строку запроса пароля)
        $sql = "SELECT user_password FROM DB_USERS WHERE username = '".$username."'";
        if($rows = mysqli_query($link, $sql)) // считываем строки ответа
        {
            if( $row = mysqli_fetch_row($rows)) // получаем 0ю строку ответа
            {   // 0й элемент 0й строки должен содержать пароль
                if($row[0] === $user_password) // если равен введенному, авторизуемся 
                {   // 1й строки быть не должно, т.к. другого пароля не полагается
                    if(empty(mysqli_fetch_row($rows)))
                    {
                        mysqli_free_result($rows); // очищаем результаты
                        //$thread_id = mysqli_thread_id($link);
                        //echo "login.php:".$thread_id. "<br/>";//лог потока БД
                        
                        // Store data in session variables (запоминаем переменные сессии)
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["link"] = $link;
                        
                        // считываем роль: возвращаемого значения нет, если ОК
                        echo setrole_by_username($username, $link);
                        //echo "login.php:".$_SESSION["username"]. "<br/>";
                        //echo "login.php:".$_SESSION["role_id"]. "<br/>";
                        //echo "login.php:".$_SESSION["role_name"]. "<br/>";
                        // Password is correct, so start a new session (начинаем новую сессию)                        
                        session_start();
                        // Redirect user to welcome page (перенаправляем на страницу приветствия)
                        // строку можно временно закомментить, если раскомментировать echo!!!
                        header("location: login_welcome.php"); 
                    }
                    else
                    {
                        // заполняем переменную ошибки, если пароль неправильно считан
                        $password_err = "Ошибка считывания пароля из базы данных!";
                        "<\n>";
                    }
                }
                else
                {   // переменная ошибки для отображения на форме
                    $password_err = "Введен неправильный пароль!";
                    "<\n>";
                }
            }
            else
            {
                // переменная ошибки для отображения на форме
                $username_err = "Введено несуществующее имя пользователя";
                "<\n>";
                
            }
        }
        else
        {
            echo "Запрос к базе данных не выполнен!";
        }
    }
    // Close connection (закрываем соединение к БД)
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Заполните данные логин-пароля</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Имя пользователя (логин)</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Пароль</label>
                <input type="password" name="user_password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Вход">
                <input type="button" class="btn btn-primary"  onclick="window.location.href='gost.php'" value="Зайти как гость">
                <input type="button" class="btn btn-primary"  onclick="window.location.href='CRUD_create_user.php'" value="Регистрация">
               
            </div>
            <div class="form-group">
             
        <div class="form-group">
              <!--<input type="button" class="btn btn-primary"  onclick="window.location.href='G_CRUD_read.php'" value="">-->
        </div>
        </form>
    </div>    
</body>
</html>
