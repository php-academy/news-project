<?php

class RegisterForm extends CFormModel
{
    public $login;
    public $password;
    public $repeatPassword;

    public $name;
    public $age;
    public $avatar;

    public function rules()
    {
        return array(
            array('login, password, repeatPassword', 'required'),
            array('repeatPassword', 'compare', 'compareAttribute'=>'password'),
            array('age', 'numerical', 'allowEmpty' => true, 'integerOnly' => true, 'min' => '1'),
            array('avatar', 'file', 'allowEmpty' => true, 'types' => 'gif,png,jpg,jpeg'),
            array('name', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'rememberMe' => 'Запомнить меня',
            'login'   => 'Логин',
            'password'   => 'Пароль',
            'repeatPassword' => 'Пароль еще раз',
            'age' => 'Возраст',
            'avatar' => 'Аватарка',
            'name' => 'Имя',
        );
    }
}
