<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m140927_074031_create_tbl_news_item
 *
 * @author Ульянка
 */
class m140927_074031_create_tbl_news_item extends CDbMigration{
    
    public function up()
    {
        $this->createTable('np_news_item', array(
            'newsId' => 'int(32) not null auto_increment',
            'title' => 'text not null',
            'text' => 'text not null',
            'publishDate' => 'datetime not null',
            'PRIMARY KEY (newsId)',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');        
    }
    
    public function down(){
        $this->dropTable('np_news_item');
    }
}
