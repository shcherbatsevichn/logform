<?php

require "chek.php";
require "complajax.php";
require "dbcore.php";

$ajaxrq = new AJAX($_POST["login"], $_POST["psw"], $_POST["psw-repeat"], $_POST["email"], $_POST["username"]);



if (isset($_POST["login"]) && isset($_POST["psw"]) && isset($_POST["psw-repeat"]) && isset($_POST["email"]) && isset($_POST["username"])) //код не будет выполняться, если перешли по прямому url
{
    $info = $ajaxrq->getarray();  //получаем массив с результатами проверки на валидность 
    $root = $_SERVER['DOCUMENT_ROOT'];
    $content = new DBcore($root."/db/db.json", $info);  //создаём объект для работы с базой данных 
    $flagerror = 2;
    $errorrq = array();
    if(($content->information["error"]) == 0){ // если все данные были валидны
        if($content->search("login") == false){  //проверяем на уникальность 
            $flagerror --;
        }
        else{                                                                 //если не уникален, заменяем сообщение о невалидности на сообщение о неуникальности 
            $error = ["errorlog" => "Данный login уже занят"];
            $errorrq += $error;
        }
        if($content->search("email") == false){             //тоже самое с email
            $flagerror --;
        }
        else{
            $error = [ "erroremail" => "Пользователь с данным email уже зарегистрирован"];
                $errorrq += $error;
        }
        if($flagerror == 0){        //если email и login уникальны, производим запись в базу данных(данные точно валидны, флаг "error" == 0 нам об этом говорит) 
            $content->fileupdate();
        }
        else{                           //если не уникально, модифицируем json-ответ данными о неуникальности строк
            $error = ['error' => 1];
            $errorrq += $error;
            $info = $errorrq;
        }
    }
    echo json_encode($info); //кодируем и отправляем json-ответ
}

    



