<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
if( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repeat']))
    { 
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $age = isset($_POST['age']) ? $_POST['age'] : null;
    $avatar = isset($_POST['avatar']) ? $_POST['avatar'] : null;
    
   
    $arResult = $auth->register($_POST['login'], $_POST['password'], $_POST['repeat'],
        $name, $age, $avatar);
        
        if ($arResult['result']) {
            $_SESSION['register_result'] = $arResult['message'];
            header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH) );
            echo 444;          
        }
        else {
            $_SESSION['register_result'] = $arResult['message'];
        }
}

?>
<h1>Регистрация</h1>
<form method="POST" action="registration.php" >
<p>Логин<input type="text" name="login" /></p>
<p>Пароль <input type="password" name="password" /></p>
<p>Повторить пароль<input type="password" name="repeat" /></p>    
<p>Имя<input type="text" name="name" /></p>
<p>Возраст<input type="text" name="age" /></p>
<input type="submit"  name="submit" value="Зарегистрироваться" />
</form>

<?php
if(isset($arResult)) {
    $class = $arResult['result'] ? "login-success-message" : "login-error-message";
 ?><p class="<?=$class ?>"><?= $_SESSION['register_result'];?></p> 

<?php
}

require( ROOT_PROJECT_PATH . '/design/footer.php');
?>


