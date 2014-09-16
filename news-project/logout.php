<?php

require ('include.php');
unset($_SESSION['userId']);
setcookie('news_project_user', '', time()-100);
header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );

