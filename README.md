# CRUD 

Разработка Back-end и Front-end части справочной системы «Крупная бытовая техника». Подсистема «Электрические и газовые плиты» заключается в том, что: 

•	Для большинства браузеров не было найдено удобных в использовании и одновременно бесплатных инструментов, которые позволяют выполнять различные действия CRUD в справочных системах с зависимости от роли пользователя в системе;

•	Пользователю удобнее использовать специализированное программное обеспечение, в том числе, при поиске и выборе крупной бытовой техники;

•	Пользователю может быть предоставлен удобный интерфейс для добавления/чтения/обновления/удаления данных о газовых, электрических плитах и аксессуаров к ним в зависимости от роли (администратор, модератор, зарегистрированный пользователь, гость) и задач (добавление нового товара, изменение и удаление старого товара, поиск по названию); например, нужно быстро найти все имеющиеся газовые плиты по заданным характеристикам.

Практическая значимость дипломной работы заключается в том, что у пользователя появляется возможность использования создаваемого справочника с целью удобного просмотра товаров. 
Например, к характеристикам газовых плит относятся: наименование, производитель, размер, цвет, особенности, количество газовых конфорок, наличие (тип) электроподжига и цена; для просмотра всех перечисленных выше характеристик пользователь может воспользоваться данным справочником. 
Удобство использования справочника с точки зрения модератора и администратора проявляется в простоте управления этими и другими данными. 
Цель работы: Разработка подсистемы «Электрические и газовые плиты» в Back-end и Front-end частях справочной системы «Крупная бытовая техника». 
Необходимо спроектировать и разработать web-приложение для выполнения задач CRUD (Create, Read, Update, Delete): создания, чтения, обновления и удаления данных во Frontend-части при обращении к Backend-части проекта «Крупная бытовая техника». 

Для достижения указанной цели должны быть решены следующие задачи:

•	Спроектировать компоненты программного проекта, представить их в виде UML-диаграмм;

•	Определить необходимые таблицы с исходными данными о газовых плитах, электрических плитах, аксессуарах, а также таблицу с данными о пользователях web-приложения, и представить их в нормализованном виде; 

•	Разработать web-приложение для выполнения функций CRUD в соответствии с построенными UML-диаграммами;

•	Провести тестирование разработанного web-приложения;

•	Выполнить оценку ресурсов, затраченных на разработку всего программного проекта. 
**Построение типовой UML-диаграммы состояний участников и компонентов программной системы**

Составим диаграмму состояний для участников (Гость, Пользователь, Модератор, Адми-нистратор) и компонентов проектируемой программной обеспечения (Web-приложение, интерфейс пользователя, интерфейс разработчика, база данных).

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/e7b6424c-968d-4e7b-9505-bb7fbf194723)

На диаграмме состояний программной системы реализован последовательный переход из одного состояния в другое, а также имеется возможность проверки или повторения состояния. Последовательность переходов состояния выглядит следующим образом:

•	«Запуск приложения» (начальное состояние от имени гостя).

•	«Регистрация»: в данном состоянии web-приложение ожидает заполнение всех полей формы «Регистрация», затем обращается к БД для добавления пользователя. При успешном добавлении данных активизируется возможность перехода в состояние «Авторизация».

o	При добавлении данных с ошибкой форма переходит в состояние «Обработка ошибки при вводе данных», после чего форма перезагружается, а приложение переходит обратно в состояние «Регистрация».

•	«Авторизация»: при инициализации данного состояния пользователь является Гостем, во время выполнения – происходит проверка логин-пароля пользователя:

o	0 – доступ пользователя;

o	1 – доступ модератора;

o	2 – доступ администратора.

•	 «Готовность»: в данном состоянии web-приложение (сайт) подключается с соответствующей базе данных, загружает ее и ожидает запрос (CRUD), а затем сайт переходит в состояние «Обработка запросов».

•	«Обработка запросов»: в данном состоянии web-приложение получает запросы от Администратора, Модератора, Пользователя и Гостя, выполняет их, после чего отключается от базы данных и переходит в состояние «Выход из приложения». 

•	 «Выход из приложения» (завершение).


**Построение диаграммы прецедентов**

