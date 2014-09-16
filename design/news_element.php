<p><i><?= my_format_date($new->publish_date)?></i>&nbsp;&nbsp;&nbsp;
    <b><?= $new->title ?></b></p>
<p><?=cut_text($new->text)?></p>
<p><a href="<?=PROJECT_PATH?>/?id=<?=$new->itemId?>">подробнее</a></p>
<hr>