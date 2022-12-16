<?php
 session_start(); // начинаем новую сессию

 // извлекаем переменные из сессии, если были установлены
 $link = $_SESSION["link"];

 // Include config file (подключаем файлы)
 require_once "login_role.php";

 include('./login_config.php');

 $thread_id = mysqli_thread_id($link);
 


 // пытаемся добавить данные //////////////////////////////////

 // Define variables and initialize with empty values
 // (определяем и очищаем переменные)
 $first_name = $middle_name = $last_name = $email = $username = $pswd1 =$pswd= "";
 $first_name_err = $middle_name_err = $last_name_err = $email_err = $username_err = $pswd_err =  $pswd1_err = "";
    
 // Processing form data when form is submitted
 // (обрабатываем запрос после нажатия отправки пользователем) 
  // Validate first_name (проверяем фамилию)
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name))
    {
        $first_name_err = "Please enter a first_name.";
    }
    elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $first_name_err = "Please enter a valid first_name.";
    } 
    else
    {
        $first_name = $input_first_name;
    }

    // Validate middle_name (проверяем имя)
    $input_middle_name = trim($_POST["middle_name"]);
    if(empty($input_middle_name))
    {
        $middle_name_err = "Please enter a middle_name.";
    }
    elseif(!filter_var($input_middle_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $middle_name_err = "Please enter a valid middle_name.";
    } 
    else
    {
        $middle_name = $input_middle_name;
    }

    // Validate last_name (проверяем отчество)
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name))
    {
        $last_name_err = "Please enter a last_name.";
    }
    elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $last_name_err = "Please enter a valid last_name.";
    } 
    else
    {
        $last_name = $input_last_name;
    }
    
    // Validate address (проверяем адрес)
    $input_email = trim($_POST["email_address"]);
    if(empty($input_email))
    {
        $email_err = "Please enter an email.";     
    }
    else
    {
        $email = $input_email;
    }


    // Validate address (проверяем адрес)
    $input_username = trim($_POST["username"]);
    if(empty($input_username))
    {
        $username_err = "Please enter an username.";     
    }
    else
    {
        $username = $input_username;
    }


    $input_pswd = trim($_POST["pswd"]);
    if(empty($input_pswd))
    {
        $pswd_err = "Please enter a password.";     
    }
    else
    {
        $pswd = $input_pswd;
    }
    
 /*     elseif(!filter_var($input_pswd, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"?=^.{8,}$)(?=.*\d))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"))))
 */ 


    $input_pswd1 = trim($_POST["pswd1"]);
    if(empty($input_pswd1))
    {
        $pswd1_err = "Please repeat a password.";     
    }
    elseif($input_pswd!=$input_pswd1)
        {
            $pswd1_err="Passwords don't match";
        }
    else
    {
        $pswd1 = $input_pswd1;
    }
    
    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)
    
    
    
    
    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)
    if(empty($first_name_err) && empty($middle_name_err) && empty($last_name_err) && empty($email_err) && empty($username_err) && empty($pswd_err) && empty($pswd1_err))
    {
        $Ares=mysqli_query($link,"SELECT username FROM DB_USERS WHERE username ='$username'");       // $count= mysqli_num_rows($Gres);
        $Acount= $Ares->affected_rows;
         echo "<br/>".$link;
            if($Ares->num_rows>=1){
                $username_if="Такой username уже существует";  
            }
            else{
        $role_id = 2;
        $role_name = "new_user";
            
        // Prepare an insert statement (подготавливаем запрос: символы ? для подстановки параметров)
        $sql = "INSERT INTO DB_USERS (role_id, role_name, first_name, middle_name, last_name, email, username, user_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            }
        if($stmt = mysqli_prepare($link, $sql))
        {
            
            // Bind variables to the prepared statement as parameters
            // (связываем паременные в условии запроса: s - строка, i - целое число)
            mysqli_stmt_bind_param($stmt, "isssssss", $param_role_id, $param_role_name, $param_first_name, $param_middle_name, $param_last_name, $param_email,$param_username, $param_password);
            // Set parameters (запоминаем параметры)
            $param_role_id = $role_id;
            $param_role_name = $role_name;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_username= $username;
            $param_password= $pswd1;
            
        
                /* ------------------------------------------------------------------------------------- */
            
            // Attempt to execute the prepared statement (пытаемся выполнить запрос)
            if(mysqli_stmt_execute($stmt))
            {
                // данные записаны, переходим на страницу login_welcome.php
                header("location: login.php");
                exit();
            }
            else
            {
                echo "(mysqli_stmt_execute) Пользователь не зарегистрирован|||";
            }
        }
    
        else
        {
            echo "Пользователь не зарегистрирован запрос не выполнен!!((<br/>";
            $thread_id = mysqli_thread_id($link);
            echo "thread_id=".$thread_id. "<br/>";
        }
        // Close statement (закрываем условие запроса)
        mysqli_stmt_close($stmt);
    }

    
    // Close connection (закрываем соединение)
    mysqli_close($link);


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Создание новой записи</h2>
                    </div>
                    <p>Заполните данные и отправьте на добавление в базу данных!!</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                            <label>Фамилия</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                            <span class="help-block"><?php echo $first_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($middle_name_err)) ? 'has-error' : ''; ?>">
                            <label>Имя</label>
                            <input type="text" name="middle_name" class="form-control" value="<?php echo $middle_name; ?>">
                            <span class="help-block"><?php echo $middle_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                            <label>Отчество</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                            <span class="help-block"><?php echo $last_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>email</label>
                            <input type="email" name="email_address" class="form-control" value="<?php echo $email; ?>"></input>
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Имя пользователя</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err;?></span>
                            <span class="help-block" style="color: red;"><?php echo $username_if;?></span>

                        </div>

                        <div class="form-group <?php echo (!empty($pswd_err)) ? 'has-error' : ''; ?>">
                            <label>Пароль</label>
                            <input type="password" name="pswd" class="form-control" value="<?php echo $pswd; ?>">
                            <span class="help-block"><?php echo $pswd_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($pswd1_err)) ? 'has-error' : ''; ?>">
                            <label>Повторите пароль</label>
                            <input type="password" name="pswd1" class="form-control" value="<?php echo $pswd1; ?>">
                            <span class="help-block"><?php echo $pswd1_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="login.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
