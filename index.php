<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
$page = (isset($_GET['page']) && intval($_GET['page'])) > 1 ? intval($_GET['page']) : 1;
$count_news = count($news);
if( ($page-1)*NEWS_ITEMS_ON_PAGE >= $count_news ) {
    header("Location: " . PROJECT_PATH . "/404.php");
} else {
    $news = array_slice($news, ($page-1)*NEWS_ITEMS_ON_PAGE, NEWS_ITEMS_ON_PAGE);
    $writer = new NewsWriter();
    foreach( $news as $news_element ) {
        $writer->shortNewsText($news_element);
        ?><p><a href="<?=PROJECT_PATH?>/news/?id=<?=$news_elemnt->newsId?>">подробнее</a></p>
        <hr><?php
    }
}
?>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');