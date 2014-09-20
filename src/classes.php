<?php
class BD {
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
    
    protected $role;
    
    public function __construct($userId, $login, $password, $salt, $role) {
        $this->userId = $userId;
        $this->login = $login;
        $this->password = $password;
        $this->salt = $salt;
        $this->role = $role;      
    }
}

class Auth {
    
    /**
     *
     * @var DB
     */
    protected $_db;


    public function __construct() {
        $this->_db = new DB();
    }
    
    /**
     * Авторизует пользовотеля по паре login/password
     * @param string $login
     * @param string $password
     */
    public function login( $login, $password)
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
    }
    
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
        
       $st = $this->_db->connection()->prepare("SELECT * from users where login=:login");
       $st->bindParam(':login', $login);
       $st->setFetchMode(PDO::FETCH_CLASS, 'User');
       if( $user = $st->fetch() ){
            /**
            * @var User $user
            */
            return $user;        
       } else {
           return false;
       }
   }
   
   
   /**
    * Поиск пользователя по ID
    * @param integer $userId
    * @return boolean | User
    */
    protected function findUserById($userId){
       $st = $this->_db->connection()->prepare("SELECT * from users where userId=:userId");
       $st->bindParam(':userId', $userId);
       $st->setFetchMode(PDO::FETCH_CLASS, 'User');
       if( $user = $st->fetch() ){
            /**
            * @var User $user
            */
            return $user;        
       } else {
           return false;
       }
   }
}