<?php
$arUsers = array(
    array(
        'login' => 'user1',
        'password' => '97784fec6e2313cf5f1d7ffac21c7098',//'qwerty',
        'salt' => '321',
        'role' => 'user'
    ),
    array(
        'login' => 'admin1',
        'password' => 'ce77a68c0bed6e529190990eebc952a2',//'iamadmin',
        'salt' => '123',
        'role' => 'admin'
    ),
);


$stmt = Database :: prepare ( "select u.user_id,u.login,u.password,u.salt,r.name as role, up.name, up.age, up.avatar"
        . " from users u inner join user_role ur on u.user_id=ur.user_id inner join roles r on ur.role_id=r.role_id"
        . " inner join user_profile up on u.user_id=up.user_id;" ) ;
$stmt -> execute ( ) ;



$result = $stmt->fetchAll(PDO::FETCH_CLASS, "User");



//select * from users inner join user_role on users.user_id=user_role.user_id inner join roles on user_role.role_id=roles.role_id;
/*$data = array();

foreach( $arUsers as $userId => $arUser ){
    $data[] = new User($userId, $arUser['login'], $arUser['password'], $arUser['salt'], $arUser['role']);
}*/

$stmt -> closeCursor ( ) ;

return $result;