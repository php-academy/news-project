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
    foreach( $news as $id => $news_element ) {
        require( ROOT_PROJECT_PATH . '/design/news_element.php');
    }
}//генерация ссылок на страницы новостей
?>
<p> Страницы новостей 

<?php
$count_pages = ($count_news / 5) + 1;
for($i=1; $i < $count_pages; $i++) {
?>

| <a href="<?=$i ?>/"> <?=$i ?> </a> |

<?php
}
?>
</p>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');