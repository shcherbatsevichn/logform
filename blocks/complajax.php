<?php

class AJAX extends Check{
    public function __construct($checklog, $checkpsw, $checkrppsw, $checkemail, $checkname){
        parent::__construct($checklog, $checkpsw, $checkrppsw, $checkemail, $checkname);
    }

    //----------формируем ответ на основе проверок валидности данных

    public function getarray(){

        $counter =5;
        $errorm =['errorlog' => 'ok',
            'errorpsw' =>'ok',
            'errormpsw' =>'ok',
            'erroremail' =>'ok',
            'errorname' =>'ok',
            'error' =>1
                    ];
        if(parent::checklog() == false){
            $errorm['errorlog'] = "Логин должен иметь более 6 символов, нельзя использовать пробелы!";    
            $counter --;     
        }  
        if(parent::checkpsw() == false){
            $errorm['errorpsw'] = "Пароль должен состоять минмимум 6 символов, содержать буквы и цифры "; 
            $counter --;          
        }  
        if(parent::checkmpsw() == false){
            $errorm['errormpsw'] = "Пароли не совподают";
            $counter --;
                    
        }  
        if(parent::checkemail() == false){
            $errorm['erroremail'] = "Указан не правильный email";
            $counter --;
                      
        } 
        if(parent::checkname() == false){
            $errorm['errorname'] = "Имя должно содержать минимум 2 и максимум 20 символов, в имени должны содержаться только буквы"; 
            $counter --;        
        }  
        if($counter == 5){      //все данные валидны, возвращаем их в виде ассоциативного массива
            $result = [
                "login" => $this->login,
                "password" => md5($this->psw),
                "email" => $this->email,
                "name" => $this->name,
                "error" => 0
                        ];
            return $result;
        }
        else{  
            $result = $errorm;
            return $result;
        }
    }

}