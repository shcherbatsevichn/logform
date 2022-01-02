<?php 
    session_start();
    if(!$_SESSION['user']){               //если пользователь НЕ овтаризован - не позволяем ему гулять по этой странице, перекидываем на форму авторизации 
        header('Location: /index.php');
    }
    $title = "Личный кабинет";
    $script = "blocks/ajax_logoff.js";
    require_once "blocks/head.php";
?>
    
    <div class="block">
        <div class="container">
            <h1>Добро пожаловать, <?=$_SESSION['user'];?></h1>
            <h2>Функционал пользователя отсутствует :( Вы можете покинуть кабинет...</h2>
            <form action="" method="post">
                <button type="submit" id='logoffbtn' class="greenbtn">Выход</button>
            </form>         
        </div>

    </div>

</body>
</html>