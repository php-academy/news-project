<?php

/**
 * Выдаёт первые 2 предложения
 * или обрезает строку до 300 символов
 * @param string $text
 * @param integer $cut_length
 * @return string
 */
    function cut_text($text, $cut_length = DEFAULT_CUT_LENGTH) {
        $arText = explode('.', $text, 1);
        $str = $arText[0];
        if(isset($arText[1])) {
            $str .= '. ' . $arText[1] . '.'; 
        }
        if(strlen($str) < $cut_length) {
            return $str;
        } else {
            return substr($str, 0, $cut_length) . '...';
        }
    }
    /**
     * Возвращает дату, форматированную в соответсвии
     * с требуемым форматом
     * @param string $date
     * @param string $format
     * @return string
     */
    function my_date_format($date, $format = DEFAULT_DATE_FORMAT) {
        $timestamp = strtotime($date);
        $formatedDate = date($format, $timestamp);
        return $formatedDate;
    }
    
function findUserByLogin($users, $login) {
    $userId = false;
    foreach($users as $user) {
        if($user['login'] == $login) {
            return $user;
    }
            return false;
    }
}

function findUserIdByLogin($users, $login) {
    $userId = false;
    foreach($users as $userId => $user) {
        if($user['login'] == $login) {
            return $userId;
    }
            return false;
    } 
}
    
function authorize() {
    if(
       isset($_COOKIE['news+project_user']) &&     
        ($userCookie = $_COOKIE['news+project_user'])    ) {
        $arUserCookie = explode(':', $userCookie);
        if(count($arUserCookie) == 2) {
            $login = $arUserCookie[0];
            $md5 = $arUserCookie[1];
            $user = findUserIdByLogin($users, $login);
            if($user !== false) {
                $user = $users[$userId];
                $string = $_SERVER['REMOTE_ADDR'] . "+" . date('Y-m-d') . "+" . $user['salt'] . "+" . $user['password'];
                if($md5 == md5($string)) {
                    $_SESSION['userId'] = $userId;
                }  
            }
        }
    }
}
