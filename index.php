<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
/*$page = (isset($_GET['page']) && intval($_GET['page'])) > 1 ? intval($_GET['page']) : 1;
$count_news = count($news);
if( ($page-1)*NEWS_ITEMS_ON_PAGE >= $count_news ) {
    header("Location: " . PROJECT_PATH . "/404.php");
} else {
    $news = array_slice($news, ($page-1)*NEWS_ITEMS_ON_PAGE, NEWS_ITEMS_ON_PAGE);
    foreach( $news as $id => $news_element ) {
        require( ROOT_PROJECT_PATH . '/design/news_element.php');
    }
}*/


if (isset($_GET["page"])){

$page=abs(intval($_GET["page"]));

} else {
    
    $page=1;
}

$count_news=count($news);

$count_page=ceil($count_news/5);

if (($page-1)>=$count_news){
    
  echo "Страница не найдена!";
}else {
    
$news=array_slice($news,($page-1)*5,5);



foreach ( $news as $news_element ){
    
  $newsWriter->writeNewsItem($news_element,2);
}


}

for ($i=1;$i<=$count_page;$i++){
    
    echo '<a href=\\'.PROJECT_PATH.'/?page='.$i.'>'.$i.'</a>'.' ';

}



?>
<?php
require( ROOT_PROJECT_PATH . '/design/footer.php');