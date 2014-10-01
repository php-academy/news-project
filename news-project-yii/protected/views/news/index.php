<?php
/**
 * @var array $newsItems
 * @var NpNewsItem $item
 */
foreach( $items as $item ) {
   $this->renderPartial('_newsItem', array('item' => $item));
}


$this->widget('CLinkPager',array(
    'pages' => $pages,
    'maxButtonCount' => 5,
    'header' => 'страница: ',
    'prevPageLabel' => '&larr;',
    'nextPageLabel' => '&rarr;',
));