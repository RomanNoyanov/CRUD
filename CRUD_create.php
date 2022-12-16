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
$T_Gaz_Name = $T_Gaz_Proizvod = $T_Gaz_size = $T_Gaz_Color = $T_Gaz_Fun = $T_Gaz_Kol_vo_Komf = $T_Gaz_Tip = $T_Gaz_prise = "";
$T_Gaz_Name_err = $T_Gaz_Proizvod_err = $T_Gaz_size_err = $T_Gaz_Color_err = $T_Gaz_Fun_err = $T_Gaz_Kol_vo_Komf_err = $T_Gaz_Tip_err = $T_Gaz_prise_err = "";

// Processing form data when form is submitted
// (обрабатываем запрос после нажатия отправки пользователем) 
// Validate first_name (проверяем фамилию)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_T_Gaz_Name = trim($_POST["T_Gaz_Name"]);
    if (empty($input_T_Gaz_Name)) {
        $T_Gaz_Name_err = "Please enter a name.";
    } elseif (!filter_var($input_T_Gaz_Name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9\s]+$/")))) {
        $T_Gaz_Name_err = "Please enter a valid name.";
    } else {
        $T_Gaz_Name = $input_T_Gaz_Name;
    }

    // Validate  _Gaz_Proizvod  
    $input_T_Gaz_Proizvod = trim($_POST["T_Gaz_Proizvod"]);
    if (empty($input_T_Gaz_Proizvod)) {
        $T_Gaz_Proizvod_err = "Please enter a T_Gaz_Proizvod";
    /* } elseif (!filter_var($input_T_Gaz_Proizvod, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_Proizvod_err = "Please enter a valid T_Gaz_Proizvod"; */
    } else {
        $T_Gaz_Proizvod = $input_T_Gaz_Proizvod;
    }

    // Validate Size (проверяем отчество)
    $input_T_Gaz_size = trim($_POST["T_Gaz_size"]);
    if (empty($input_T_Gaz_size)) {
        $T_Gaz_size_err = "Please enter a Size.";
    /* } elseif (!filter_var($input_T_Gaz_size, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_size_err = "Please enter a valid Size"; */
    } else {
        $T_Gaz_size = $input_T_Gaz_size;
    }

    // Validate address (проверяем адрес)
    $input_T_Gaz_Color = trim($_POST["T_Gaz_Color"]);
    if (empty($input_T_Gaz_Color)) {
        $T_Gaz_Color_err = "Please enter an color.";
    /* } elseif (!filter_var($input_T_Gaz_Color, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_Color_err = "Please enter a valid color."; */
    } else {
        $T_Gaz_Color = $input_T_Gaz_Color;
    }


    // Validate  fun
    $input_T_Gaz_Fun = trim($_POST["T_Gaz_Fun"]);
    if (empty($input_T_Gaz_Fun)) {
        $T_Gaz_Fun_err = "Please enter an fun.";
    } else {
        $T_Gaz_Fun = $input_T_Gaz_Fun;
    }


    $input_T_Gaz_Kol_vo_Komf = trim($_POST["T_Gaz_Kol_vo_Komf"]);
    if (empty($input_T_Gaz_Kol_vo_Komf)) {
        $T_Gaz_Kol_vo_Komf_err = "Please enter a _Kol_vo_Komf.";
    /* } elseif (!filter_var($input_T_Gaz_Kol_vo_Komf, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_Kol_vo_Komf_err = "Please enter a valid T_Gaz_Kol_vo_Komf."; */
    } else {
        $T_Gaz_Kol_vo_Komf = $input_T_Gaz_Kol_vo_Komf;
    }


    $input_T_Gaz_Tip = trim($_POST["T_Gaz_Tip"]);
    if (empty($input_T_Gaz_Tip)) {
        $T_Gaz_Tip_err = "Please repeat a T_Gaz_Tip.";
    /* } elseif (!filter_var($input_T_Gaz_Tip, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_Tip_err = "Please enter a valid T_Gaz_Tip."; */
    } else {
        $T_Gaz_Tip = $input_T_Gaz_Tip;
    }

    $input_T_Gaz_prise = trim($_POST["T_Gaz_prise"]);
    if (empty($input_T_Gaz_prise)) {
        $T_Gaz_prise_err = "Please enter a prise.";
    } elseif (!filter_var($input_T_Gaz_prise, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
        $T_Gaz_prise_err = "Please enter a valid prise.";
    } else {
        $T_Gaz_prise = $input_T_Gaz_prise;
    }

    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)



    //echo " ошибка до 146"."<br/>";
    // echo  $T_Gaz_Name."=  ". $T_Gaz_Proizvod ."=   ".$T_Gaz_size. "=   ".$T_Gaz_Color . "=   ".$T_Gaz_Fun. "=     ".$T_Gaz_Kol_vo_Komf. "=    ".$T_Gaz_Tip ."=  ".$T_Gaz_prise."=";
    // Check input errors before inserting in database
    // (если исходные данные введены, добавляем запись в БД)
    if (empty($T_Gaz_Name_err) &&  empty($T_Gaz_Fun_err) &&  empty($T_Gaz_prise_err)) {
        $s = "SELECT T_Gaz_Name FROM Gaz_Plit WHERE T_Gaz_Name ='$T_Gaz_Name'";
        echo $s;
        $Ares = mysqli_query($link, $s);
        /*  $count= mysqli_num_rows($Gres);
         echo $count; */

        $Acount = $Ares->affected_rows;
        echo "<br/>" . $T_Gaz_Name;
        //echo "<br/>".(isset($link) ?"1":"0");
        echo "<br/>" . $Ares->num_rows;
        if ($Ares->num_rows >= 1) {
            /*   if ($count>= 1) { */

            $name_if = "Такое название уже существует";
            echo $name_if;
        } else {
            //echo " ошибка до 151";

            // Prepare an insert statement (подготавливаем запрос: символы ? для подстановки параметров)
            $sql = "INSERT INTO Gaz_Plit (T_Gaz_Name,T_Gaz_Proizvod,T_Gaz_size,T_Gaz_Color,T_Gaz_Fun,T_Gaz_Kol_vo_Komf,T_Gaz_Tip,T_Gaz_prise) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        }
        if ($stmt = mysqli_prepare($link, $sql)) {
            echo "<br/>" . $sql . "</br>";
            // Bind variables to the prepared statement as parameters
            // (связываем паременные в условии запроса: s - строка, i - целое число)
            mysqli_stmt_bind_param($stmt, "siiissis", $param_T_Gaz_Name, $param_T_Gaz_Proizvod, $param_T_Gaz_size, $param_T_Gaz_Color, $param_T_Gaz_Fun, $param_T_Gaz_Kol_vo_Komf, $param_T_Gaz_Tip, $param_T_Gaz_prise);
            // Set parameters (запоминаем параметры)
            // echo $stmt;
            //  echo " ошибка 165";
            $param_T_Gaz_Name = $T_Gaz_Name;
            $param_T_Gaz_Proizvod = $T_Gaz_Proizvod;
            $param_T_Gaz_size = $T_Gaz_size;
            $param_T_Gaz_Color = $T_Gaz_Color;
            $param_T_Gaz_Fun = $T_Gaz_Fun;
            $param_T_Gaz_Kol_vo_Komf = $T_Gaz_Kol_vo_Komf;
            $param_T_Gaz_Tip = $T_Gaz_Tip;
            $param_T_Gaz_prise = $T_Gaz_prise;

            echo "<br/>" . "param_T_Gaz_Name=" . $param_T_Gaz_Name . "<br/>" . "param_T_Gaz_Proizvod=" . $param_T_Gaz_Proizvod . "<br/>" . "param_T_Gaz_size=" . $param_T_Gaz_size . "<br/>" . "param_T_Gaz_Color=" . $param_T_Gaz_Color . "<br/>" . "param_T_Gaz_Fun=" . $param_T_Gaz_Fun . "<br/>" . "param_T_Gaz_Kol_vo_Komf=" . $param_T_Gaz_Kol_vo_Komf . "<br/>" . "param_T_Gaz_Tip=" . $param_T_Gaz_Tip . "<br/>" . "param_T_Gaz_prise=" . $param_T_Gaz_prise . "<br/>";
            /* ------------------------------------------------------------------------------------- */

            // Attempt to execute the prepared statement (пытаемся выполнить запрос)
            if (mysqli_stmt_execute($stmt)) {
                // данные записаны, переходим на страницу login.php
                header("location: login.php");
                exit();
            } else {
                echo "(mysqli_stmt_gxecute) Плита  не добавлена|||";
            }
        } else {
            echo "Пользователь не зарегистрирован запрос не выполнен!!((<br/>";
            $thread_id = mysqli_thread_id($link);
            echo "thread_id=" . $thread_id . "<br/>";
        }
        // Close statement (закрываем условие запроса)
        mysqli_stmt_close($stmt);
    }

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
                        <div class="form-group <?php echo (!empty($T_Gaz_Name_err)) ? 'has-error' : ''; ?>">
                            <label>Название</label>
                            <input type="text" name="T_Gaz_Name" class="form-control" value="<?php echo $T_Gaz_Name; ?>">

                            <span class="help-block"><?php echo $T_Gaz_Name_err; ?></span>
                            <span class="help-block" style="color: red;"><?php echo $name_if; ?></span>

                        </div>
                        <!-- ------------------------------------ -->
                        <div class="form-group">
                            <label>Производитель</label>
                            <?php
                            $sql1 = "SELECT * FROM Brand_V_Plit";
                            $result_brand = mysqli_query($link, $sql1);
                            echo "<select class='form-control' name='T_Gaz_Proizvod'><option selected >Выбор Бренда</option>";

                            while ($row_brand = mysqli_fetch_array($result_brand)) {
                                echo '<option value="'.$row_brand['Brand_id'].'">'. $row_brand['Brand_name'].'</option>';
                            }
                            ?>
                            </select>

                        </div>
                        <!-- --------------------------------------- -->
                        <div class="form-group ">
                            <label>Размер</label>
                            <?php
                            $sql2 = "SELECT * FROM Razmer";
                            $result_size = mysqli_query($link, $sql2);
                            echo "<select class='form-control' name='T_Gaz_size'><option selected >Выбор размера</option>";
                            while ($row_size = mysqli_fetch_array($result_size)) {
                                echo '<option value="'.$row_size['Razmer_id'].'">'.$row_size['RazmerCM'] . '</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <!-- ------------------------------- -->
                        <div class="form-group ">
                            <label>Цвет</label>
                            <?php
                            $sql3 = "SELECT * FROM Color";
                            $result_color = mysqli_query($link, $sql3);
                            echo "<select class='form-control' name='T_Gaz_Color'><option selected >Выбор цвета </option>";
                            while ($row_color = mysqli_fetch_array($result_color)) {
                                echo '<option value="'.$row_color['Color_id'].'">'.$row_color['Color_name'].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <!-- ---------------------------------- -->
                        <div class="form-group <?php echo (!empty($T_Gaz_Fun_err)) ? 'has-error' : ''; ?>">
                            <label>Информация</label>
                            <input type="text" name="T_Gaz_Fun" class="form-control" value="<?php echo $T_Gaz_Fun; ?>">
                            <span class="help-block"><?php echo $T_Gaz_Fun_err; ?></span>
                        </div>

                        <!-- ------------------------------------------- -->
                        <div class="form-group">
                            <label>Кол-во комфорк</label>
                            <?php
                            $sql4 = "SELECT * FROM Kol_Vo_Komforok";
                            $result_KK = mysqli_query($link, $sql4);
                            echo "<select class='form-control' name='T_Gaz_Kol_vo_Komf'><option selected >Выбор количества комфорк </option>";

                            while ($row_KK = mysqli_fetch_array($result_KK)) {
                                echo '<option value="'.$row_KK['Komfork_id'].'">'.$row_KK['Komfork_name'].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                        <!-- -------------------------------- -->
                        <div class="form-group">
                            <label>Класс электросбережения</label>
                            <?php
                            $sql5 = "SELECT * FROM Tip_Podzig";
                            $result_klass = mysqli_query($link, $sql5);
                            echo "<select class='form-control' name='T_Gaz_Tip'><option selected >Выбор класса электросбережения  </option>";
                            while ($row_klass = mysqli_fetch_array($result_klass)) {
                                echo '<option value="'.$row_klass['Tip_id'].'">'.$row_klass['Tip_name'].'</option>';
                            }
                            ?>
                            </select>
                            <!-- -------------------------------------- -->
                        </div>
                        <div class="form-group <?php echo (!empty($T_Gaz_prise_err)) ? 'has-error' : ''; ?>">
                            <label>Цена</label>
                            <input type="text" name="T_Gaz_prise" class="form-control" value="<?php echo $T_Gaz_prise; ?>">
                            <span class="help-block"><?php echo $T_Gaz_prise_err; ?></span>
                        </div>
                        <!-- ------------------------------------- -->
                        <input type="submit" class="btn btn-primary" value="Добавить">
                        <a href="login.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>