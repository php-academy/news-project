<?php
require('include.php');
require(ROOT_PROJECT_PATH . '/design/header.php');
?>    
<?php
$showNews = new NewsItemWriter($news);

$id = intval($_GET['id']);
if(isset($_GET['id'])) $showNews->writeFullNewsItem($showNews->news[$id]);

else $showNews->paginator();

require( ROOT_PROJECT_PATH . '/design/footer.php');