<?php
define ('PROJECT_PATH', '/news_project');                                   // создали константу с указанием пути, если поменяется каталог, можно просто исправить в одном месте;
define ('ROOT_PROJECT_PATH', $_SERVER['DOCUMENT_ROOT'] . PROJECT_PATH);     // объявляем константу ROOT_PROJECT_PATH;
require (ROOT_PROJECT_PATH . '/src/init.php');                              // вставляем файл с константами;
require (ROOT_PROJECT_PATH . '/src/functions.php');                         // фставляем файл с функциями;
$news = require (ROOT_PROJECT_PATH . '/data/news.php');                     // присваеиваем перемнной $news все что в файле news.php, все данные объявляем до основного контента;
$users = require(ROOT_PROJECT_PATH . '/data/users.php');                    // присваеиваем перемнной $users все что в файле users.php;
session_start();                                                            // стартуем сессию;
authorize($users);