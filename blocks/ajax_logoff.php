<?php
    session_start();
    unset($_SESSION['user']);  //удаляем сессию
    echo json_encode(['error' => 0]); //отправляем json-ответ в обработчик js, для выполнения дальнейших команд 