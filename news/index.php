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
    ?>
    <h1><?=$news_element['title']?></h1>
    <p><?=$news_element['text']?></p>
    <p><?=$news_element['publish_date'];?></p>
    <p><a href="<?=PROJECT_PATH ?>">к списку новостей</a></p>
    
    <?php
} else {
    header("Location: ".PROJECT_PATH."/404.php");
}
?>
<?php
require(ROOT_PROJECT_PATH . '/design/footer.php');