Составим диаграмму прецедентов для участников (Гость, Зарегистрированный пользователь, Администратор и Модератор), котрая отображает различные роли в web-приложении.

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/c86bc3d3-cc93-4574-8da0-1e4017e21ffd)

Как видно из диаграммы прецедентов на Рисунке 8, в проектируемом web-приложении должно быть 4 роли. Пользователя, Модератора и Администратора можно увидеть в разделе создания и заполнения таблицы пользователей: там есть эти три роли. А роль Гостя здесь встречается впервые, т.к. в базе данных она отсутствует. 

•	Гость – под гостем может зайти человек, не имеющий аккаунта на сайте. Ему будет доступно ограниченное количество информации, а именно: перечень товаров из каждого раздела и цен на них.

•	Пользователь – Гость становится Пользователем, пройдя регистрацию. Ему видна вся информация о каждом товаре, находящемся в Базе Данных.

•	Модератор – человек, который имеет больше прав, чем обычный пользователь, т.к. помимо чтения информации модератор может создавать новые записи или изменять уже имеющиеся в базе данные.

•	Администратор – человек, который имеет те же права, что и модератор, а также право удалять записи из Базы Данных.



**Создание базы данных и построение ER-диаграммы**


![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/be7775e5-0a56-43e2-a3af-eaa5ea4b9052)

**Вход на сайт**

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/2a028b19-f9da-4bbc-840b-b3c1da4782e1)


![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/4c750e44-fe5c-42c9-9954-172b43548c30)


![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/220511b8-a805-4ebd-9269-0347652fb160)


![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/3dc8019a-8161-4bde-bedb-df2c583315bb)


