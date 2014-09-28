<?php
require('include.php');
if ($auth->logout()){
    $response = array(
        'result' => true,
    );
} else {
    $response = array(
        'result' => false,
    );
}

echo json_encode($response);

//header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );

