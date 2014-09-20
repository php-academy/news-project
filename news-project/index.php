<?php
    require('include.php');
    require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
    $news_per_page = 6;
    $count_news = count($news);
    if( ($page-1)* $news_per_page >= $count_news ) {
        header("Location: " . PROJECT_PATH . "/404.php");
    } else {
        $news = array_slice($news, ($page-1)* $news_per_page, $news_per_page);
        foreach( $news as $id => $news_element ) {
            NewsItemWriter::writeShortNews($news_element, $id);
        }
    }
?>
<?php
    echo "<div class='pages'>";
    require(ROOT_PROJECT_PATH . '/design/paginator.php');
    echo "</div>";
    require( ROOT_PROJECT_PATH . '/design/footer.php');