<?php

class m140927_085031_create_tbl_user extends CDbMigration{
    
    public function up()
    {
        $this->createTable('np_user', array(
            'userId'    => 'int(32) not null auto_increment',
            'login'     => 'varchar(100) not null',
            'password'  => 'varchar(32) not null',
            'salt'      => 'varchar(32) not null',
            'role'      => 'varchar(30) not null default "user"',
            'PRIMARY KEY (userId)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        return true;
    }
    
    public function down(){
        $this->dropTable('np_user');
        return true;
    }
}
