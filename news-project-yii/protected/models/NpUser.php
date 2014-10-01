<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'np_user':
 * @property integer $userId
 * @property string $login
 * @property string $password
 * @property string $salt
 * @property string $role
 */
class NpUser extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('login, password, salt', 'required'),
            array('login', 'length', 'max'=>100),
            array('password, salt', 'length', 'max'=>32),
            array('role', 'length', 'max'=>30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('userId, login, password, salt, role', 'safe', 'on'=>'search'),
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
            'login' => 'Login',
            'password' => 'Password',
            'salt' => 'Salt',
            'role' => 'Role',
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
        $criteria->compare('login',$this->login,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('salt',$this->salt,true);
        $criteria->compare('role',$this->role,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NpUser the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}