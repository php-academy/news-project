<?php

class m140927_085131_insert_users_to_tbl_user extends CDbMigration{
    
    public function up()
    {
        $user = new NpUser();
        $user->login = 'vasya';
        $user->salt = md5(time());
        $user->password = md5($user->salt . 'qwerty');
        $user->role = 'user';
        
        if( !$user->save() ){
            print_r($user->getErrors());
            return false;
        }
        
        $user = new NpUser();
        $user->login = 'admin';
        $user->salt = md5(time());
        $user->password = md5($user->salt . 'admin');
        $user->role = 'admin';
        
        if( !$user->save() ){
            print_r($user->getErrors());
            return false;
        }
        
        return true;
    }
    
    public function down(){
        $this->truncateTable(NpNewsItem::model()->tableName());
        return true;
    }
}
