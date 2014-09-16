<?php
/**
 * Выдает первые 2 предложения
 * или обрезает строку до 300 символов
 * @param string $text
 * @param integer $cut_length
 * @return string
 */
function cut_text($text, $cut_length = DEFAULT_CUT_LENGTH) {
    $arText = explode('.', $text, 3);
    $str = $arText[0];
    if(isset($arText[1])) {
        $str .= '. ' . $arText[1] . '.'; 
    }
    
    if( strlen($str) < $cut_length ){
        return $str;
    } else {
        return substr($str, 0, $cut_length) . ' ...';
    }
}

/**
 * Форматирует дату в требуемый формат
 * @param string $date
 * @param string $format
 * @return string
 */
function my_format_date( $date, $format = DEFAULT_DATE_FORMAT){
    $timestamp = strtotime($date);
    $formatedDate = date($format, $timestamp); 
    return $formatedDate;
}
