<?php

class DB {
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = '';
    const DRIVER = 'mysql';
    const DBNAME = 'student01';

    protected $_connection;


    public function __construct(){
        $dsn = self::DRIVER . ":host=" . self::HOST . ";dbname=" . self::DBNAME;
        try{
            $db = new PDO($dsn, self::USER, self::PASSWORD);
        } catch( PDOException $e ){
            throw new Exception('Can`t connect to database');
        }
        $this->_connection = $db;
    }
    /**
     *
     * @return PDO
     */
    public function connection(){
        return $this->_connection;
    }
}

class User 
{
    public $userId;
    public $login;
    public $password;
    public $salt;
    public $name;
    public $age;
    public $avatar;
    
    protected $role;
    
    public function __construct($userId=null, $login=null, $password=null, $salt=null, $role=null,$name=null,$age=null,$avatar=null) {
        if(isset($userId)){$this->userId = $userId;
        $this->login = $login;
        $this->password = $password;
        $this->salt = $salt;
        $this->role = $role;      
        
        $this->name = $name;
        $this->age = $age;
        $this->avatar = $avatar;
        }
    }
}




class Auth {
    protected $users;

    protected $_db;


    public function __construct() {
        $this->_db = new DB();
    }

    
    public function register( $login, $password, $repeat, $name = null, $age = null, $avatar = null){
        $result = array(
            'result' => false,
            'message' => 'unknown error'
        );

        if( $this->validateLogin($login) ){
            if( $this->validatePassword($password) ){
                if( $password == $repeat ) {
                    if( !$this->findUserByLogin($login) ){
                        if( !is_null( $name ) ){
                            $name = strip_tags($name);
                            $name = htmlspecialchars($name);
                        }
                        if( !is_null($age) ){
                            $age = intval( $age );
                        }
                        if( $age > 0 ){
                            $salt = md5( time() . "+" . rand() );
                            $cryptPassword = $this->cryptPassword($password, $salt);
                            if( $this->saveUser($login, $cryptPassword, $salt, 'user', $name, $age, $avatar) ){
                                $result['message'] = 'пользователь успешно зарегистрирован';
                                $result['result'] = true;
                            } else {
                                $result['message'] = 'Не удалось сохранить нового пользователя';
                            }
                        } else {
                            $result['message'] = 'Возраст должен быть > 0';
                        }
                    } else{
                        $result['message'] = 'Пользователь с таким именени и паролем уже существует';
                    }
                } else {
                    $result['message'] = 'Пароль и подтверждение пароля не совпали';
                }
            } else {
                $result['message'] = 'Неверный формат пароля';
            }
        } else {
            $result['message'] = 'Неверный формат логина';
        }
  return $result;
  
    }
    /*public function registr($login,$password,$repeat,$name,$age){
        
        $result=array (
            'result'=>false,
            'message'=>'Неизвестнаяошибка!'
            
        );
        
        if ($this->validateLogin($login)){
            
            if($this->validatePassword($password)){
                
                if ($password=$repeat){
                    
                    if($this->findUserByLogin($login)){
                        
                        
                        $name=  strip_tags($name);
                        $name=  htmlspecialchars($name);
                        $age=intval($age);
                        
                        if(!is_null($name) && $age>0){
                            
                         if (  $this->saveUser($login, $password, $repeat, $name, $age, $avatar)){
                             
                          $result['message']="Пользователь успешно зарегистрирован!";   
                          return true;
                         
                         }
                            
                        } $result['message']="Возраст должен быть больше 0!";
                    } $result['message']="Пользователь с таким логином уже существует!";
                    
                } else $result['message']="Пароль проверки не совпадает с паролем!";
            } else $result['message']="Не верный формат поля!";
        } else $result['message']="Не верный формат поля!";
        
        return $result;
    }
    */
    
    
    protected function saveUser( $login, $password, $salt, $role, $name, $age, $avatar ){
        $connection = $this->_db->connection();

        $connection->beginTransaction();
        try{
            $st1 = $connection->prepare("INSERT INTO users (login, password, salt, role) values(:login,:password,:salt,:role)");
            $st1->bindParam(':login', $login);
            $st1->bindParam(':password', $password);
            $st1->bindParam(':salt', $salt);
            $st1->bindParam(':role', $role);

            if( $st1->execute() ) {
                $userId = $connection->lastInsertId();
                $st2 = $connection->prepare("INSERT INTO user_profile (userId, name, age, avatar) values(:userId,:name,:age,:avatar)");
                $st2->bindParam(':userId', $userId);
                $st2->bindParam(':name', $name);
                $st2->bindParam(':age', $age);
                $st2->bindParam(':avatar', $avatar);
                if( $st2->execute() ){
                    $connection->commit();
                    return true;
                }
            }
            throw new Exception('Сохранить пользователя не удалось!');

        } catch( Exception $e ){
            $connection->rollBack();
            return false;
        }
    }
/*
    protected function saveUser($login,$password,$repeat,$name,$age,$avatar){
        
        $salt=md5(time()."+".rand());
        
        try{
        
        $stmt = Database :: prepare ( "insert into users values(null,:login,:password,:salt)" ) ;
        
        $stmt -> execute (array( ':login' => $login, ':password' => md5($password),':salt'=>$salt )  ) ;
        
        $id= $stmt::lastInsertID;
 
        
        $stmt -> closeCursor ( ) ;
        
           $stmt = Database :: prepare ( "insert into user_profile values(:id,:name,:age,:avatar)" ) ;
        
        $stmt -> execute (array( ':id' => $id, ':name' => $name,':age'=>$age,':avatar'=>$avatar)  ) ;
        
        $stmt -> closeCursor ( ) ;
        } catch( Exception $e ){
            
            return false;
        }
        
        return true;
    }*/

