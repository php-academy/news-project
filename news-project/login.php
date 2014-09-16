<?php
    require ('include.php');
    if(isset($_POST['login']) && isset($_POST['password'])) {
        if(
           preg_match("/^[a-zA-Z0-9]{3,20}$/", $_POST["login"]) &&
           preg_match("/^[a-zA-Z0-9]{6,30}$/", $_POST["password"])
        ) {
            $remember = (isset($_POST["rememberMe"]) && $_POST["rememberMe"]) ? true : false;
            $userId = false;
            foreach($users as $userId => $user) {
                if($user['login'] == $_POST["login"]) {
                    break;
                } else {
                    $userId = false;
                }
            }
            if($userId !== false) {
                if(md5($_POST['password'] . $user['salt']) == $user['password']) {
                    $_SESSION['userId'] = $userId;
                    if($remember) {
                        $string = $_SERVER["REMOTE_ADDR"] . "+" . date('Y-m-d') . "+" . $user['salt'] . "+" . $user['password'];
                        $md5 = md5($string);
                        setcookie('news_project_user',$user['login'] . ":" . $md5, time()+60*60*24, '/');
                        header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));
                    }
                } else {
                    $_SESSION['login_error_message'] = "Неверный пароль";
                    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));
                }
            } else {
                $_SESSION['login_error_message'] = "Неверный логин";
                header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));
            }
        } else {
            $_SESSION['login_error_message'] = "Логин или пароль не верного формата";
            header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));
        }
    } else {
    header('Location: ' . PROJECT_PATH);
    }
