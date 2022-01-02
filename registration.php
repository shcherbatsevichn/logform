<?php 
  session_start();
  if($_SESSION['user']){ //если пользователь авторизован - не позволяем ему гулять по этой странице
    header('Location: /userinterface.php');
    exit;
  }
  $title = "Регистрация";
  $script = "blocks/ajax_reg.js";
  require "blocks/head.php";
?>
 
      <div class="block">    
        <div class="form">
          <h1>Регистрация</h1>
          <p>Пожалуйста, введите ваши данные для регистрации:</p>
          <hr>
          <form method="post" id="ajax_form" action="">
            <label for="login"><b>Логин</b></label>
            <input type="text" placeholder="Введите login" name="login" >
        
            <label for="psw"><b>Пароль</b></label>
            <input type="password" placeholder="Введите пароль" name="psw" >
        
            <label for="psw-repeat"><b>Повторите пароль</b></label>
            <input type="password" placeholder="Повторите пароль" name="psw-repeat" >
            
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Введите Email" name="email" >

            <label for="name"><b>Имя</b></label>
            <input type="text" placeholder="Введите Имя" name="username" >
        
            <button type="button" class="greenbtn" id="regbtn">Зарегистрироваться</button>
            <hr>

            <button type="button" class="redbtn" onclick="document.location='index.php'">Назад</button>            
          </form>
        </div>  
        <div class ="resultformreg">
          <div id="result_form_login" class="resultformoutput1">

          </div>
          <div id="result_form_psw" class="resultformoutput">

          </div>
          <div id="result_form_pswrp" class="resultformoutput">

          </div>
          <div id="result_form_email" class="resultformoutput">

          </div>
          <div id="result_form_name" class="resultformoutput">

          </div>
        </div>
      </div> 

</body>
</html>