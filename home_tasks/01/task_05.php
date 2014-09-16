<?php

$name = "John";
$nickname = "j.doe";
unset($name);
if(isset($name)) {
    echo $name;
} else {
    echo $nickname;
}
