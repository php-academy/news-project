<div class="news"><p><i><?=my_format_date($news_element->publish_date)?></i>&nbsp;&nbsp;&nbsp;<b><?=$news_element->title?></b></p>
<p><?=cut_text($news_element->text)?></p>
<p><a href="<?=PROJECT_PATH?>/news?id=<?=$id?>">Подробно</a></p></div>
