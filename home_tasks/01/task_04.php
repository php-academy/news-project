<?php

$name = "John";
$nickname = &$name;
echo "User \"" . $nickname . "\"";
