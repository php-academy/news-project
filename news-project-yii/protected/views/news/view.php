<?php
/**
 * @var NpNewsItem $newsItem
 */
?>
<h1><?=$item->title?></h1>
<p>
    <?=$item->text?>
</p>
<p><?=$item->formatDate() ?></p>
<p><a href="/news/">все новости</a></p>
<hr>
<?php
foreach($comments as $value) {
    echo "&nbsp;&nbsp; " . $value->model()->findByAttributes(array('userId' => $value->userId))->name . " commented at " . $value->publishDate;
    echo "<p>" . $value->text . "</p>";
    echo "<hr>";
}
?>
