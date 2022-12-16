<?php
// Include config file
require_once "login_config.php";
session_start();

//$link = $_SESSION["link"];
//$username = $_SESSION["username"];
//$role_id = $_SESSION["role_id"];
//$role_name = $_SESSION["role_name"];
// Define variables and initialize with empty values
$first_name = $middle_name = $last_name = $email = $username = $pswd = $pswd1 = "";
$first_name_err = $middle_name_err = $last_name_err = $email_err = $username_err = $pswd_err =  $pswd1_err = "";

// Processing form data when form is submitted
if(isset($_POST["user_id"]) && !empty($_POST["user_id"]))
{
    echo "Прошли первое условие";
    // Get hidden input value
    $id = $_POST["user_id"];
    
    // Validate first_name (проверяем фамилию)
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name))
    {
        $first_name_err = "Please enter a first_name.";
    }
    elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\sа-яА-Я]+$/"))))
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
    elseif(!filter_var($input_middle_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-я\s]+$/"))))
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
    elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zа-яА-Я\s]+$/"))))
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
    /*elseif(!filter_var($input_pswd, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?=.*[@$!%*?&])(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"))))
    {
        $pswd_err = "Re-enter password";
    }  */
    else
    {
        $pswd = $input_pswd;
    }
  

    $input_pswd1 = trim($_POST["pswd1"]);
    if(empty($input_pswd1))
    {
        $pswd1_err = "Please repeat a password.";     
    }
    elseif($input_pswd != $input_pswd1)
        {
            $pswd1_err="Passwords don't match";
        }
    else
    {
        $pswd1 = $input_pswd1;
    }
    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($middle_name_err) && empty($last_name_err) && empty($email_err) && empty($username_err) && empty($pswd_err) && empty($pswd1_err))
    {echo "Второе условие прошли";
        // Prepare an update statement
        $sql = "UPDATE DB_USERS SET  first_name=?, middle_name=?, last_name=?, email=?, username=?, user_password=?  WHERE user_id=?";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            echo "Третье условие прошли(121)";
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "sssssss", $param_first_name, $param_middle_name, $param_last_name, $param_email,$param_username, $param_password,$id);
            echo "125";
            // Set parameters (запоминаем параметры)
            //$param_role_id = $role_id;
            //$param_role_name = $role_name;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_username= $username;
            $param_password= $pswd;



            //echo "param_role_id = ".$param_role_id."<br>";
            //echo "param_role_name = ".$param_role_name."<br>";
            echo "param_first_name = ".$param_first_name."<br>";
            echo "param_middle_name = ".$param_middle_name."<br>";
            echo "param_last_name = ". $param_last_name."<br>";
            echo "param_email = ". $param_email."<br>";
            echo "param_username = ". $param_username."<br>";
            echo "param_password = ". $param_password."<br>";
            
            // Attempt to execute the prepared statement
            $result = mysqli_stmt_execute($stmt);
            //mysqli_stmt_error_list($stmt);
            var_dump(mysqli_stmt_error_list($stmt));
            if($result)
            {   

                echo "Четвертое условие прошли(148)";

                // Records updated successfully. Redirect to landing page
                header("location: login_welcome.php");
                exit();
            } 
            else
            {
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} 
else
{
    // Check existence of id parameter before processing further
    if(isset($_GET["user_id"]) && !empty(trim($_GET["user_id"]))){
        // Get URL parameter
        $id =  trim($_GET["user_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM DB_USERS WHERE user_id=?";
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1)
                {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $role_id = $row["role_id"];
                    $role_name = $row["role_name"];
                    $first_name = $row["first_name"];
                    $middle_name = $row["middle_name"];
                    $last_name = $row["last_name"];
                    $email = $row["email"];
                    $username = $row["username"];
                    $password = $row["user_password"];
                } 
                else
                {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: CRUD_error.php");
                    exit();
                }
                
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
        // URL doesn't contain id parameter. Redirect to error page
        //header("location: CRUD_error.php");
        echo "Ошибка доступа";
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактирование записи</title>
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
                        <h2>Редактирование записи</h2>
                    </div>
                    <p>Заполните данные и отправьте на обновление в базу данных!!</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                        <!--<div class="form-group">
                            <label>Роль</label>
                            <select class="form-control" name="role_name">;
                            <?php
                            $result_role = mysqli_query($link,"SELECT DISTINCT role_name FROM users");
                            while($row_role = mysqli_fetch_array($result_role)){
                            echo '<option value="'.$row_role['role_name'].'">'.$row_role['role_name'].'</option>';   
                            /*if ($role_name == "PassiveUser") {
                                              $role_id = 1;
                                          }  
                            elseif ($role_name == "ActiveUser") {
                                              $role_id = 2;          
                                           }   
                            elseif ($role_name == "Moderator") {
                                              $role_id = 3;
                                     }
                            elseif ($role_name == "Admin") {
                                              $role_id = 4;
                                     }  */        
                            }
                            ?>
                            </select>
                        </div>-->



                        <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                            <label>Имя</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                            <span class="help-block"><?php echo $first_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($middle_name_err)) ? 'has-error' : ''; ?>">
                            <label>Отчество</label>
                            <input type="text" name="middle_name" class="form-control" value="<?php echo $middle_name; ?>">
                            <span class="help-block"><?php echo $middle_name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                            <label>Фамилия</label>
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

                        <input type="hidden" name="user_id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="login_welcome.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
