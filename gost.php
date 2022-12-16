session_start();
<!DOCTYPE html>
<html lang="ru">
 
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <link rel="stylesheet" href="gost.css" />
</head>

<body>
    <!--0000000000000000000000000000000000000-->
    <header>
        <div class="verh">
            <div class></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>

            <div class="butt">
                <div class="vhod"><input type="button" class="btn btn-primary" onclick="window.location.href='login.php'" value='Вход'></div>
                <div></div>
            
            </div>
        </div>
    </header>
    <!----------->
    
        <div class=line>
            <hr width=100% />
        </div>
        <!----------->


<div> - </div>
    <div class="cards">
        
     <?php
     header('Content-Type: text/html; charset=utf-8');
    // Include config file (подключаем файл)
                  require_once "login_config.php";
      //              if (!mysqli_set_charset($conn, "utf8")) {
 //   printf("\n Ошибка в кодировке utf8: %s\n", mysqli_error($conn));
 //   exit();
//}
                    if(isset($_POST['click'])&&!empty($_POST['click']))
                    {   // перенаправляем на создание записи
                        header("location:CRUD_create.php");
                    }
        $sql = "SELECT * FROM Gaz_Plit";
        if($result = mysqli_query($link, $sql))
        {   // если запрос выполнен, заполняем таблицу!!
        if(mysqli_num_rows($result) > 0)
        {
            echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>Название плиты</th>";
                      
                        echo "<th>Цена</th>";
                        
                    echo "</tr>";
                echo "</thead>";
            echo "<tbody>";
            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                    echo "<td>" . $row['T_Gaz_Name'] . "</td>";
                  
                    echo "<td>" . $row['T_Gaz_prise'] . "</td>";
                  echo "</tr>";
            }
            echo "</tbody>";                            
            echo "</table>";
        }


        else
        {
            echo "<p class='lead'><em>Ошибка! Записи не найдены!</em></p>";
        }
    }
    else
        {
        echo "Ошибка! Не выполнен запрос: " .$sql. " " .mysqli_error($link);
        }
    // Close connection (закрываем соединение с базой данных)
    mysqli_close($link);
    ?>
    </div>
    <footer>
        
        <hr width="80%" style="color: #FFFFFF;" />
        
    </footer>
</body>
</html>
