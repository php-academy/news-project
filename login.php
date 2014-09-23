<?php
require('include.php');

if( 
    isset($_POST['login']) && 
    isset($_POST['password']) 
)
{
    $auth->login($_POST['login'], $_POST['password']);
    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );
    ob_end_flush(); 
} else {
    header('Location: ' . PROJECT_PATH );
}
