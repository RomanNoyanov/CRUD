<?php
session_start(); // начинаем новую сессию

// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];

// Include config file (подключаем файлы)
require_once "login_role.php";

include('./login_config.php');
header('Content-Type: text/html; charset=utf-8');
$thread_id = mysqli_thread_id($link);



// пытаемся добавить данные //////////////////////////////////

// Define variables and initialize with empty values
// (определяем и очищаем переменные)
$T_A_name = $T_A_tip = $T_A_fun = $T_A_price = "";
$T_A_name_err = $T_A_tip_err = $T_A_fun_err = $T_A_price_err = "";

// Processing form data when form is submitted
// (обрабатываем запрос после нажатия отправки пользователем) 
// Validate first_name (проверяем фамилию)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input_T_A_name = trim($_POST["T_A_name"]);
    if (empty($input_T_A_name)) {
        $T_A_name_err = "Please enter a name.";
    } else {
        $T_A_name = $input_T_A_name;
    }

    // Validate  _Gaz_Proizvod  
    $input_T_A_tip = trim($_POST["T_A_tip"]);
    if (empty($input_T_A_tip)) {
        $T_A_tip_err = "Please enter a tip";
    }
    /* elseif (!filter_var($input_T_A_tip, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_A_tip_err = "Please enter a valid tip";
} */ else {
        $T_A_tip = $input_T_A_tip;
    }

    // Validate Size (проверяем отчество)
    $input_T_A_fun = trim($_POST["T_A_fun"]);
    if (empty($input_T_A_fun)) {
        $T_A_fun_err = "Please enter a func";
    } else {
        $T_A_fun = $input_T_A_fun;
    }

    // Validate address (проверяем адрес)
    $input_T_A_price = trim($_POST["T_A_price"]);
    if (empty($input_T_A_price)) {
        $T_A_price_err = "Please enter an price.";
    } elseif (!filter_var($input_T_A_price, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_A_price_err = "Please enter a valid price.";
    } else {
        $T_A_price = $input_T_A_price;
    }



    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)



    //echo " ошибка до 146"."<br/>";
    // echo  $T_Gaz_Name."=  ". $T_Gaz_Proizvod ."=   ".$T_Gaz_size. "=   ".$T_Gaz_Color . "=   ".$T_Gaz_Fun. "=     ".$T_Gaz_Kol_vo_Komf. "=    ".$T_Gaz_Tip ."=  ".$T_Gaz_prise."=";
    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)
    if (empty($T_A_name_err) && empty($T_A_fun_err) && empty($T_A_price_err)) {
        //echo " ошибка до 151";
        $s="SELECT T_A_name FROM Accessories WHERE T_A_name ='$T_A_name'";
        echo $s;
        $Ares = mysqli_query($link,$s );     
        /*  $count= mysqli_num_rows($Gres);
         echo $count; */

        $Acount = $Ares->affected_rows;
        echo "<br/>" . $T_A_name;
      //echo "<br/>".(isset($link) ?"1":"0");
      echo "<br/>" . $Ares->num_rows;
        if ($Ares->num_rows >= 1) {
          /*   if ($count>= 1) { */

            $name_if = "Такое название уже существует";
            echo $name_if;
        }
        else{
            $sql = "INSERT INTO Accessories (T_A_name, T_A_tip, T_A_fun, T_A_price) VALUES  (?, ?, ?, ?)";
        }

        // Prepare an insert statement (подготавливаем запрос: символы ? для подстановки параметров)

        if ($stmt = mysqli_prepare($link, $sql)) {
            // echo "<br/>" . $sql . "</br>";
            // Bind variables to the prepared statement as parameters
            // (связываем паременные в условии запроса: s - строка, i - целое число)
            mysqli_stmt_bind_param($stmt, "siss", $param_T_A_name, $param_T_A_tip, $param_T_A_fun, $param_T_A_price);
            // Set parameters (запоминаем параметры)
            // echo $stmt;
            //  echo " ошибка 165";
            $param_T_A_name = $T_A_name;
            $param_T_A_tip = $T_A_tip;
            $param_T_A_fun = $T_A_fun;
            $param_T_A_price = $T_A_price;


            //echo "<br/>"."param_T_Gaz_Name=".$param_T_Gaz_Name."<br/>"."param_T_Gaz_Proizvod=".$param_T_Gaz_Proizvod."<br/>".$param_T_Gaz_size."<br/>".$param_T_Gaz_Color;
            /* ------------------------------------------------------------------------------------- */

            // Attempt to execute the prepared statement (пытаемся выполнить запрос)
            if (mysqli_stmt_execute($stmt)) {
                // данные записаны, переходим на страницу login.php
                header("location: login.php");
                exit();
            } else {
                echo  "<br/>" . "(mysqli_stmt_execute) Плита  не добавлена";
            }
        } else {
            echo "Возникла проблема при добавлении!((<br/>";
            $thread_id = mysqli_thread_id($link);
            echo "thread_id=" . $thread_id . "<br/>";
        }
        // Close statement (закрываем условие запроса)

    }
    mysqli_stmt_close($stmt);



    // Close connection (закрываем соединение)


    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
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
                        <div class="form-group <?php echo (!empty($T_A_name_err)) ? 'has-error' : ''; ?>">
                            <label>Название</label>
                            <input type="text" name="T_A_name" class="form-control" value="<?php echo $T_A_name; ?>">
                            <span class="help-block"><?php echo $T_A_name_err; ?></span>
                            <span class="help-block" style="color: red;"><?php echo $name_if; ?></span>

                        </div>
                        <div class="form-group>">
                            <label>Тип</label>


                            <!-- ---------------------------------- -->
                            <?php
                            $sql1 = "SELECT * FROM Tip_Plit";
                            $result_tip = mysqli_query($link, $sql1);
                            echo "<select class='form-control' name='T_A_tip'><option selected  value='2'>Выбор типа</option>";
                            while ($row = mysqli_fetch_array($result_tip)) {
                                echo '<option value="' . $row['Tip_Plit_id'] . '">' . $row['Tip_Plit_name'] . '</option>';
                            }
                            ?>

                            </select>
                            <!--  <span class="help-block">
                         
                        </span> -->
                        </div>

                        <div class="form-group <?php echo (!empty($T_A_fun_err)) ? 'has-error' : ''; ?>">
                            <label>Описание </label>
                            <input type="text" name="T_A_fun" class="form-control" value="<?php echo $T_A_fun; ?>">
                            <span class="help-block"><?php echo $T_A_fun_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($T_A_price_err)) ? 'has-error' : ''; ?>">
                            <label>Цена</label>
                            <input type="text" name="T_A_price" class="form-control" value="<?php echo $T_A_price ?>">
                            <span class="help-block"><?php echo $T_A_price_err; ?></span>
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