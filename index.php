<?php 
  session_start();
  if($_SESSION['user']){  //если пользователь авторизован - не позволяем ему гулять по этой странице
    header('Location: /userinterface.php');
    exit;
  }
  $title = "Главная страница";
  $script = "blocks/ajax_login.js";
  require_once "blocks/head.php";
?>
      <div class="block">
        <div class="form">
          <h1>Авторизация</h1>
          <p>Введите ваши данные для авторизации:</p>
          <hr>
           <form action="" method="post" id="ajax_form_log" class="formlogin">
            <label for="login"><b>Логин</b></label>
            <input type="text" placeholder="Введите логин" name="login">
          
            <label for="psw"><b>Пароль</b></label>
            <input type="password" placeholder="Введите Пароль" name="password">
                
              
            <button type="button" class="greenbtn" id="logbtn" >Войти</button>
            <hr>
          </form>
          <p>Нет аккаунта? Пройдите процедуру регистрации:</p>
          <button type="submit" class="redbtn" onclick="document.location='registration.php'">Зарегистрироваться</button>
            
        </div>
        <div class="resultformreg">
          <div id="result_form_log" class="resultform">
          </div>
          <div id="result_form_psw" class="resultformoutput">
          </div>
        </div>
      </div>
    
   


</body>
</html>