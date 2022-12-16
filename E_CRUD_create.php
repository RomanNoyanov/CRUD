<?php
session_start(); // начинаем новую сессию

// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];

// Include config file (подключаем файлы)
//require_once "login_role.php";

include('./login_config.php');

$thread_id = mysqli_thread_id($link);



// пытаемся добавить данные //////////////////////////////////

// Define variables and initialize with empty values
// (определяем и очищаем переменные)
$T_E_Name = $T_E_Proizvod = $T_E_size = $T_E_Color = $T_E_Fun = $T_E_Kol_vo_Komf = $T_E_Klass = $T_E_prise = "";
$T_E_Name_err = $T_E_Proizvod_err = $T_E_size_err = $T_E_Color_err = $T_E_Fun_err = $T_E_Kol_vo_Komf_err = $T_E_Klass_err = $T_E_prise_err = "";
// Processing form data when form is submitted
// (обрабатываем запрос после нажатия отправки пользователем) 
// Validate first_name (проверяем имя)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$input_T_E_Name = trim($_POST["T_E_Name"]);
if (empty($input_T_E_Name)) {
    $T_E_Name_err = "Please enter a name.";
} elseif (!filter_var($input_T_E_Name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z0-9\s]+$/")))) {
    $T_E_Name_err = "Please enter a valid name.";
} else {
    $T_E_Name = $input_T_E_Name;
}

// Validate  _E_Proizvod  
$input_T_E_Proizvod = trim($_POST["T_E_Proizvod"]);
if (empty($input_T_E_Proizvod)) {
    $T_E_Proizvod_err = "Please enter a T_E_Proizvod";
/* } elseif (!filter_var($input_T_E_Proizvod, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_Proizvod_err = "Please enter a valid T_E_Proizvod"; */
} else {
    $T_E_Proizvod = $input_T_E_Proizvod;
}

// Validate Size (проверяем отчество)
$input_T_E_size = trim($_POST["T_E_size"]);
if (empty($input_T_E_size)) {
    $T_E_size_err = "Please enter a Size.";
/* } elseif (!filter_var($input_T_E_size, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_size_err = "Please enter a valid Size"; */
} else {
    $T_E_size = $input_T_E_size;
}

// Validate address (проверяем адрес)
$input_T_E_Color = trim($_POST["T_E_Color"]);
if (empty($input_T_E_Color)) {
    $T_E_Color_err = "Please enter an color.";
/* } elseif (!filter_var($input_T_E_Color, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_Color_err = "Please enter a valid color."; */
} else {
    $T_E_Color = $input_T_E_Color;
}


// Validate  fun
$input_T_E_Fun = trim($_POST["T_E_Fun"]);
if (empty($input_T_E_Fun)) {
    $T_E_Fun_err = "Введите описание";
} else {
    $T_E_Fun = $input_T_E_Fun;
}


$input_T_E_Kol_vo_Komf = trim($_POST["T_E_Kol_vo_Komf"]);
if (empty($input_T_E_Kol_vo_Komf)) {
    $T_E_Kol_vo_Komf_err = "Выберете количество .";
/* } elseif (!filter_var($input_T_E_Kol_vo_Komf, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_Kol_vo_Komf_err = "Что-то пошло не так"; */
} else {
    $T_E_Kol_vo_Komf = $input_T_E_Kol_vo_Komf;
}


$input_T_E_Klass = trim($_POST["T_E_Klass"]);
if (empty($input_T_E_Klass)) {
    $T_E_Klass_err = "Выберете класс энергосбережения";
/* } elseif (!filter_var($input_T_E_Klass, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_Klass_err = "Что-то пошо не так" */;
} else {
    $T_E_Klass = $input_T_E_Klass;
}

$input_T_E_prise = trim($_POST["T_E_prise"]);
if (empty($input_T_E_prise)) {
    $T_E_prise_err = "Введите цену";
} elseif (!filter_var($input_T_E_prise, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]+$/")))) {
    $T_E_prise_err = "Введите цену коректно";
} else {
    $T_E_prise = $input_T_E_prise;
}

