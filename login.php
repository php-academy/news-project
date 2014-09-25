<?php
require('include.php');
$rememberMe = (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') ? true : false;
$login = isset($_POST['login']) ? $_POST['login']  : '';
$password = isset($_POST['password']) ? $_POST['password']   : '';


$result = $auth->login($login, $password, $rememberMe);

echo json_encode($result); 
