<?php
require('ads.php');
 if(isset($_GET['ad_block']) && $_GET['ad_block'] == 1) {
     echo $content;
 } else {
     if(!isset($_COOKIE['show'])) {
         setcookie('show', 0, time()+60*5);
     }
     if($_COOKIE['show'] == 0) {
         show_ad($_COOKIE['show']);
         setcookie('show', 1, time()+60*5);
     } else if($_COOKIE['show'] == 1) {
         show_ad($_COOKIE['show']);
         setcookie('show', 0, time()+60*5);                  
     }    
 }
    