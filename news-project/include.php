<?php
    define('PROJECT_PATH', '/news_project');
    define('ROOT_PROJECT_PATH', $_SERVER['DOCUMENT_ROOT'] . PROJECT_PATH);
    require(ROOT_PROJECT_PATH . '/src/init.php');
    require(ROOT_PROJECT_PATH . '/src/functions.php');
    $news = require(ROOT_PROJECT_PATH . '/data/news.php');
    $users = require (ROOT_PROJECT_PATH . '/data/users.php');
    session_start();
    authorize($users);
