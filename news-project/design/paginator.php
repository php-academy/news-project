<?php

    if(isset($_GET['page'])) {
        $this_page = intval($_GET['page']);
    } else {
        $this_page = 1;
    }
    if($count_news > $news_per_page) {
        $page_num = 1;
        while($page_num <= ceil($count_news/$news_per_page)) {
            if($page_num != $this_page) {
                echo "<a href='?page=" . $page_num . "' id='news_pages'>". $page_num ."</a>";
            } else {
                echo "<a href='?page=" . $page_num . "' id='visited_page'>". $page_num ."</a>";
            }
        $page_num++;
        }
    }


