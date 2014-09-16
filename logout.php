<?php
require ('include.php');                                                                                // подключаем файл include.php;
unset($_SESSION[userId]);                                                                               // убиваем сессию $_SESSION[$userId], чтобы разлогиниться;
setcookie ('news_project_user', '', time() - 100, '/');                                                 // убиваем куки, ставим отрицательное время;
header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));     // делаем переход на главную страницу после выхода пользователя;