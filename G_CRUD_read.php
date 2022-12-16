<?php
// Check existence of id parameter before processing further
session_start(); // начинаем новую сессию

// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];

// Include config file (подключаем файлы)
// Include config file
require_once "login_config.php";
$input_id = trim($_POST["id"]);
if (empty($input_id)) {
    $id_err = "Please enter an id.";
} else {
    $id = $input_id;
}
echo "20";
if (isset($_POST['q'])) {
    $Table = $_POST['q'];
} else {
    $Table_err = "Выбери таблицу";
}
echo $Table;
if ((empty($id_err))) {

   // echo "26";
    /* ------------------------------Газовые плиты---------------------- */
    if ($Table == "Gaz_Plit") {
        $Gres=mysqli_query($link,"SELECT id FROM Gaz_Plit WHERE id=$id");       // $count= mysqli_num_rows($Gres);
        $Gcount= $Gres->affected_rows;
              
         if($Gres->num_rows=='0')
         {
            $ROW_PLITA="Газовых плит с таким id нет";  
         }
         else
         {  
        //echo "29_Gaz_Plit";
        require_once "login_config.php";
        $sql = "SELECT 
					   Gaz_Plit.T_Gaz_Name, 
                       Brand_V_Plit.Brand_name, 
                       Razmer.RazmerCM, 
                       Color.Color_name, 
                       Gaz_Plit.T_Gaz_Fun, 
                       Kol_Vo_Komforok.Komfork_name, 
                       Tip_Podzig.Tip_name,
                       Gaz_Plit.T_Gaz_prise
                       
                FROM   881_23.Gaz_Plit, 881_23.Brand_V_Plit, 881_23.Razmer, 881_23.Color, 881_23.Kol_Vo_Komforok, 881_23.Tip_Podzig  
                
                WHERE  Gaz_Plit.T_Gaz_Proizvod = Brand_V_Plit.Brand_id 
                        AND Gaz_Plit.T_Gaz_size = Razmer.Razmer_id 
                        AND Gaz_Plit.T_Gaz_Color = Color.Color_id 
                        AND Gaz_Plit.T_Gaz_Kol_vo_Komf = Kol_Vo_Komforok.Komfork_id 
                        AND Gaz_Plit.T_Gaz_Tip = Tip_Podzig.Tip_id 
                        AND Gaz_Plit.id = $id";
        //
         }//echo $sql;
        if ($stmt = mysqli_prepare($link, $sql)) {
            
            //echo "44_Gaz_Plit";
            //echo $sql;


            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = trim($_GET["id"]);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $L1 = "Название";
                    $L2 = "Производитель";
                    $L3 = "Размер";
                    $L4 = "Цвет";
                    $L5 = "Описание";
                    $L6 = "Количество комфорк";
                    $L7 = "Тип";
                    $L8 = "Цена";

                    // Retrieve individual field value
                    $ROW_Name = $T_Gaz_Name = $row["T_Gaz_Name"];
                    $ROW_Proiz = $T_Gaz_Proizvod = $row["Brand_name"];
                    $ROW_Razmer = $T_Gaz_size = $row["RazmerCM"];
                    $ROW_Color = $T_Gaz_Color = $row["Color_name"];
                    $ROW_Fun = $T_Gaz_Fun = $row["T_Gaz_Fun"];
                    $ROW_Kol_vo_Komf = $T_Gaz_Kol_vo_Komf = $row["Komfork_name"];
                    $ROW_Tip = $T_Gaz_Tip = $row["Tip_name"];
                    $ROW_prise = $T_Gaz_prise = $row["T_Gaz_prise"];
                    $ROW_PLITA = "Газовая плита";
                } else {
                    // URL doesn't contain valid id parameter. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);

}

        /* --------------------электричесчие -------------- */ 
        elseif ($Table == "E_Plit") {
            $Gres=mysqli_query($link,"SELECT id FROM E_Plit WHERE id=$id");       // $count= mysqli_num_rows($Gres);
$Gcount= $Gres->affected_rows;
      
 if($Gres->num_rows=='0')
 {
    $ROW_PLITA="Электрических плит с таким id нет ";  
 }
 else
 {      
            require_once "login_config.php";
            $sql = "SELECT 
					   E_Plit.T_E_Name, 
                       Brand_V_Plit.Brand_name, 
                       Razmer.RazmerCM, 
                       Color.Color_name, 
                       E_Plit.T_E_Fun, 
                       Kol_Vo_Komforok.Komfork_name, 
                       EKlass.EKlass_name,
                       E_Plit.T_E_prise
                       
                FROM   881_23.E_Plit, 881_23.Brand_V_Plit, 881_23.Razmer, 881_23.Color, 881_23.Kol_Vo_Komforok, 881_23.EKlass  
                
                WHERE  E_Plit.T_E_Proizvod = Brand_V_Plit.Brand_id 
                        AND E_Plit.T_E_size = Razmer.Razmer_id 
                        AND E_Plit.T_E_Color = Color.Color_id 
                        AND E_Plit.T_E_Kol_vo_Komf = Kol_Vo_Komforok.Komfork_id 
                        AND E_Plit.T_E_Klass = EKlass.EKlass_id 
                        AND E_Plit.id = $id";
 }
            if ($stmt = mysqli_prepare($link, $sql)) 
            {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_id);

                // Set parameters
                $param_id = trim($_GET["id"]);


                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) == 1) {
                        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        $L1 = "Название";
                        $L2 = "Производитель";
                        $L3 = "Размер";
                        $L4 = "Цвет";
                        $L5 = "Описание";
                        $L6 = "Количество комфорк";
                        $L7 = "Класс";
                        $L8 = "Цена";


                        $ROW_Name = $T_E_Name = $row["T_E_Name"];
                        $ROW_Proiz = $T_E_Proizvod = $row["Brand_name"];
                        $ROW_Razmer = $T_E_size = $row["RazmerCM"];
                        $ROW_Color = $T_E_Color = $row["Color_name"];
                        $ROW_Fun = $T_E_Fun = $row["T_E_Fun"];
                        $ROW_Kol_vo_Komf = $T_E_Kol_vo_Komf = $row["Komfork_name"];
                        $ROW_Tip = $T_E_Klass = $row["EKlass_name"];
                        $ROW_prise = $T_E_prise = $row["T_E_prise"];
                        $ROW_PLITA = "Электрическая плита";
                    }
                 else {
                    // URL doesn't contain valid id parameter. Redirect to error page
                    //header("location: error.php");
                    echo "Error 127 str";
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
     }
    /* -----------------Аксессуары---------------------  */ 
    elseif ($Table == "Accessories") {
        $Gres=mysqli_query($link,"SELECT id FROM Accessories WHERE id=$id");       // $count= mysqli_num_rows($Gres);
        $Gcount= $Gres->affected_rows;
              
         if($Gres->num_rows=='0')
         {
            $ROW_PLITA="Аксессуаров с таким id нет";  
         }
         else
         {   
        require_once "login_config.php";
        $sql = "SELECT Accessories.T_A_name, 
        Tip_Plit.Tip_Plit_name, 
        Accessories.T_A_fun, 
        Accessories.T_A_price
        
		FROM   Tip_Plit,Accessories 
		WHERE  Accessories.T_A_tip = Tip_Plit.Tip_Plit_id   AND Accessories.id = $id";
         }
        if ($stmt = mysqli_prepare($link, $sql)) {
            echo "157";
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = trim($_GET["id"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $L1 = "Название";
                    $L2 = "Тип";
                    $L3 = "Описание";
                    $L4 = "Цена";
                    $L5 = " ";
                    $L6 = " ";
                    $L7 = " ";
                    $L8 = " ";

                    echo  "<br/>" . "Вошел Accessories";
                    $ROW_Name = $T_A_Name = $row["T_A_name"];
                    $ROW_Proiz = $T_A_tip = $row["Tip_Plit_name"];
                    $ROW_Razmer = $T_A_fun = $row["T_A_fun"];
                    $ROW_Color = $T_A_price = $row["T_A_price"];

                    $ROW_PLITA = "Аксессуары";
                } else {
                    // URL doesn't contain valid id parameter. Redirect to error page
                    //header("location: error.php");
                    echo "Error 208 str";
                    exit();
                }
                /* ----------------------------------- */
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
                        <h1>View Record</h1>
                    </div>
                    <label>Что вы ищите?</label>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div data-toggle="buttons" class="btn-group btn-group-toggle btn-primary form-group <?php echo (!empty($Table_err)) ? 'has-error' : ''; ?>">

                            <label class="btn btn-secondary ">
                                <input type="radio" name="q" data-toggle="button" aria-pressed="true" value="Gaz_Plit" id="option1" autocomplete="off" /> Газовые плиты
                            </label>

                            <label class="btn btn-secondary">
                                <input type="radio" name="q" data-toggle="button" aria-pressed="false" value="E_Plit" id="option2" autocomplete="off" /> Электрические плиты
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="q" data-toggle="button" aria-pressed="false" value="Accessories" id="option3" autocomplete="off" /> Аксессуары
                            </label>


                            <span class="help-block"><?php echo $Table_err; ?></span>

                        </div>

                        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                            <label>Введите Id товара</label>
                            <input name="id" class="form-control" value="<?php echo $id; ?>">
                            <span class="help-block"><?php echo $id_err; ?></span>
                            <div>
                                <hr />
                            </div>
                            <input type="submit" class="btn btn-primary" value="Найти">
                        </div>
                    </form>
                    <div class="form-group">
                        <label></label>
                        <h2 class="form-control-static"><?php echo $ROW_PLITA; ?></h2>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L1; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Name; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L2; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Proiz; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L3; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Razmer; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L4; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Color; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L5; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Fun; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L6; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Kol_vo_Komf; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L7; ?></label>
                        <p class="form-control-static"><?php echo $ROW_Tip; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <div class="form-group">
                        <label><?php echo $L8; ?></label>
                        <p class="form-control-static"><?php echo $ROW_prise; ?></p>
                    </div>
                    <div>
                        <hr />
                    </div>
                    <p><a href="login.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>