        /**
     * Авторизует пользовотеля по паре login/password
     * @param string $login
     * @param string $password
     */
    
    public function login($login, $password, $rememberMe)
    {
        $result = array(
            'result' => false,
            'message' => 'Неизвестная ошибка',
        );
        if(
            $this->validateLogin($login) &&
            $this->validatePassword($password)
        ) {
            if( $user = $this->findUserByLogin($login) )
            {
                if( $this->checkPassword($password, $user)) {
                    $_SESSION['userId'] = $user->userId;

                    if( $rememberMe ) {
                        setcookie( "news_project_user", $this->generateUserCookie($user), time() + 60*60*24, '/' );
                    }
                    $result['result'] = true;
                    $result['message'] = 'Вы успешно авторизованы';
                    $result['data'] = array( 'login' => $user->login );
                } else {
                    $result['message'] =  "Неверный пароль";
                }
            } else {
                $result['message'] =  "Неверный логин";
            }
        } else {
            $result['message'] =  "Логин или пароль неверного формата";
        }
        return $result;
    }

   /* public function login( $login, $password)
    {
        if( 
            $this->validateLogin($login) &&
            $this->validatePassword($password)
        ) {
            $rememberMe = (isset($_POST['rememberMe']) && $_POST['rememberMe']) ? true : false;

            if( $user = $this->findUserByLogin($login) ) 
            {
                if( $this->checkPassword($password, $user)) {
                    $_SESSION['userId'] = $user->userId;
                    if( $rememberMe ) {                       
                        setcookie( "news_project_user", $this->generateUserCookie($user), time() + 60*60*24, '/' );                    
                    }
                } else {
                    $_SESSION['login_error_message'] = "Неверный пароль";
                }                        
            } else {
                $_SESSION['login_error_message'] = "Неверный логин";
            }        
        } else {
            $_SESSION['login_error_message'] = "Логин или пароль неверного формата";
        }
    }*/
    
