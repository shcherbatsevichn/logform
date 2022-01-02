<?php
//--------------Класс для проверок на валидность
class Check{

    public $login;      //логин
    public $psw;        //пароль
    public $rppsw;      //проверочный пароль
    public $email;      //email    
    public $name;       //Имя пользователя

    public function __construct($checklog, $checkpsw, $checkrppsw, $checkemail, $checkname)  //конструктор класса 
    {
        $this->login = $checklog;
        $this->psw = $checkpsw;
        $this->rppsw = $checkrppsw;
        $this->email = $checkemail;
        $this->name = $checkname;
    }
//--------------функция для проверки на наличие пробелов
    protected function checkspase($string){         
        $counter = 2;
        if(strripos($string, ' ')){         //проверяет на наличие пробелов в середине и конце строки (первый символ пропускается)
            $counter --;
        }
        if(strripos(strrev($string), ' ')){ //проверяет на наличие пробела в начале строки (инвертируем строку и прогоняем ту же функцию)
            $counter --;
        }
        if($counter == 2){              //принятие решения на валидность
            return true;
        }
        else{
            return false;
        }
    }
//--------------функция для условия содержания в строке минимум одной буквы и минимум одной цифры 
    protected function check_litter_number($str){
        $strm = str_split($str);    //загоняем строку в массив
        $flaglitter = 0;            //количество букв
        $flagnumber = 0;            //количество цифр
        for($c=0; $c <count($strm); $c++){              //проходимся по каждому элементу массива
          if(preg_match("/^[a-zа-яё]$/i", $strm[$c])){  //если этот элемент - буква
            $flaglitter ++;                               //считаем букву
            
          }
          if(preg_match("/^[0-9]/", $strm[$c])){        //если этот элемент - цифра
            $flagnumber ++;                                 //считаем цифру
                }      
          if($flagnumber >= 1 && $flaglitter >= 1){          //если массив содержит хотя бы одну цифру и хотя бы одну букву
            return true;                                    //считаем значение валидным
            exit;
          }
        }
        if($flagnumber < 1 || $flaglitter < 1){
          return false;
          exit;
        }
      }
//--------------функция для проверки логинов
    public function checklog(){     
        $counter = 0;
        if(strlen(trim($this->login)) >= 6){ //проверка на длину строки
            $counter ++;
        }
        if(strripos($this->login, '>')){
            $counter --;
        }
        if($this->checkspase($this->login)){ //проверка на пробелы
            $counter ++;
        }
       if($counter == 2){   //принятие решения на валидность
            return true; 
        }
        else{
            return false;
        }
        
    }
//--------------функция для проверки паролей
    public function checkpsw(){
        $counter = 0;
        if(strlen(trim($this->psw)) >= 6){  //проверка на длину строки
            $counter ++;
        }
        if($this->checkspase($this->psw)){ //проверка на пробелы
            $counter ++;
        }      
        if(preg_match("/^[a-zа-яё0-9\d]{1}[a-zа-яё0-9\d]*[a-zа-яё0-9\d]{1}$/i", $this->psw)){   //пароль должен содержать только буквы и цифры
            $counter ++;
        }
        if($this->check_litter_number($this->psw)){         //проверяет на наличие в строке хотябы одной буквы и цифры
            $counter ++;
        }
        if($counter == 4){    //принятие решения на валидность
            return true;
        }
        else{
            return false;
        }
    }
//--------------функция для проверки совпадения паролей
    public function checkmpsw(){
        if($this->psw == $this->rppsw){
            return true;
        }
        else{
            return false;
        }
    }
//--------------функция для проверки email
    public function checkemail(){
        $counter = 0;
        if(preg_match("/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/", $this->email)){   //проверяем на валидность email
            $counter ++;
        }
        if($this->checkspase($this->psw)){ //проверяем на содержание пробелов
            $counter ++;
        }         
        if($counter == 2){      //принятие решения о валидности
            return true;
        }
        else{
            return false;
        }
    }
//--------------функция для проверки имени
    public function checkname(){
        $counter = 0;
        if(strlen(trim($this->name)) > 2 && strlen(trim($this->name)) < 21 ){         //проверяем на длину строки
            $counter ++;
        }
        if(preg_match("/^[a-zа-яё]{1}[a-zа-яё\s]*[a-zа-яё]{1}$/i", $this->name)){   //проверяем на наличие только букв
            $counter ++;
        }
       
        if($counter == 2){  //принятие решения о валидности
            return true;
        }
        else{
            return false;
        }
    }  
}