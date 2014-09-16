<?php
require ('include.php');                                                                                                     // подключаем include.php;
if(isset($_POST['login']) && isset($_POST['password'])) {                                                                    // если в форме передали логин и пароль, то:                        
    if (preg_match("/^[a-zA-Z0-9]{3,20}$/", $_POST['login']) && preg_match("/^[a-zA-Z0-9]{6,20}$/", $_POST['password'])) {   // функция сравнивает значение, переданное в качестве второго параметра с патерном(шаблоном, регулярным выражением) (первым параметром). Здесь проверяются вводимые логин и пароль; 
        $rememberMe = (isset($_POST['rememberMe']) && $_POST['rememberMe']) ? true : false;                                  // создаем переменную, которая следит, нажали чекбокс или нет;
        $userId = false;                                                                                                     // изначально идентификатор false;
        foreach ($users as $userId => $user) {                                                                               // проходим по массиву и ищем пользователя с таким логином, если нашли, то прекращаем поиск, если нет, то идентификатор так и остался false и выводим сообщение, что логин не верен;
            if ($user['login'] == $_POST['login']) {
                break;
            } else {
                $userId = false;
            }
        }
        if ($userId !== false) {                                                                                              // если идентификатор не false, то:
            if (md5($_POST['password'] . $user['salt']) == $user['password']) {                                               // если хэш от пароля и соли совпадает с введенным паролем, то записываем идентификатор в сессию, и если еще и нажат был чекбокс, то записываем куки, иначе выводим сообщение о неверном пароле;
                $_SESSION['userId'] = $userId;
                if ($rememberMe) {
                    $string = $_SERVER['REMOTE_ADDR'] . "+" . date('Y-m-d') . "+" . $user['salt'] . "+" . $user['password'];  // для того чтобы было сложнее украсть куки, ставим проверку по адресу (ip), дате, соли и паролю;
                    $md5 = md5($string);
                    setcookie('news_project_user', $user['login'] . ":" . $md5, time() + 60*60*24, '/');
                }
            } else {
                $_SESSION['login_error_message'] = "Неверный пароль";
            }
          } else {
            $_SESSION['login_error_message'] = "Неверный логин";
        }
    } else {
        $_SESSION['login_error_message'] = "Логин или пароль неверного формата";
    }
    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PROJECT_PATH));                      // после чего делаем перенаправление на главную страницу;
} else {
    header('Location: ' . PROJECT_PATH);                                                                                     // Вернуть пользователя на главную страницу, если пользователь не ввел параметры логин и пароль;
}
