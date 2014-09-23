<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
require(ROOT_PROJECT_PATH . '/design/autorization.php');
?>    
<?php
$showNews = new NewsItemWriter($news);

if(isset($_GET['id'])){
    $arNew = $showNews->writeFullNewsItem(intval($_GET['id']));
    
    require( ROOT_PROJECT_PATH . '/news/index.php');
}

else {
    $page = ((isset($_GET['page']) && intval($_GET['page']) > 1)  ? intval($_GET['page']) : 1);
    
    $count_news = $showNews->countNewsItem();
    
    if (($page - 1) * NEWS_ITEMS_ON_PAGE >= $count_news) {
           header("Location: " . PROJECT_PATH . "/404.php");
           print_r(headers_list());
           ob_end_flush();
        } 
        
    else {
            
        $arNews = $showNews->writeShotNewsItem($page); 
            
        foreach ( $arNews as $id => $new )
            {
                require( ROOT_PROJECT_PATH . '/design/news_element.php');
            }
               
        }
        
        
        $count_pages = ($count_news / NEWS_ITEMS_ON_PAGE) + 1;
            for($i=1; $i < $count_pages; $i++) {
                 require( ROOT_PROJECT_PATH . '/design/pagination.php');

                }
}

require( ROOT_PROJECT_PATH . '/design/footer.php');