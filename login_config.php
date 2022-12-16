<?php
header('Content-Type: text/html; charset=utf-8');
// Define constants (определяем константы)
define('DB_SERVER', 'sutct.org');
define('DB_USERNAME', '881_23');
define('DB_PASSWORD', '7ZsTB3?KUJfg');
define('DB_NAME', '881_23');
 

$thread_id = mysqli_thread_id($link);
if(empty($thread_id)) // коннектим к БД, если не было установлено соединение
{
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $thread_id = mysqli_thread_id($link);
     if (!mysqli_set_charset($link, "utf8")) {
    printf("<br/>Ошибка в кодировке utf8: %s<br/>", mysqli_error($link));
    exit();
     }
    echo "Выполнено соединение с БД". "<br>"."Номер соединения=".$thread_id;
}
else
{
    echo "Соединение с БД уже было установлено". "<br>"."Номер соединения=".$thread_id. "<br>" ;
    
}

if(empty($thread_id)) // проверяем соединение
{
    die("login_config.php:Ошибка: не удается установить коннект с БД!" . mysqli_connect_error());
}


?>