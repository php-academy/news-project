<?php

class NewsController extends Controller{

    public function actionIndex() {

        $criteria = new CDbCriteria;
        $criteria->order = 'publish_date DESC';

        $pages=new CPagination(NewsItem::model()->count($criteria));
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);

        $newsItems = NewsItem::model()->findAll($criteria);

        $this->render('index', array(
            'items' => $newsItems,
            'pages' => $pages,
        ));
    }

    public function actionView( $newsId ) {
        $item = NewsItem::model()->findByPk($newsId);
        if( $item ) {
            if(isset($_POST['Comment'])) {
                $lastCommentId = Yii::app()->db->getLastInsertID();
                $model = Comment();
                $model->attributes = $_POST['Comment'];
                $model->publishDate = formatDate(date());
                $model->commentId = $lastCommentId;
                $model->newsId = $newsId;
                $model->userId = Yii::app()->user->getId(); 
                if( $model->validate() ) {
                    $model->save();
                }
            }
            $comments = comment::model()->findAllByAttributes(array('newsId'=>$item->newsId));
            if( $item ) {
                $this->render('view', array( 
                    'newsItem' => $item,
                    'comments' => $comments,
                ));
            }
        
        } else {
            throw new CHttpException(404, 'Запрашиваема новость не найдена');
        }
    }
} 
