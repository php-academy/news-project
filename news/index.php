<?php
require ('../include.php');   // вставляем файл, который находится в каталоге выше
require (ROOT_PROJECT_PATH . '/design/header.php'); // вставляем header из файла header.php
$id = intval($_GET['id']);  // создем переменную, равную целому значению из массива
if (isset($_GET['id']) && isset($news[$id])) { // если существуют, то: 
    $news_element = $news[$id];
    ?>
    <h1><?=$news_element['title']?></h1>   <!--Вывод элементов в HTML -->
    <p><?=$news_element['text']?></p>
    <p><?=my_format_date($news_element['publish_date'])?></p>
    <p><a href="<?=PROJECT_PATH?>">К списку новостей</a></p>
    <?php
} else {
    echo 'Запрашиваемая вами новость не найдена';
}
require (ROOT_PROJECT_PATH . '/design/footer.php'); // вставляем footer из файла footer.php
