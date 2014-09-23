<?php
require('include.php');
$rememberMe = (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') ? true : false;
$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password'])  ? $_POST['password'] : '';

$result = $auth->login($login,  $password, $rememberMe);
echo json_encode($result);



/* old - require('include.php');

if( 
    isset($_POST['login']) && 
    isset($_POST['password']) 
)
{
    $auth->login($_POST['login'], $_POST['password']);
    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );
} else {
    header('Location: ' . PROJECT_PATH );
}*/
