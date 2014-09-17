<?php
$requests = array(
    'request_1' => array(
        'numbers' => array(4, 4, 5, 3), 
        'sign' => 1,
    ),
    'request_2' => array(
        'numbers' => array(1, 2, 3, 4),
        'sign' => 3,
    ),
    'requst_3' => array(
        'numbers' => array(1, 2, 3, 4),
        'sign' => 0,
    ),
    'requst_4' => array(
        'numbers' => array(9, 15, 10, 150),
        'sign' => 8,
    ),
);

function check($data) {
    $checked_request = array();
    if($data) {
    foreach($data as $key => $value) { //пары request_0X => массив с числами и ключом
        $min = $value['numbers'][0];   //для каждой новой пары ключ/значение создаются
        $max = $value['numbers'][0];   //новые дефолтные минимальное и максимальное значения
        foreach($value['numbers'] as $in_value) { //поиск минимального и максимального в каждом новом request_0X
            if($in_value < $min) {
                $min = $in_value;   
            }
            if($in_value > $max) {
                $max = $in_value;
            }
        }
        if(($max & $min) == $value['sign']) {    //сравнение подписи и битового "и" минимального и максимального
            $checked_requests[$key] = $value;    //если тру - записываем в массив
        }
    }
    return $checked_requests;
    } else {
        echo "Array is empty";
    }
}
$a = print_r(check($requests), 1);
echo "<pre>" . $a . "</pre>";