    /**
     * Авторизует пользователя на основе COOKIE
     */
    public function authorize(){
        if( 
            isset($_COOKIE['news_project_user'])  &&
            ( $userCookie = $_COOKIE['news_project_user'])
        ) 
        {
            $arUserCookie = explode(':', $userCookie);
            if( count($arUserCookie) == 2 ) 
            {
                $login = $arUserCookie[0];
                $md5 = $arUserCookie[1];
                if( $user = $this->findUserByLogin($login) ) {
                    if( $userCookie == $this->generateUserCookie($user) ) {
                        $_SESSION['userId'] = $user->userId;
                    }
                }            
            }        
        }
    }
    
    /**
     * Проверет авторизован ли пользователь или нет
     */
    public function isUserAuthorized() {
        if( isset($_SESSION['userId']) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Находит текущего авторизованного пользовотеля либо false
     * @return boolean | User
     */
    public function getAuthorizedUser()
    {
        if( $this->isUserAuthorized() ) {
            $user = $this->findUserById($_SESSION['userId']);
            return $user;
        }
        return false; 
    }

    public function logout(){
        unset($_SESSION['userId']);
        setcookie('news_project_user', '', time() - 100, '/');
    }

    /**
     * Проверяет корректность логина
     * @param string $login
     * @return boolean
     */
    public function validateLogin( $login ){
        if( preg_match("/^[a-zA-Z0-9]{3,20}$/", $login) ){
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * Проверяет корректность пароля
     * @param string $password
     * @return boolean
     */
    protected function validatePassword($password){
         if( preg_match("/^[a-zA-Z0-9]{6,20}$/", $password) ){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Генерируем для пользователя метку в COOKIE
     * @param User $user
     * @return string
     */
    protected function generateUserCookie( $user )
    {        
        $string = $_SERVER["REMOTE_ADDR"] . "+" . date('Y-m-d') . "+" . $user->salt . "+" . $user->password;
        return $user->login . ":" . md5($string);
    }


    /**
     * Проверяем корректность введенного пользователем пароля
     * @param string $rawPassword
     * @param User $user
     * @return boolean
     */
    protected function checkPassword( $rawPassword, User $user )
    {
        if( md5( $rawPassword . $user->salt ) == $user->password ) {
            return true;
        } else {
            return false;
        }
    }
   
    /**
    * Поиск пользователя по логину
    * @param string $login
    * @return boolean | User
    */
    protected function findUserByLogin($login){
       foreach( $this->users as $user) {
           /**
            * @var User $user
            */
           if( $user->login == $login ){
               return $user;
           }
       }
       return false;
   }
   
   
   /**
    * Поиск пользователя по ID
    * @param integer $userId
    * @return boolean | User
    */
    protected function findUserById($userId){
       foreach( $this->users as $user) {
           /**
            * @var User $user
            */
           if( $user->userId == $userId ){
               return $user;
           }
       }
       return false;
   }
}

class Database {
    private static $link = null ;

    private static function getLink ( ) {
        if ( self :: $link ) {
            return self :: $link ;
        }

        $ini = ROOT_PROJECT_PATH. "/src/config.ini" ;
        $parse = parse_ini_file ( $ini , true ) ;

        $driver = $parse [ "db_driver" ] ;
        $dsn = "${driver}:" ;
        $user = $parse [ "db_user" ] ;
        $password = $parse [ "db_password" ] ;
        $options = $parse [ "db_options" ] ;
        $attributes = $parse [ "db_attributes" ] ;

        foreach ( $parse [ "dsn" ] as $k => $v ) {
            $dsn .= "${k}=${v};" ;
        }

        self :: $link = new PDO ( $dsn, $user, $password, $options ) ;

        foreach ( $attributes as $k => $v ) {
            self :: $link -> setAttribute ( constant ( "PDO::{$k}" )
                , constant ( "PDO::{$v}" ) ) ;
        }

        return self :: $link ;
    }

    public static function __callStatic ( $name, $args ) {
        $callback = array ( self :: getLink ( ), $name ) ;
        return call_user_func_array ( $callback , $args ) ;
    }
} 
