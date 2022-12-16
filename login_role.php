<?php
function setrole_by_username($username, $link)
{
    //include_once "login_config.php";
    $ferror = ""; // очищаем переменную ошибок
    $role_id = ""; // очищаем переменную роли
    $sql = "SELECT role_id FROM DB_USERS WHERE username = '".$username."'";
$thread_id = mysqli_thread_id($link);
if(empty($thread_id)) // коннектим к БД, если не было установлено соединение
    {
        include('./login_config.php');
        echo "login_role.php: вызван файл login_config.php!!";
    }
    else
    {
        echo "login_role.php: соединение с БД было установлено thread_id=".$thread_id;
    }

    if($frows = mysqli_query($link, $sql))
    {
        //echo "login_role.php: query executed!!!";
        if( $frow = mysqli_fetch_row($frows))
        {
            //echo "login_role.php: found row!!!";
            $role_id = $frow[0];
            if($role_id === "0") // 1 - гость
            {
                if(empty(mysqli_fetch_row($frows)))
                {   // запоминаем в текущей сессии имя роли
                    $_SESSION["role_name"] = "guest";
                }
                else
                {
                    $ferror = "Ошибка чтения роли: считано более 1й строки!";
                }
            }
            else if($role_id === "1") // 1 -админ 
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "admin";
            }
            
            else if($role_id === "2") // 2 -new_user 
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "new_user";
            }
            else if($role_id === "3") // 3 -active_user 
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "active_user";
            }
            else if($role_id === "4") // 4-passive_user 
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "passive_user";
            }
            else if($role_id === "5") // 5 -moderator 
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "moderator";
            }
            else
            {// запоминаем в текущей сессии имя роли
                $_SESSION["role_name"] = "guest";
            }
            //echo "role_id=".$role_id;
            // запоминаем в текущей сессии идентификатор роли
            $_SESSION["role_id"] = $role_id;
            mysqli_free_result($frows); // очищаем результаты запроса
        }
        else
        {
            $ferror = "Ошибка чтения роли: считано 0 строк!(";
        }
    }
    else
    {
        $ferror =  "Ошибка чтения роли: запрос не выполнен!(".$sql;   
    }
    mysqli_close($link); // закрываем запрос
    return $ferror; // возвращаем ошибку, если произошла 
}
?>