**Программная реализация базовой функции Create()**
```
<?php
session_start(); 
// начинаем новую сессию
// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];
$username = $_SESSION["username"];
$role_id = $_SESSION["role_id"];
$role_name = $_SESSION["role_name"];
// Include config file (подключаем файлы)
require_once "login_role.php";
include('./login_config.php');
header('Content-Type: text/html; charset=utf-8');
$thread_id = mysqli_thread_id($link);
// пытаемся добавить данные 
// (определяем и очищаем переменные)
$T_A_Name  =  $T_A_Fun = $T_A_Tip = $T_A_prise = $image = "";
$T_A_Name_err = $T_A_Fun_err  = $T_A_Tip_err = $T_A_prise_err = $image_err = "";
// (обрабатываем запрос после нажатия отправки пользователем)
if($_SERVER["REQUEST_METHOD"] == "POST")
{
//Проверяем введенное название
$input_T_A_Name = trim($_POST["T_A_Name"]);
if(empty($input_T_A_Name))
{
$T_A_Name_err = "Вы забыли написать название";
}
else
{
$T_A_Name = $input_T_A_Name;
}
// (проверяем)
$input_T_A_Fun = trim($_POST["T_A_Fun"]);
if(empty($input_T_A_Fun))
{
$T_A_Fun_err = "Вы забыли написать особенности плиты";
}
else
{
$T_A_Fun = $input_T_A_Fun;
}
//  T_A_Tip (проверяем)
$input_T_A_Tip = trim($_POST["T_A_Tip"]);
if($input_T_A_Tip == "")
{
$T_A_Tip_err = "Вы забыли выбрать тип";
}
else
{
$T_A_Tip = $input_T_A_Tip;
}
// Validate T_A_prise (проверяем цену)
$input_T_A_prise = trim($_POST["T_A_prise"]);
if(empty($input_T_A_prise))
{
$T_A_prise_err = "Вы забыли написать цену";
}
elseif(!filter_var($input_T_A_prise,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]+$/"))))
{
$T_A_prise_err = "Введите правильную цену";
}
else
{
$T_A_prise = $input_T_A_prise;
}
// Validate image (проверяем изображение)
$input_image = trim($_POST["image"]);
if(empty($input_image))
{
$image_err = "Вставьте ссылку на картинку";
}
else
{
$image = $input_image;
}
// (если исходные данные введены, добавляем запись в БД)
if(empty($T_A_Name_err))
{
$Gres=mysqli_query($link,"SELECT T_A_Name FROM Accessories WHERE T_A_Name='$T_A_Name'");       // $count= mysqli_num_rows($Gres);
$Gcount= $Gres->affected_rows;
if($Gres->num_rows == '0')
{
//echo "до подключения";
//  (подготавливаем запрос: символы ? для подстановки параметров)
$sql = "INSERT INTO Accessories (T_A_Name, T_A_Tip, T_A_Fun, T_A_price, image) VALUES (?, ?, ?, ?, ?)";
echo  $sql;
if($stmt = mysqli_prepare($link, $sql))
{echo "157";
// (связываем паременные в условии запроса: s - строка, i - целое число)
mysqli_stmt_bind_param($stmt, "sisss", $param_T_A_Name,$param_T_A_Tip, $param_T_A_Fun,  $param_T_A_prise, $param_image);
// Set parameters (запоминаем параметры)
$param_T_A_Name = $T_A_Name;
$param_T_A_Tip= $T_A_Tip;
$param_T_A_Fun = $T_A_Fun;
$param_T_A_prise= $T_A_prise;
$param_image = $image;
echo  $param_T_A_Name. $param_T_A_Tip.$param_T_A_Fun. $param_T_A_prise.$param_image;
//Пытаемся выполнить запрос
if(mysqli_stmt_execute($stmt))
{
// данные записаны, переходим на страницу login.php
header("location: login.php");
exit();
}
else
{
echo "CRUD_create_fridge.php: данные не записаны!! Попробуйте повторить попытку снова!!";
}
}
else
{
$thread_id = mysqli_thread_id($link);
}
}
else{
$user_err="Такая плита уже существует";
}
// Close statement (закрываем условие запроса)
mysqli_stmt_close($stmt);
}
// Close connection (закрываем соединение)
mysqli_close($link);
}
?>
При этом «обертка» страницы будет выглядеть следующим образом:
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Record</title>
<link rel='stylesheet' href='CSS_FOR_CREATE_AND_UPDATE.css'/>
</head>
<body>
<div class="container_tovar">
<div class="row">
<div class="col-md-offset-3 col-md-6">
<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<span class="heading">Добавление нового аксессуара для плии </span>
<p>Заполните данные и отправьте на добавление в базу данных!!</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="form-group <?php echo (!empty($T_A_Name_err)) ? 'has-error' : ''; ?>">
<label>Название</label>
<input type="text" name="T_A_Name" class="form-control" value="<?php echo $T_A_Name; ?>">
<span class="help-block"><?php echo $T_A_Name_err;?></span>
<span class="help-block"><?php echo $user_err;?></span>
</div>
<div class="form-group <?php echo (!empty($T_A_Tip_err)) ? 'has-error' : ''; ?>">
<label>Тип</label>
<select class="form-control" name="T_A_Tip">;
<option>Выберите тип</option>
<?php
$result_klass = mysqli_query($link,"SELECT * FROM Tip_Plit");
while($row_klass = mysqli_fetch_array($result_klass)){
echo '<option value="'.$row_klass['Tip_Plit_id'].'">' . $row_klass['Tip_Plit_name']. '</option>';
}
?>
</select>
</div>
<div class="form-group <?php echo (!empty($T_A_Fun_err)) ? 'has-error' : ''; ?>">
<label>Информация</label>
<input type="text" name="T_A_Fun" class="form-control" value="<?php echo $T_A_Fun; ?>">
<span class="help-block"><?php echo $T_A_Fun_err;?>
</span>
</div>
<div class="form-group <?php echo (!empty($T_A_prise_err)) ? 'has-error' : ''; ?>">
<label>Цена</label>
<input type="text" name="T_A_prise" class="form-control" value="<?php echo $T_A_prise; ?>">
<span class="help-block"><?php echo $T_A_prise_err;?>
</span>
</div>
<div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
<label>Ссылка на картинку</label>
<input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
<span class="help-block"><?php echo $image_err;?>
</span>
</div>
<input type="submit" class="btn btn-default btn-lg btn-block" value="Добавить">
<a href="Gallary_A_Plit.php" class="btn btn-default btn-lg btn-block">Назад</a>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
```

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/ddde8be5-4910-4c37-af0a-39daac4a8900)


![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/e91c6d08-37dc-4350-b435-7c73018fba61)


