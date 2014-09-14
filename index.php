<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1 ;
$count_news = count($news);

if( ($page-1)*5 >= $count_news ) {
    header("Location: ".PROJECT_PATH."/404.php");
} else {
    $news = array_slice($news, ($page-1)*5, 5);
    foreach( $news as $id => $news_element ) {
        require( ROOT_PROJECT_PATH . '/design/news_element.php');
    }
}
?>
<p><a href='<?=PROJECT_PATH?>/news/?page=1'>1</a> <a href='<?=PROJECT_PATH?>news/?page=1'>2<a></p>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');