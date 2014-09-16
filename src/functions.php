<?php
/**
 * Выдает первые два предложения или обрезает строку до 300 символов;
 * @param string $text
 * @param integer $cut_length
 * @return string
 */
function cut_text($text, $cut_length = DEFAULT_CUT_LENGTH) {        // передаем в качестве параметров функции текст и на сколько обрезать текст
    $arText = explode('.', $text, 3);                               // разбиваем текст на три части, разделитель "."
    $str = $arText[0];                                              // изначально строка равна первому предложению из массива
    if (isset($arText[1])) {                                        // если существует в тексте вторая строка, то объединяем ее с первой, разделитель точка
        $str .= '. '  . $arText[1] . '. ';
    }
    if (strlen($str) < $cut_length) {                               // если длина строки меньше заданного количества символов, то возвращаем всю строку
        return $str;
    } else {
        return substr($str, 0, $cut_length) . ' ...';               // если нет, то обрезаем ее и добавляем "..."
    }
}
/**
 * Форматируем дату и время в требуемый формат;
 * @param string $date
 * @param string $format
 * @return string
 */
function my_format_date($date, $format = DEFAULT_DATE_FORMAT) {     // передаем в качестве параметров: элемент массива, где расположена дата и сам формат
    $timestamp = strtotime($date);                                  // создаем переменную, которая приведет строку к веремени
    $formatedDate = date($format, $timestamp);                      // создаем переменную в которой выполняется функция date
    return $formatedDate;                                           //возвращаем переменную, уже форматированную
}
/**
 * Поиск пользователя по логину;
 * @param array $users
 * @param string $login
 * @return boolean || array
 */
function findUserByLogin ($users, $login) {
    foreach ($users as $user) {                                     // проходим по массиву и ищем пользователя с таким логином, если нашли, то прекращаем поиск, если нет, то возвращаем false;
        if ($user['login'] == $login) {                             // если логин совпадает с введенным логином, то возвращаем пользователя;
        return $user;
        }
    }
    return false;                                                   // если пользователя не нашли, то вернем false;
}
/**
 * Поиск идентификатора пользователя по логину;
 * @param array $users
 * @param string $login
 * @return boolean || integer
 */
function findUserIdByLogin ($users, $login) {
    foreach ($users as $userId => $user) {                          // проходим по массиву и ищем пользователя с таким логином, если нашли, то возвращаем идентификатор, если нет, то возвращаем false;
        if ($user['login'] == $login) {
            return $userId;
        } 
    }
    return false;
}
function authorize($users) {
    if (isset($_COOKIE['news_project_user']) && ($userCookie = $_COOKIE['news_project_user'])) {
        $arUserCookie = explode(':', $userCookie);
        if ((count($arUserCookie) == 2)) {
            $login = $arUserCookie[0];
            $md5 = $arUserCookie[1];
            $userId = findUserIdByLogin($users, $login);
            if ($userId !== false) {
                $user = $users[$userId];
                $string = $_SERVER['REMOTE_ADDR'] . "+" . date('Y-m-d') . "+" . $user['salt'] . "+" . $user['password'];
                if ($md5 == md5($string)) {
                    $_SESSION['userId'] = $userId;
                }
            }
        }
    }
}