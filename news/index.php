<?php
require('../include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
?>
<?php
$id = intval($_GET['id']);
if( 
    isset($_GET['id']) &&
    isset($news[$id])
){
    $news_element = $news[$id];
    
    $newsWriter->writeNewsItem($news_element);
    ?>
   
    
    <?php
} else {
    header("Location: ".PROJECT_PATH."/404.php");
}
?>
<?php
require(ROOT_PROJECT_PATH . '/design/footer.php');