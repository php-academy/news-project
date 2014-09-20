<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');

if(isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["repeat"]) 
        && isset($_POST["name"]) && isset($_POST["age"]) ){
    
    
    $reg=$auth->registr();
    
    if ($reg){
        
        $_SESSION["registr_result"]=$arResult["message"];
         header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );
        unset($_SESSION["registr_result"]);
    }
}

if(isset($_SESSION["registr_result"])){
    
    echo $_SESSION["registr_result"];
}


?>

<form method="POST" action="registration.php">
    <p><label>Логин
    <input type="text" name="login"/><label></p>
     <p><label>Пароль
      <input type="password" name="password"/><label></p>   
           <p><label>Повторите пароль
      <input type="password" name="repeat"/><label><p>  
           <p><label>Имя
    <input type="text" name="name"/><label></p>
         <p><label>Возраст
    <input type="text" name="age"/><label><p>
         <p><input type="submit" value="Ok"></p>
    
</form>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');