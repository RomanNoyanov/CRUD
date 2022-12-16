<?php
// Initialize the session (начинаем новую сессию)
session_start();

// Check if the user is logged in, if not then redirect him to login page
// проверяем, был ли выполнен вход; если нет, отправляем на страницу входа
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php"); // перенаправляем на страницу входа
    exit;
}

// извлекаем переменные сессии имя пользователя, Id роли и имя роли
$username = $_SESSION["username"];
$role_id = $_SESSION["role_id"];
$role_name = $_SESSION["role_name"];
echo "Имя пользователя:" . $_SESSION["username"] . "<br/>";
//echo "login_welcome.php:".$_SESSION["role_id"]. "<br/>";
echo "Статус вашего аккаунта:" . $_SESSION["role_name"] . "<br/>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page-header">
        <h1>Здравствуйте, <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
            </b>(<?php echo htmlspecialchars($_SESSION["role_name"]); ?>). Добро пожаловать на сайт!</h1>
    </div>
    <p>
        <a href="login_logout.php" class="btn btn-danger">Выйти из аккаунта</a>
    </p>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .body {
            font: 14px sans-serif;
            text-align: center;
        }

        .wrapper {
            width: 650px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <input type="button" class="btn btn-primary" onclick="window.location.href='CRUD_create_user.php'" value="Регистрация нового пользователя">

    <!--  <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
       < <a href="login_logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
    -->
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                       <!--  <h2 class="pull-left">Employees Details</h2>-->
                        <form method='post'>
                         <!--   <button type='submit' class="btn btn-success pull-right" name='click' value='1'>Add New Employee</button>-->
                    </div>
                    <?php if (($role_id === "1") or ($role_id === "5")) : ?>

                        <div class="form-group">

                            <div class="form-group">
                                <input type="button" class="btn btn-primary" onclick="window.location.href='A_CRUD_create.php'" value="Добавить аксессуар к плите">
                                <input type="button" class="btn btn-primary" onclick="window.location.href='E_CRUD_create.php'" value="Добавить электрическую плиту">
                            </div>
                                                        <input type="button" class="btn btn-primary" onclick="window.location.href='CRUD_create.php'" value="Добавить газовую плиту ">

                        </div>
                    <?php endif; ?>
<div class="form-group">
              <input type="button" class="btn btn-primary"  onclick="window.location.href='G_CRUD_read.php'" value="Поиск по идентификатору (Id)">
        </div>
                </div>
                <div class="form-group">
                </div>
                </form>

            </div>
            <?php

            // Include config file (подключаем файл)
            require_once "login_config.php";

            if (isset($_POST['click']) && !empty($_POST['click'])) {   // перенаправляем на создание записи
                header("location:CRUD_create.php");
            }

            // Attempt select query execution (готовим запрос)
            if (($role_id === "1") or ($role_id === "5")) {
                $sql = "SELECT * FROM DB_USERS";
            } else {
                $sql = "SELECT * FROM DB_USERS WHERE  username = " . "'" . $username . "'" . ";";
            }
            if ($result = mysqli_query($link, $sql)) {   // если запрос выполнен, заполняем таблицу!!
                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>user id</th>";
                    echo "<th>role name</th>";
                    echo "<th>first name</th>";
                    echo "<th>middle name </th>";
                    echo "<th>last name </th>";
                    echo "<th>e-mail </th>";
                    echo "<th>user name </th>";
                    echo "<th>created date </th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['role_name'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['middle_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>";
                        if (($role_id === "1") or ($role_id === "5")) {

                            echo "<a href='CRUD_read_users.php?user_id=" . $row['user_id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                            echo "<a href='CRUD_update.php?user_id=" . $row['user_id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                            echo "<a href='CRUD_delete.php?user_id=" . $row['user_id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                        } else {
                            echo "<a href='CRUD_read_users.php?user_id=" . $row['user_id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                            echo "<a href='CRUD_update.php?user_id=" . $row['user_id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set (очищаем результаты запроса)
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>Ошибка! Записи не найдены!</em></p>";
                }
            } else {
                echo "Ошибка! Не выполнен запрос: " . $sql . " " . mysqli_error($link);
            }
            // Close connection (закрываем соединение с базой данных)
            mysqli_close($link);
            ?>
        </div>
    </div>
    </div>
    </div>
</body>

</html>