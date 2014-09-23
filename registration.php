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
            $hr = header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH) );
            var_dump($hr);  
        }
        else {
            $_SESSION['register_result'] = $arResult['message'];
        }
}

require(ROOT_PROJECT_PATH . '/design/registration.php');
if(isset($arResult)) {
    $class = $arResult['result'] ? "login-success-message" : "login-error-message";
 ?><p class="<?=$class ?>"><?= $_SESSION['register_result'];?></p> 

<?php
}

require( ROOT_PROJECT_PATH . '/design/footer.php');
?>


