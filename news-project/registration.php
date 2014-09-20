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
}
require(ROOT_PROJECT_PATH . '/design/header.php');
?>
<h1>Регистрация</h1>
<form method="POST" action="registration.php" >
    <p>
        Логин*: <input type="text" name="login" />
    </p>
    <p>
        Пароль*: <input type="password" name="password" />
    </p>
    <p>
        Еще раз*: <input type="password" name="repeat" />
    </p>
    <p>
        Имя: <input type="text" name="name" />
    </p>
    <p>
       Возраст: <input type="text" name="age" />    
    </p>
    <input type="submit" name="register" value="Зарегистрировать" />    
</form>

<?php
if( isset($arResult)) {
    $class = $arResult['result'] ? 'success_message' : 'error_message';
    ?><p class="<?=$class?>"><?=$arResult['message']?></p><?php
}
?>
    <p><a href="<?php echo PROJECT_PATH ?>/">На главную</a></p><?php
require( ROOT_PROJECT_PATH . '/design/footer.php');