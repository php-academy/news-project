<?php

$a = array(
    array(
        "name" => "John",
        "surname" => "Doe",
        "gender" => "Male",
        "dob" => "21.07.85"
    ),
    array(
        "name" => "Satan",
        "surname" => "N/A",
        "gender" => "N/A",
        "dob" => "N/A"
    ),
    array(
        "name" => "Elizabeth",
        "surname" => "DeWitt",
        "gender" => "Female",
        "dob" => "07.05.1892"
    )
);

$b = array_rand($a);

echo $a[$b]["name"];
