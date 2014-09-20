<?php
require('include.php');
if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["repeat"]) 
        && isset($_POST["name"]) && isset($_POST["age"]) ){
    
    
    $reg=$auth->registr();
    
    if ($reg){
        
        $_SESSION["registr_result"]=$arResult["message"];
         header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );
    }
}

if(isset($_SESSION["registr_result"])){
    
    echo $_SESSION["registr_result"];
}


?>

<form method="POST" action="registration.php">
    <label>Логин
    <input type="text" name="login"/><label>
    <label>Пароль
      <input type="password" name="password"/><label>   
          <label>Повторите пароль
      <input type="password" name="repeat"/><label>  
          <label>Имя
    <input type="text" name="name"/><label>
        <label>Возраст
    <input type="text" name="age"/><label>
    
</form>
