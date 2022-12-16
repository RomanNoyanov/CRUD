<?php
session_start(); // начинаем новую сессию

// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];
$username = $_SESSION["username"];
$role_id = $_SESSION["role_id"];
$role_name = $_SESSION["role_name"];

// Include config file (подключаем файлы)
require_once "login_role.php";
echo "CRUD_delete.php, username: ".$username."<br/>";
echo "CRUD_delete.php, role_id: ".$role_id."<br/>";
echo setrole_by_username($username, $link);
include('./login_config.php');
echo "CRUD_delete.php, role_id: ".$role_id."<br/>";
$thread_id = mysqli_thread_id($link);
echo "!!!CRUD_delete.php: thread_id=".$thread_id. "<br/>";

// Проверка роли: 1 - админ
if($role_id !== '1') // если не админ 
{
    // запоминаем ошибку для отображения в файле CRUD_error.php
    $_SESSION["crud_error"] = "Недостаточно прав для удаления данных!!!";
    //header("location: CRUD_error.php");
    exit;
}

// пытаемся удалить данные /////////////////////////////////////
if(isset($_POST["user_id"]) && !empty($_POST["user_id"]))
{
    // Include config file (подключаем файл конфигурации)
    require_once "login_config.php";
    
    // Prepare a delete statement (подготавливаем запрос)
    $sql = "DELETE FROM DB_USERS WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["user_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            // Records deleted successfully. Redirect to landing page
            header("location: login_welcome.php");
            exit();
        } 
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
}
else
{
    // Check existence of id parameter
    if(empty(trim($_GET["user_id"])))
    {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: CRUD_error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Удаление записи</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper
        {
            width: 500px;
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
                        <h1>Удаление записи</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="user_id" value="<?php echo trim($_GET["user_id"]); ?>"/>
                            <p>Are you sure you want to delete this record?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="login_welcome.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>