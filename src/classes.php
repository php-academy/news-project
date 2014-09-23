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
    
    protected $role;
    
    public function __construct($userId = null, $login = null, $password = null, $salt = null , $role = null) {
        if($userId){$this->userId = $userId;}
        if($login){$this->login = $login;}
        if($password){$this->password = $password;}
        if($salt){$this->salt = $salt;}
        if($role){$this->role = $role;}      
    }
}

class NewsItem{
    public $newsId;
    public $publish_date;
    public $title;
    public $text;

    function __construct($newsId = null, $publish_date = null , $text = null , $title = null )
    {
        $this->newsId = $newsId;
        $this->publish_date = $publish_date;
        $this->text = $text;
        $this->title = $title;
    }

}

class NewsWriter{
    const DEFAULT_CUT_LENGTH=100;
    const DEFAULT_DATE_FORMAT = 'H:i:s d.m.Y';

    /**
     * Выдает первые 2 предложения
     * или обрезает строку до 300 символов
     * @param string $text
     * @param integer $cut_length
     * @return string
     */
    public function cut_text($text, $cut_length = self::DEFAULT_CUT_LENGTH) {
        $arText = explode('.', $text, 3);
        $str = $arText[0];
        if(isset($arText[1])) {
            $str .= '. ' . $arText[1] . '.';
        }

        if( strlen($str) < $cut_length ){
            return $str;
        } else {
            return substr($str, 0, $cut_length) . ' ...';
        }
    }

    /**
     * Форматирует дату в требуемый формат
     * @param string $date
     * @param string $format
     * @return string
     */
    public function format_date( $date, $format = self::DEFAULT_DATE_FORMAT){
        $timestamp = strtotime($date);
        $formatedDate = date($format, $timestamp);
        return $formatedDate;
    }

    public function shortNewsText(NewsItem $item) {
        ?>
        <p><i><?=  $this->format_date($item->publish_date)?></i>&nbsp;&nbsp;&nbsp;<b><?=$item->title?></b></p>
        <p><?=$this->cut_text($item->text)?></p>
        <?php
    }

    public function fullNewsText(NewsItem $item) {
        ?>
        <h1><?=$item->title?></h1>
        <p><?=$item->text?></p>
        <p><?=$this->format_date($item->publish_date);?></p>
        <?php
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
     * @param boolean $rememberMe
     * @return array
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
    
    /**
     * Сохраняем пользователя в базу данных
     * @param string $login
     * @param string $password
     * @param string $salt
     * @param string $role
     * @param string $name
     * @param integer $age
     * @param string $avatar
     * @return boolean
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

    /**
     * 
     * @return boolean
     */
    public function logout(){
        unset($_SESSION['userId']);
        setcookie('news_project_user', '', time() - 100, '/');
        return true;
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
     * Шифрует пароль
     * @param string $rawPassword
     * @param string $salt
     * @return string
     */
    protected function cryptPassword( $rawPassword, $salt) {
        return md5( $rawPassword . $salt);
    }

    /**
     * Проверяем корректность введенного пользователем пароля
     * @param string $rawPassword
     * @param User $user
     * @return boolean
     */
    protected function checkPassword( $rawPassword, User $user )
    {
        if($this->cryptPassword($rawPassword, $user->salt) == $user->password ) {
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
       if( $st->execute() && ($user = $st->fetch()) ){
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
       if( $st->execute() && ($user = $st->fetch()) ){
            /**
            * @var User $user
            */
            return $user;        
       } else {
           return false;
       }
   }
}