**Программная реализация базовой функции Read()**
```
<html> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
<?php
session_start();
 // начинаем новую сессию
// извлекаем переменные из сессии, если были установлены
$link = $_SESSION["link"];
$username = $_SESSION["username"];
$role_id = $_SESSION["role_id"];
$role_name = $_SESSION["role_name"];
echo $homepage;
$homepage = file_get_contents('Menu.html');
echo $homepage;
// Include config file (подключаем файлы)
header('Content-Type: text/html; charset=utf-8');
    // Include config file (подключаем файл)
                  require_once "login_config.php";
                               require_once "login_config.php";
        $sql = "SELECT 
                 	Accessories.id_A,
		Accessories.T_A_name, 
                       Tip_Plit.Tip_Plit_name, 
                      Accessories.T_A_fun, 
                      Accessories.image,
                      Accessories.T_A_price
                FROM   Accessories,Tip_Plit  
                WHERE  Accessories.T_A_tip = Tip_Plit.Tip_Plit_id";
    if($result = mysqli_query($link, $sql))
        {   
         // если запрос выполнен, заполняем таблицу!!
          if(mysqli_num_rows($result) > 0)
        { 
            echo "<head>";
            echo "<link rel='stylesheet' href='CSS_FOR_READ.css'/>";
echo"<linkrel='stylesheet' href='https://unpkg.com/flexboxgrid2@7.2.1/flexboxgrid2.min.css'/>";
            echo "</head>";
             echo "<div class='zag_razdela'>";
        echo "<h1> Аксессуары к плитам </h1>";
        echo "</div>";
 if (($role_id === "1") OR ($role_id === "2"))
{
                      echo "<button class ='btn btn-outline-success my-2 my-sm-0' type='button'><a href='Create_A_plit.php'>Добавить новую запись</a></button>";
}
        echo "<div class='CATEGORII'>";
            while($row = mysqli_fetch_array($result))
            {
                echo "<div class='col-sm-12 col-md-6 col-lg-6 '>";
                   echo "<div class='Tovar'>";
                   echo "<h3>".$row['T_A_name']."<h3>";
                 echo "<div class='Tovarin'>";
                  echo "<div class='Photo'>";
                    echo "<img src=".$row['image'].">";
                 echo "</div>"; 
                 echo "<div class='TextIN'>";
                    echo "<p>"."Описание: " . $row['T_A_fun'] . "</p>";
                    echo "<p>" ."Тип: ". $row['Tip_Plit_name'] . "</p>";
                        echo "<p>" ."Тип: ". $row['T_A_price'] ."₽". "</p>";
               echo "</div>"; 
               echo "</div>"; 
                  if (($role_id === "1") OR ($role_id === "2"))
{
                      echo "<button class ='btn btn-outline-success my-2 my-sm-0' type='button'><a href='update_A_plit.php?id_A=".$row['id_A']."' style=''>Изменить</a></button>";
                      if ($role_id === "2")
{
                      echo "<td><button class ='btn btn-outline-success my-2 my-sm-0' type='button' style='margin-left: 5px;'><a href='delete_A_plit.php?id_A=".$row['id_A']."&name_A=".$row['T_A_name']."'>Удалить</a></button></td>";
                       }
                    }
                 echo "</div>"; 
                  echo "</div>"; 
            }
            echo "</div>"; 
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
        echo "<hr>";
    // Close connection (закрываем соединение с базой данных)
    mysqli_close($link);
?>
```

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/dfe7b913-95c5-4a63-9908-f06b1559daa6)



![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/1d7a597f-7abe-48cd-aae9-1fa541bd5c49)


