<?php

class NewsController extends Controller{
    
    public function actionIndex() {
        
        $criteria = new CDbCriteria();
        $criteria->order = "publishDate desc";
        
        $pages = new CPagination( NpNewsItem::model()->count($criteria) );
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
                
        $newsItems = NpNewsItem::model()->findAll($criteria);
        
        $this->render('index', array(
            'newsItems' => $newsItems,
            'pages' => $pages, 
        ));
    }
    
    public function actionView( $newsId ){
        $item = NpNewsItem::model()->findByPk($newsId);
        if( $item ) {
            $this->render('view', array( 
                'newsItem' => $item
            ));
        } else {
            throw new CHttpException(404, 'Запрашиваемая вами новость не найдена');
        }           
    }
    
}
