<?php
// Initialize the session (начинаем новую сессию)
session_start();
// извлекаем переменные сессии имя пользователя, Id роли и имя роли
//echo "login_error.php:".$_SESSION["username"]. "<br/>";
//echo "login_error.php:".$_SESSION["role_id"]. "<br/>";
//echo "login_error.php:".$_SESSION["role_name"]. "<br/>";
//echo "login_error.php:".$_SESSION["crud_erroir"]. "<br/>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 750px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ошибка доступа!</h1>
                    </div>
                    <div class="alert alert-danger fade in">
                        <p><b><?php echo htmlspecialchars($_SESSION["crud_error"]); ?></b><a href="login.php" class="alert-link">Вернуться</a> и попробовать снова</p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
