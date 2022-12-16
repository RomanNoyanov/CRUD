<?php

// Check existence of id parameter before processing further
if(isset($_GET["user_id"]) && !empty(trim($_GET["user_id"])))
{
    // Include config file
    require_once "login_config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM DB_USERS WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["user_id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
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
                
                
               
            } 
            else
            {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
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
    header("location: CRUD_error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Роль ID</label>
                        <p class="form-control-static"><?php echo $row["role_id"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Роль</label>
                        <p class="form-control-static"><?php echo $row["role_name"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Имя</label>
                        <p class="form-control-static"><?php echo $row["first_name"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Отчество</label>
                        <p class="form-control-static"><?php echo $row["middle_name"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Фамилия</label>
                        <p class="form-control-static"><?php echo $row["last_name"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>E-Mail </label>
                        <p class="form-control-static"><?php echo $row["email"]; ?></p>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>User Name</label>
                        <p class="form-control-static"><?php echo $row["username"];; ?></p>
                    </div>
                    <hr/>
                   
                    <p><a href="login_welcome.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
