<?php


$newsWriter=new NewsItemWriter();








$stmt = Database :: prepare ( "select n.date_time publish_date,n.title,n.text,n.news_id from news n order by n.date_time desc;" ) ;
$stmt -> execute ( ) ;



$result = $stmt->fetchAll(PDO::FETCH_CLASS, "NewsItem");

var_dump($result);


$stmt -> closeCursor ( ) ;

return $result;

