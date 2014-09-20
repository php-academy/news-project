<?php
    require('include.php');
    require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
    $page = (isset($_GET['page']) && intval($_GET['page'])) > 1 ? intval($_GET['page']) : 1;
    $news_per_page = 6;
    if(isset($_GET['page'])) {
        if(abs(intval($_GET['page'])) == 0) {
            header('Refresh: 0; url=' . PROJECT_PATH . '/?page=1');
        } else {
            $page = abs(intval($_GET['page']));
        }
    } else {
        $page = 1;
    }
    if(($page-1)*$news_per_page >= $count_news ) {
        echo "Страница не найдена";
    } else {
        $news = array_slice($news, ($page-1)*$news_per_page, $news_per_page);
        foreach($news as $id => $news_element) {
            require(ROOT_PROJECT_PATH . '/design/news_element.php');
        }
    }
?>
<?php
    echo "<div class='pages'>";
    require(ROOT_PROJECT_PATH . '/design/paginator.php');
    echo "</div>";
    require( ROOT_PROJECT_PATH . '/design/footer.php');