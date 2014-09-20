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



//select * from users inner join user_role on users.user_id=user_role.user_id inner join roles on user_role.role_id=roles.role_id;
$data = array();

foreach( $arUsers as $userId => $arUser ){
    $data[] = new User($userId, $arUser['login'], $arUser['password'], $arUser['salt'], $arUser['role']);
}

return $data;