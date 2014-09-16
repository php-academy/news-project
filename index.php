<?php
require ('include.php');
require (ROOT_PROJECT_PATH . '/design/header.php');                     // вставляем header из файла header.php
$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;          // создаем переменную $page , если она существует, то page = любому абсолютному значению, если нет то равно 1
$count_news = count($news);                                             // количество новостей в массиве
if (($page-1)*5 >= $count_news) {                                       // если так то: либо страница не найдена, либо отрезаем массив и выводим новости на страницу
    echo 'Страница не найдена';
} elseif ($page == 0) {
    echo 'Страница не найдена';  
} else {
    $news = array_slice($news, ($page-1)*5, 5);                         // порезать массив
    foreach ($news as $id => $news_element) {                           // для каждого элемента массива $news, выводим:
        require (ROOT_PROJECT_PATH . '/design/news_element.php');       // подключаем файл, который выводится в формате html;
    } 
}
$page_num = ceil($count_news/5);                                        // подсчитываем количество страниц, округляется в сторону большего;
for( $i = 1 ; $i <= $page_num ; $i++ ){                                 // создаем цикл, который вывод № страницы;
    ?>
    <a href="<?=PROJECT_PATH?>/?page=<?=$i?>"><?=$i?></a>
<?php
}
require (ROOT_PROJECT_PATH . '/design/footer.php');                     // вставляем footer из файла footer.php;
