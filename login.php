<?php
require('include.php');

if( 
    isset($_POST['login']) && 
    isset($_POST['password']) 
)
{
    $result = $auth->login($_POST['login'], $_POST['password']);
    if( $result !== false ){
        echo "SUCCES";
        return;
    }
} 
echo "FAIL";
return;
