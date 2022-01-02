<?php
session_start();     
require "chek.php";
require "complajax.php";
require "dbcore.php";






if (isset($_POST["login"]) && isset($_POST["password"])) //код не будет выполняться, если перешли по прямому url
{
    $info = $_POST;                                         //забираем данные из массива запроса $_post     
    $info["password"] = md5($info["password"]);             //кодируем пароль для сравнения с базой данных(в базе пароли храняться в закрытом виде)
    $content = new DBcore('../db/db.json', $info);          //создаем объект класса для работы с бд
    $logreq = $content->searchsignin('login', 'password');   //используем функцию для поиска и сравнения по базе, функция возвращает массив, в котором 1-е значение - имя юзера, второе - результат сравнения логина (true или false), третье - результат сравнения пароля в буле
    $error = ["errorlog" => "ок",
     "errorpsw" => "Неверный пароль",  //не логично писать на пароле ок, если логин не правильный)
        'error' => 1];
    if($logreq[1] && $logreq[2]){       //если логин и пароль совали с записю в базе 
                $error = [
                'error' => 0];
                $_SESSION['user'] = $logreq[0];  //записываем в сессию имя пользователя
        }

    if($logreq[1] == false){            //если совпадений по логину не найдено
        $error['errorlog'] ='Такого логина не существует';
    }
    echo json_encode($error); //кодируем и отправляем json ответ
}
 


    