// Check input errors before inserting in database
// (если исходные данные введены, добавляем запись в БД)



//echo " ошибка до 146"."<br/>";
// echo  $T_E_Name."=  ". $T_E_Proizvod ."=   ".$T_E_size. "=   ".$T_E_Color . "=   ".$T_E_Fun. "=     ".$T_E_Kol_vo_Komf. "=    ".$T_E_Klass ."=  ".$T_E_prise."=";
// Check input errors before inserting in database
// (если исходные данные введены, добавляем запись в БД)
if (empty($T_E_Name_err) && empty($T_E_Fun_err)  && empty($T_E_prise_err)) {
    $s="SELECT T_E_Name FROM E_Plit WHERE T_E_Name ='$T_E_Name'";
    echo $s;
    $Ares = mysqli_query($link,$s );     
    /*  $count= mysqli_num_rows($Gres);
     echo $count; */

    $Acount = $Ares->affected_rows;
    echo "<br/>" . $T_E_Name;
  //echo "<br/>".(isset($link) ?"1":"0");
  echo "<br/>" . $Ares->num_rows;
    if ($Ares->num_rows >= 1) {
      /*   if ($count>= 1) { */

        $name_if = "Такое название уже существует";
        echo $name_if;
    }
    else{

    // Prepare an insert statement (подготавливаем запрос: символы ? для подстановки параметров)
    $sql = "INSERT INTO E_Plit (T_E_Name, T_E_Proizvod, T_E_size, T_E_Color, T_E_Fun, T_E_Kol_vo_Komf, T_E_Klass, T_E_prise) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    }
    if ($stmt = mysqli_prepare($link, $sql)) {
        echo $sql . "</br>";
        // Bind variables to the prepared statement as parameters
        // (связываем паременные в условии запроса: s - строка, i - целое число)
        mysqli_stmt_bind_param($stmt, "siiisiis", $param_T_E_Name, $param_T_E_Proizvod, $param_T_E_size, $param_T_E_Color, $param_T_E_Fun, $param_T_E_Kol_vo_Komf, $param_T_E_Klass, $param_T_E_prise);
        // Set parameters (запоминаем параметры)

        $param_T_E_Name = $T_E_Name;
        $param_T_E_Proizvod = $T_E_Proizvod;
        $param_T_E_size = $T_E_size;
        $param_T_E_Color = $T_E_Color;
        $param_T_E_Fun = $T_E_Fun;
        $param_T_E_Kol_vo_Komf = $T_E_Kol_vo_Komf;
        $param_T_E_Klass = $T_E_Klass;
        $param_T_E_prise = $T_E_prise;

        echo "<br/>" . "param_T_E_Name=" . $param_T_E_Name . "<br/>" . "param_T_E_Proizvod=" . $param_T_E_Proizvod . "<br/>" . "param_T_E_size=" . $param_T_E_size . "<br/>" . "param_T_E_Color=" . $param_T_E_Color . "<br/>" . "param_T_E_Fun=" . $param_T_E_Fun . "<br/>" . "param_T_E_Kol_vo_Komf=" . $param_T_E_Kol_vo_Komf . "<br/>" . "param_T_E_Klass=" . $param_T_E_Klass . "<br/>" . "param_T_E_prise=" . $param_T_E_prise . "<br/>";


        /* ------------------------------------------------------------------------------------- */

        // Attempt to execute the prepared statement (пытаемся выполнить запрос)
        if (mysqli_stmt_execute($stmt)) {
            // данные записаны, переходим на страницу login_welcome.php
            header("location: login.php");
            exit();
        } else {
            echo "Плита  не добавлена";
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


}?>

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
                        <div class="form-group <?php echo (!empty($T_E_Name_err)) ? 'has-error' : ''; ?>">
                            <label>Название</label>
                            <input type="text" name="T_E_Name" class="form-control" value="<?php echo $T_E_Name; ?>">

                            <span class="help-block"><?php echo $T_E_Name_err; ?></span>
                            <span class="help-block" style="color: red;"><?php echo $name_if; ?></span>

                        </div>
                        <!-- ------------------------------------ -->
                        <div class="form-group">
                            <label>Производитель</label>
                            <?php
                            $sql1="SELECT * FROM Brand_V_Plit";
                            $result_brand = mysqli_query($link,$sql1);
                            echo "<select class='form-control' name='T_E_Proizvod'><option selected >Выбор Бренда</option>";

                            while($row_brand = mysqli_fetch_array($result_brand)){
                            echo '<option value="'.$row_brand['Brand_id'].'">'.$row_brand['Brand_name']. '</option>';                   
                            }
                            ?>
                            </select>
                        </div>
                        <!-- --------------------------------------- -->
                        <div class="form-group ">
                            <label>Размер</label>
                            <?php
                            $sql2="SELECT * FROM Razmer";
                            $result_size = mysqli_query($link,$sql2);
                            echo "<select class='form-control' name='T_E_size'><option selected >Выбор размера</option>";

                            while($row_size = mysqli_fetch_array($result_size)){
                            echo '<option value="'.$row_size['Razmer_id'].'">'.$row_size['RazmerCM'].'</option>';                   
                            }
                            ?>
                            </select>
                        </div>
                        <!-- ------------------------------- -->
                        <div class="form-group ">
                            <label>Цвет</label>
                                    <?php
                                    $sql3="SELECT * FROM Color";
                            $result_color = mysqli_query($link,$sql3);
                            echo "<select class='form-control' name='T_E_Color'><option selected >Выбор цвета </option>";

                            while($row_color = mysqli_fetch_array($result_color)){
                            echo '<option value="'.$row_color['Color_id'].'">'.$row_color['Color_name']. '</option>';                   
                            }
                            ?>
                            </select>
                        </div>
                        <!-- ---------------------------------- -->
                        <div class="form-group <?php echo (!empty($T_E_Fun_err)) ? 'has-error' : ''; ?>">
                            <label>Информация</label>
                            <input type="text" name="T_E_Fun" class="form-control" value="<?php echo $T_E_Fun; ?>">
                            <span class="help-block"><?php echo $T_E_Fun_err; ?></span>
                        </div>
                        
                        <!-- ------------------------------------------- -->
                        <div class="form-group">
                            <label>Кол-во комфорк</label>
                            <?php
                            $sql4="SELECT * FROM Kol_Vo_Komforok";
                            $result_KK = mysqli_query($link,$sql4);
                            echo "<select class='form-control' name='T_E_Kol_vo_Komf'><option selected >Выбор количества комфорк </option>";

                            while($row_KK = mysqli_fetch_array($result_KK)){
                            echo '<option value="'.$row_KK['Komfork_id'].'">' . $row_KK['Komfork_name']. '</option>';                   
                            }
                            ?>
                            </select>
                        </div>
                        <!-- -------------------------------- -->
                        <div class="form-group">
                            <label>Класс электросбережения</label>
                            <?php
                            $sql5="SELECT * FROM EKlass";
                            $result_klass = mysqli_query($link,$sql5);
                            echo "<select class='form-control' name='T_E_Klass'><option selected >Выбор класса электросбережения  </option>";
                            while($row_klass = mysqli_fetch_array($result_klass)){
                            echo '<option value="'.$row_klass['EKlass_id'].'">' . $row_klass['EKlass_name']. '</option>';                   
                            }
                            ?>
                        </select>
                        <!-- -------------------------------------- -->
                        </div>
                        <div class="form-group <?php echo (!empty($T_E_prise_err)) ? 'has-error' : ''; ?>">
                            <label>Цена</label>
                            <input type="text" name="T_E_prise" class="form-control" value="<?php echo $T_E_prise; ?>">
                            <span class="help-block"><?php echo $T_E_prise_err; ?></span>
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