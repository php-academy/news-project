<?php
require('include.php');

if( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repeat']) ){
    $name   = isset($_POST['name']) ? $_POST['name'] : null;
    $age    = isset($_POST['age']) ? intval($_POST['age']) : null;
    $avatar = isset($_POST['avatar']) ? $_POST['avatar'] : null;
    
    /**
     * array(
     *      'result' => true | false,
     *      'message'  => "Вы успешно зареганы" | "Сообщение об ошибке"
     * );
     */
    $arResult = $auth->register(
        $_POST['login'], 
        $_POST['password'], 
        $_POST['repeat'],
        $name,
        $age,
        $avatar
    );
    if( $arResult['result'] ){
        $_SESSION['register_result'] = $arResult['message'];
        header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );
    } else {
        $_SESSION['register_result'] = $arResult['message'];
    }
}
?>
<h1>Регистрация</h1>
<form method="POST" action="registration.php" >
    <p>
        * Логин: <input type="text" name="login" />
    </p>
    <p>
        * Пароль: <input type="password" name="password" />
    </p>
    <p>
        * Еще раз: <input type="password" name="repeat" />
    </p>
    <p>
        Имя: <input type="text" name="name" />
    </p>
    <p>
       Возраст: <input type="text" name="age" />    
    </p>
</form>

<?php
if( isset($_SESSION['register_result'])  && !empty($_SESSION['register_result']) ){
    ?><p class="login-error-message"><?=$_SESSION['register_result']?></p><?php
}