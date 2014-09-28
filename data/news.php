<?php


$newsWriter=new NewsItemWriter();








$stmt = Database :: prepare ( "select n.date_time,n.title,n.text,n.news_id from news order by n.date_time desk" ) ;
$stmt -> execute ( ) ;



$result = $stmt->fetchAll(PDO::FETCH_CLASS, "NewsItem");



//select * from users inner join user_role on users.user_id=user_role.user_id inner join roles on user_role.role_id=roles.role_id;
/*$data = array();

foreach( $arUsers as $userId => $arUser ){
    $data[] = new User($userId, $arUser['login'], $arUser['password'], $arUser['salt'], $arUser['role']);
}*/

$stmt -> closeCursor ( ) ;

return $result;





return $news_data;