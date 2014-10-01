<?php
/**
 * @var NewsItem $item
 */
?>
<p><i><?=$item->formatDate()?></i> <b><?=$item->title?></b></p>
<p>
    <?=$item->shortText()?>
</p>
<p><a href="/news/item/<?=$item->newsId?>">подробнее</a></p>
<hr>

