<?php
ob_start();
define('PROJECT_PATH', '/news_project');
define('ROOT_PROJECT_PATH', $_SERVER['DOCUMENT_ROOT'] . PROJECT_PATH);
require(ROOT_PROJECT_PATH . '/src/init.php');
require(ROOT_PROJECT_PATH . '/src/functions.php');
require(ROOT_PROJECT_PATH . '/src/classes.php');
$news = require(ROOT_PROJECT_PATH . '/data/news.php');
//$users = require(ROOT_PROJECT_PATH . '/data/users.php'); //if BD
$auth = new Auth();
session_start();
$auth->authorize();