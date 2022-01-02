<?php

class DBcore{

    public $file;                                        //путь к файлу
    public $information;                                 //информация для обработки

    public function __construct($filename, $data)
    {
        $this->file = $filename;
        $this->information = $data;
    }


//------------чтение данных из файла-------------Возвращает содержимое файла 
protected function fileread($file){                         //принимает на фход путь к файлу 
    $db = fopen($file, 'r');                                           //открываем файл для чтения
    $content = json_decode(file_get_contents($file), true);;            //читаем, декодирукм из JSON в ассоциативный массив 
    fclose($db);                                                        //закрываем 
    return $content;
}
//------------запись данных в файл----------------          
protected function filewrite($file, $information){          //принимает на фход путь к файлу и информацию для записи 
    $dbw = fopen($file, 'w');                                           //открываем для записи
    fwrite($dbw,json_encode($information));                             //кодируем и записываем
    fclose($dbw);                                                       //закрываем
}
//------------создание базы данных-------------
public function createdatabase($file){                     //принимает на вход путь к файлу
    $content = $this->fileread($file);                                  //читаем данные из файла    
    if($content == null){                                               //если файл пуст, заполняем его конструкцией базы данных 
        $dbform = ["database" => []];                                   //конструкция для базы данных
        $this->filewrite($file, $dbform);                               //записываем конструкцию
    }
    else{
        echo "file be created before";                                  //условие для отладки 
    }
    
}
//------------вывод всей базы данных-------------функция для отладки
public function fileprint(){                                    
    $content = $this->fileread($this->file);                             //читаем данные из файла 
    if($content == null){                                                //проверяем, если пустой возвращаем сообщение
        echo "file is empty";
        exit;
    }
    else{                                                               //если полный, выводим массив через цикл
        for($i =0; $i < count($content["database"]); $i++){
            echo("<br>".$content["database"][$i]["login"]." --> ".$content["database"][$i]["password"]);
        }
    }
}
//------------Добавление пользователя в базу данных-------------
public function fileupdate(){
    $content = $this->fileread($this->file);                            //читаем данные из файла
    if($content == null){                                               //проверяем, если файл пустой, записываем в него форму (защита от багов записи)
        $this->createdatabase($this->file);
        $content = $this->fileread($this->file);                        //повторно читаем данные, уже с записанной формой
    }
    $content["database"][count($content["database"])] = $this->information;             //подготовка данных для записи, добавляем контент в прочитанную базу данных
    $this->filewrite($this->file, $content);                                            //записываем данные в файл
        
}
//------------удаление пользователя из базы данных-------------работает, но реализации в основном коде не имеет. удаление происходит по логину. можно допилить удаление подтвержения паролем.
public function deleteuser(){                      
    $content = $this->fileread($this->file);
    if($content == null){                                                                   //проверям, не пустая ли база данных
        echo "file is empty";
        exit;
    }
    else{                                                                                   //если в ней что-то есть
        $flagreload = 0;                                                                    //флаг удаленного элемента (0 - элемент не найден в базе, 1 - элемент найден и заменен пустым массивом) 
        for($i =0; $i < count($content["database"]); $i++){                                 //идем по массиву
            if($content["database"][$i]["login"] == $this->information["login"]){           //ноходжим соответствие     
                $content["database"][$i] = [];                                              //заменяем элемент на пустой массив
                $flagreload = 1;                                                            //поднимаем флаг
            }
        }
        $result = ["database" => []];                                                       //подготавливаем форму для базы данных  
        if($flagreload == 1){                                                               //если запись была удалена, перезаписываем массив 
            $ir = 0;                                                                        //необходима для фиксации индекса в записываемый элемент, при прохождении через удалённые данные(пустай массив)
            for($i = 0; $i < (count($content["database"])-1); $i++){             //перезапись массива элементов (-1 - т.к. у гас на 1 элемент в базе данных меньше. на один, т.к. удаление происходит по уникальному элементу, второй такой записть с помощью данного ядра не возможно)
                if($content["database"][$i] == []){                              //если натыкаемся на пустой массив $i - растёт, а $ir - нет. это позволяет зафиксировать позицию, что бы на это место записались следующие данные.
                    continue;                                                    //просто пропускаем итерацию
                }
                else{                                                             //записываем элемент
                    $result["database"][$ir] = $content["database"][$i];    
                    $ir++;
                }
            }
        }
        $this->filewrite($this->file, $result);                                  //заливаем данные в файл                         
    }    
}
//------------Поиск пользователя по данным-------------
public function search($item){                                          //принимает данные для поиска 
    $content = $this->fileread($this->file);                                
    if($content == null){
        return false;
        exit;
    }
    else{
        for($i =0; $i < count($content["database"]); $i++){                                //перебор масиива 
            if($content["database"][$i][$item] == $this->information["$item"]){                //поиск элемента        
                return true;
                exit;
                }
            }
            
        }     
        return false;                                         
    }    

//------------Ищет совподение логина и его пароля в базе с переданными логином и паролем-------------
public function searchsignin($log, $psw){                                          //принимает данные для поиска 
    $content = $this->fileread($this->file);                                
    if($content == null){
        return false;
        exit;
    }
    else{
        for($i =0; $i < count($content["database"]); $i++){                                //перебор масиива 
            if($content["database"][$i][$log] == $this->information["$log"]){                //поиск элемента
                if($content["database"][$i][$psw] == $this->information["$psw"]){           
                    return [$content["database"][$i]['name'], true, true];
                    exit;
                }
            return['uncknownname', true, false];
            }
            
        }     
        return false;                                         
    }    
}

}