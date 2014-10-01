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
