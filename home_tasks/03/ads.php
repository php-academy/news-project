<?php
$content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br> 
    Fusce ut tellus id purus congue luctus a eu risus. 
    Duis ullamcorper nisl accumsan interdum condimentum.<br> 
    Pellentesque et finibus massa. 
    Vivamus congue vestibulum neque ut feugiat.<br> 
    Aenean bibendum et ipsum vel rhoncus.</p>";
$ads_set1 = array(
    array(
        'ref' => 'http://www.google.com',
        'text' => 'The best search engine in the world',
    ),
    array(
        'ref' => 'http://www.yandex.ru',
        'text' => 'Russian search engine',
    ),
);

$ads_set2 = array(
    array(
        'ref' => 'http://www.amazon.com',
        'text' => 'Biggest seller in Internet',
    ),
    array(
        'ref' => 'http://www.linkinpark.com',
        'text' => 'The best alternative rock band',
    ),
);  

function show_ad($i) {
    global $ads_set1;
    global $ads_set2;
    global $content;
    echo "<a href=" . $ads_set1[$i]['ref'] . ">" . $ads_set1[$i]['text'] . "</a>";
    echo $content;
    echo "<a href=" . $ads_set2[$i]['ref'] . ">" . $ads_set2[$i]['text'] . "</a>";
}