<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $userId
 * @property integer $newsId
 * @property string $publishDate
 * @property string $text
 */
class Comment extends CActiveForm {   
    
    public $commentId;
    public $userId;
    public $newsId;
    public $publishDate;
    public $commentText;
    
    
    public function __construct($commentId, $userId, $newsId, $publishDate, $commentText) {
        $this->commentId = $commentId;
        $this->userId = $userId;
        $this->newsId = $newsId;
        $this->publishDate = $publishDate;
        $this->commentText = $commentText;
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text', 'length', 'max'=>300),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('userId, newsId, publishDate, text', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'userId' => 'User',
            'newsId' => 'News',
            'publishDate' => 'Publish Date',
            'text' => 'Text',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('userId',$this->userId);
        $criteria->compare('newsId',$this->newsId);
        $criteria->compare('publishDate',$this->publishDate,true);
        $criteria->compare('text',$this->text,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return comment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}