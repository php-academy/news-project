<?php

define("OPERATING_SYSTEM", "WIN");

if(defined("OPERATING_SYSTEM")) {
    switch(OPERATING_SYSTEM) {
        case "WIN": echo "windows operating system";
                    break;
                
        case "UBUNTU":
        case "DEBIAN":
        case "GENTOO": echo "linux operating system";
                       break;
                   
        default: echo "unknown operating system";
                 break;
    }
}
