<?php
require 'include.php';
$auth->logout();
header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH)  );