**Программная реализация базовой функции Update()**
```
<?php
session_start();
//конфигурационный файл
require_once "login_config.php";
$T_A_name = $T_A_tip = $T_A_fun = $T_A_price = $image = "";
$T_A_name_err = $T_A_tip_err = $T_A_fun_err  = $T_A_price_err = $image_err = "";
// Обработка данных формы при отправке формы
if(isset($_POST["id_A"]) && !empty($_POST["id_A"]))
{
    $id_A = $_POST["id_A"];
    //Проверяем введенное название
    $input_T_A_name = trim($_POST["T_A_name"]);
    if(empty($input_T_A_name))
    {
        $T_A_name_err = "Пожалуйста, введите название.";
    }
    else
    {
        $T_A_name = $input_T_A_name;
    }
    //Проверяем название бренда
    $input_T_A_tip = trim($_POST["T_A_tip"]);
    if($input_T_A_tip == "")
    {
        $T_A_tip_err = "Пожалуйста, выберите тип.";
    }
    else
    {
        $T_A_tip = $input_T_A_tip;
    }
    //Проверяем объем
    $input_T_A_fun = trim($_POST["T_A_fun"]);
    if(empty($input_T_A_fun))
    {
        $T_A_fun_err = "Пожалуйста, введите описание.";
    }
    else
    {
        $T_A_fun = $input_T_A_fun;
    }
    // проверяем цену
    $input_T_A_price = trim($_POST["T_A_price"]);
    if(empty($input_T_A_price))
    {
        $T_A_price_err = "Пожалуйста, введите цену";
    }
    elseif(!filter_var($input_T_A_price, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]+\.?[0-9]*$/"))))
    {
        $T_A_price_err = "Пожалйста, введите верную цену.";
    } 
    else
    {
        $T_A_price = $input_T_A_price;
    }
        // проверяем изображение
    $input_image = trim($_POST["image"]);
    if(empty($input_image))
    {
        $image_err = "Пожалуйста, введите ссылку.";
    }
    else
    {
        $image = $input_image;
    }
    // Проверяем ошибки ввода перед вставкой в базу данных
    if(empty($T_A_name_err) && empty($T_A_tip_err) && empty($T_A_fun_err)  && empty($T_A_price_err) && empty($image_err))
    {
        $sql = "UPDATE Accessories SET  T_A_name=?, T_A_tip=?, T_A_fun=?, T_A_price=?, image=? WHERE id_A=?";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Привязка переменных к подготовленному оператору в качестве параметров
// Set parameters (запоминаем параметры)
            $param_T_A_name = $T_A_name;
            $param_T_A_tip = $T_A_tip;
            $param_T_A_fun = $T_A_fun;
            $param_T_A_price= $T_A_price;
            $param_image = $image;
            mysqli_stmt_bind_param($stmt, "sisssi", $param_T_A_name, $param_T_A_tip, $param_T_A_fun, $param_T_A_price, $image, $id_A);
                // Попытка выполнить подготовленную инструкцию
            $result = mysqli_stmt_execute($stmt);
         var_dump(mysqli_query($stmt));
            var_dump(mysqli_stmt_error_list($stmt));
            if($result)
            {   
                // Записи успешно обновлены. Перенаправление на целевую страницу
                header("location: Gallary_A_Plit.php");
                exit();
            } 
            else
            {
                echo "Что-то пошло не так. Пожалуйста, повторите попытку позже.";
            }
        }
   }
    
} 
else
{
    if(isset($_GET["id_A"]) && !empty(trim($_GET["id_A"]))){
        $id_A =  trim($_GET["id_A"]);
       $sql = "SELECT * FROM Accessories WHERE id_A=?";
        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id_A;
            if(mysqli_stmt_execute($stmt))
            {
                $result = mysqli_stmt_GET_result($stmt);
               if(mysqli_num_rows($result) == 1)
                {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $T_A_name = $row["T_A_name"];
                    $T_A_tip = $row["T_A_tip"];
                    $T_A_fun = $row["T_A_fun"];
                    $T_A_price = $row["T_A_price"];
                    $image = $row["image"];
                } 
                else
                {
                    header("location: CRUD_error.php");
                    exit();
                }
                
            } 
            else
            {
                echo "Ошибка, попробуйте позже.";
            }
        }
        
        mysqli_stmt_close($stmt);
   }  
    else
    {
         echo "Ошибка доступа";
        exit();
    }
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
      <link rel='stylesheet' href='CSS_FOR_CREATE_AND_UPDATE.css'/>   
     <style type="text/css">
        body
        {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .form-horizontal{
            max-width: 800px;
            text-align: center;
        }    </style>
    </style>
</head>
<body>
    <div class="container_tovar">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <span class="heading">Редактирование аксессура</span>
                        <div class="form-group <?php echo (!empty($T_A_name_err)) ? 'has-error' : ''; ?>">
                            <label>Название</label>
                            <input type="text" name="T_A_name" class="form-control" value="<?php echo $T_A_name; ?>">
                            <span class="help-block"><?php echo $T_A_name_err;?></span>
                            <span class="help-block"><?php echo $user_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($T_A_tip_err)) ? 'has-error' : ''; ?>">
                            <label>Тип</label>
                            <select class="form-control" name="T_A_tip">;
                            <?php
                            $result_spisok = mysqli_query($link,"SELECT * FROM Tip_Plit");
                            while($row_brand = mysqli_fetch_array($result_spisok)){
                            echo '<option value="'.$row_brand['Tip_Plit_id'].'">' . $row_brand['Tip_Plit_name']. '</option>';                   
                            }
                            ?>
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($T_A_fun_err)) ? 'has-error' : ''; ?>">
                            <label>Информация</label>
                            <input type="text" name="T_A_fun" class="form-control" value="<?php echo $T_A_fun; ?>">
                            <span class="help-block"><?php echo $T_A_fun_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($T_A_price_err)) ? 'has-error' : ''; ?>">
                            <label>Цена</label>
                            <input type="text" name="T_A_price" class="form-control" value="<?php echo $T_A_price; ?>">
                            <span class="help-block"><?php echo $T_A_price_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Ссылка на картинку</label>
                     <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
                        </div>
                        <input type="hidden" name="id_A" value="<?php echo $id_A; ?>"/>
                        <input type="submit" class="btn btn-default btn-lg btn-block" value="Изменить">
                        <a href="Gallary_A_Plit.php" class="btn btn-default btn-lg btn-block">Назад</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
```

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/ad197ae6-27f2-4026-8055-10a5862e7099)


**Программная реализация базовой функции Delete()**
```
<?php
session_start();
$link = $_SESSION["link"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$role_id = $_SESSION["role_id"];
$role_name = $_SESSION["role_name"];
//Подключение файлов
require_once "login_role.php";
include('./login_config.php');
$thread_id = mysqli_thread_id($link);
// Проверка роли: 2 - админ
if ($role_id !== '2') // если не админ
{
    //Сохранение ошибки для отображения в файле CRUD_error.php
    $_SESSION["crud_error"] = "Недостаточно прав для удаления данных!!!";
    header("location: CRUD_error.php");
    exit;
}
//Удаление товара
$del_id_G = trim($_GET["id_G"]);
if (!empty($del_id_G)) 
{
    if ($_GET['confirm_del'] == 'Y') 
{
        //Подключение файла конфигурации
        require_once "login_config.php";
$name = "SELECT T_Gaz_Name FROM Gaz_Plit WHERE id_G = ?";
        //Подготавка запроса
        $sql = "DELETE FROM Gaz_Plit WHERE id_G = ?";
        if ($stmt = mysqli_prepare($link, $sql)) 
{
            //Привязка переменных к подготовленному запросу
            mysqli_stmt_bind_param($stmt, "s", $param_id_G);
            //Установка параметров
            $param_id_G= trim($del_id_G);
            //Попытка выполнить подготовленный statement
            if (mysqli_stmt_execute($stmt)) 
{
                //Запись успешно удалена. Перенаправление на страницу Gallary_Plit.php
                header("location: Gallary_Plit.php");
                exit();
            } else {
                echo "Что-то пошло не так. Пожалуйста, повторите попытку позже.";
            }
        }
        mysqli_stmt_close($stmt);
        //Закрытие соединения
        mysqli_close($link);
    }
} 
else 
{
    header("location: CRUD_error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Удаление записи</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    </head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                  <?php echo  "<h1>Удаление записи";
                    echo  "<h1>".$_GET["name_G"]."</h1>";?>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id_G" value="<?php echo trim($_GET["id_G"]); ?>"/>
                        <input type="hidden" name="confirm_del" value="Y"/>
                        <p>Вы уверены, что хотите удалить запись?</p><br>
                        <p>
                            <input type="submit" value="Да" class="btn btn-danger">
                            <a href="Gallary_Plit.php" class="btn btn-default">Нет</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
```

![image](https://github.com/RomanNoyanov/CRUD/assets/67968329/54f9e5a9-ffcd-4276-ade6-a60cf63b2d0c)






