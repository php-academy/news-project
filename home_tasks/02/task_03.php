<?php
$request = array(
    'numbers' => array(4, 4, 5, 3), //типа как будто в $request обязательно
    'sign' => 1,                     //всегда ключи numbers и sign
);

function check($data) {
    $min = $data['numbers'][0];   //поэтому здесь ключ numbers фиксирован
    $max = $data['numbers'][0];
    $sign = $data['sign'];
    $sum = 0;
    
    foreach($data['numbers'] as $key => $value) {
        $sum += $value;    //сумма набора чисел
        if($value < $min) {
            $min = $value;
        }
        if($value > $max) {
            $max = $value;
        }
    }
    
    if(($max & $min) == $sign) {
        return $sum; //вывод суммы набора чисел, если я правильно понял и сюда не нужно добавить ещё подпись
    } else {
        return false;
    }
}

 echo check($request);