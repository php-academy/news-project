<?php
require('include.php');

if( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repeat']) ){
    $name   = isset($_POST['name']) ? $_POST['name'] : null;
    $age    = isset($_POST['age']) ? intval($_POST['age']) : null;
    $avatar = (isset($_FILES['avatar']) && $_FILES['avatar']['size']) ? $_FILES['avatar'] : null ; 
    
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
<form enctype="multipart/form-data" method="POST" action="registration.php" >
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
    <p>
        Возраст: <input type="submit" name="register" value="Зарегистрировать" />    
    </p>
    <p>
        Аватар: <input type="file" name="avatar" />  
    </p>
</form>

<?php
if( isset($arResult) ) {
    $class = $arResult['result'] ? 'login-success-message' : 'login-error-message' ;
    ?><p class="<?=$class?>"><?=$arResult['message']?></p><?php
}
?>
    <p><a href="<?php echo PROJECT_PATH ?>/">на главную</a></p>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');