<?php
require('include.php');
if($auth->logout()) {
    $responce = array ( 'result' =>  true);
}
else {
    $responce = array ( 'result' =>  false);
}
echo json_encode($responce);
