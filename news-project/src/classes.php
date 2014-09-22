<?php

class DB {
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = '';
    const DRIVER = 'mysql';
    const DBNAME = 'student04';
    
    protected $_connection;
    
    public function __construct() {
        $dsn = self::DRIVER . ":host=" . self::HOST . ";dbname=" . self::DBNAME;
        try {
            $db = new PDO($dsn, self::USER, self::PASSWORD);
        } catch (PDOException $e) {
            throw new Exception('Cannot connect to database');
        }
        $this->_connection = $db; 
    }
    
    public function connection() {
        return $this->_connection;
    }
}

class User {
    public $userId;
    public $login;
    public $password;
    public $salt;
    
    protected $role;
    
    public function __construct($userId = null, $login = null, $password = null, $salt = null, $role = null) {
        if($userId){$this->userId = $userId;}
        if($login){$this->login = $login;}
        if($password){$this->password = $password;}
        if($salt){$this->salt = $salt;}
        if($role){$this->role = $role;}      
    }
}

class Auth {
    protected $_db;
    
    public function __construct() {
        $this->_db = new DB();
    }
    
    /**
     * Авторизует пользовотеля по паре login/password
     * @param string $login
     * @param string $password
     */
    public function login( $login, $password) {
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
                    return $user->userId;
                } else {
                    $_SESSION['login_error_message'] = "Неверный пароль";
                }                        
            } else {
                $_SESSION['login_error_message'] = "Неверный логин";
            }        
        } else {
            $_SESSION['login_error_message'] = "Логин или пароль неверного формата";
        }
        return false;
    }
    
    /**
     * 
     * @param string $login
     * @param string $password
     * @param string $repeat
     * @param string $name
     * @param integer $age
     * @param string $avatar
     * @return string & boolean
     */
    public function register($login, $password, $repeat, $name = null, $age = null, $avatar = null) {
        $result = array(
            'result' => false,
            'message' => 'Unknown error'
        );
        if($this->validateLogin($login)) {
            if($this->validatePassword($password)) {
                if($password == $repeat) {
                    if(!$this->findUserByLogin($login)) {
                        if(!is_null($name)) {
                            $name = strip_tags($name);
                            $name = htmlspecialchars($name);
                        }
                        if(!is_null($age)) {
                            $age = intval($age);
                        }
                        if($age > 0) {
                            $salt = md5(time() . "+" . rand());
                            $cryptPassword = $this->cryptPassword($password, $salt);
                            if($this->saveUser($login, $cryptPassword, $salt, $role, $name, $age, $avatar)) {
                                $result['message'] = 'Новорожденным запрещена регистрация';
                                $result['result'] = true;
                            } else {
                                $result['message'] = 'Не удалось сохранить нового пользователя';
                            }
                        } else {
                            $result['message'] = 'Новорожденным запрещена регистрация';
                        }
                    } else {
                        $result['message'] = 'Такой логин уже существует';
                    }
                } else {
                    $result['message'] = 'Подтверждение пароля не совпало с паролем';
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
     * Сохраняет пользователя в базу данных
     * @param string $login
     * @param string $password
     * @param string $salt
     * @param string $role
     * @param string $name
     * @param integer $age
     * @param string $avatar
     * @return boolean
     */
    protected function saveUser($login, $password, $salt, $role, $name = null, $age = null, $avatar = null) {
        $connection = $this->_db->connection();
        $connection->beginTransaction();
        try {
            $salt = md5(time() . "+" . rand());
            $st = $connection->prepare("insert into users (login, role, password, salt) values(:login, :role, :password, :salt)");
            $st1->bindParam(':login', $login);
            $st1->bindParam(':role', $role);
            $st1->bindParam(':password', $password);
            $st1->bindParam(':salt', $salt);
            if($st1->execute()) {
                $userId = $connection->lastInsertId();
                $st2 = $connection->prepare("insert into user_profile (login, password, salt, role) values(:userId, :name, :age, :avatar)");
                $st2->bindParam(':userId', $userId);
                $st2->bindParam(':name', $name);
                $st2->bindParam(':age', $age);
                $st2->bindParam(':avatar', $avatar);
            
                if($st2->execute()) {
                    $connection->commit();
                    return true;
                }
            } else {
                throw new Exception('Сохранить пользователя не удалось!');
            }
        } catch (Exception $e) {
            $connection->rollback;
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
    public function getAuthorizedUser() {
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
    protected function generateUserCookie( $user ) {        
        $string = $_SERVER["REMOTE_ADDR"] . "+" . date('Y-m-d') . "+" . $user->salt . "+" . $user->password;
        return $user->login . ":" . md5($string);
    }


    /**
     * Проверяем корректность введенного пользователем пароля
     * @param string $rawPassword
     * @param User $user
     * @return boolean
     */
    protected function checkPassword( $rawPassword, User $user ) {
        if($this->cryptPassword($rawPassword, $user->salt) == $user->password ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Шифруем пароль с помощью md5 и соли
     * @param string $raw
     * @param string $salt
     * @return string
     */
    protected function cryptPassword($raw, $salt) {
        return md5($raw . $salt);
    }
    
    /**
    * Поиск пользователя по логину
    * @param string $login
    * @return boolean | User
    */
    protected function findUserByLogin($login){
        $st = $this->_db->connection()->prepare("select * from users where login=:login");
        $st->bindParam(':login', $login);
        $st->setFetchMode(PDO::FETCH_CLASS, 'User');
        if($st->execute() && $user = $st->fetch()) {
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
        $st = $this->_db->connection()->prepare("select * from users where userId=:userId");
        $st->bindParam(':userId', $userId);
        $st->setFetchMode(PDO::FETCH_CLASS, 'User');
        if($st->execute() && $user = $st->fetch()) {
            return $user;                
        } else {
            return false;
        }
    }
}

class NewsItem {
    public $newsId;
    public $publishDate;
    public $title;
    public $text;
    
    /**
     * 
     * @param string $publishDate
     * @param string $title
     * @param string $text
     */
    public function __construct($newsId, $publishDate, $title, $text) {
        $this->newsId = $newsId;
        $this->publishDate = $publishDate;
        $this->title = $title;
        $this->text = $text;
    }
    
}

class NewsItemWriter {
    const DEFAULT_CUT_LENGTH = 100;
    const DEFAULT_DATE_FORMAT = 'H:i:s d.m.Y';

    /**
     * Записывает укороченную новость, взятую
     * из объекта NewsItem
     * @param NewsItem $news_element
     * @param integer $id
     */
    public static function writeShortNews($news_element) {
        echo "<div class='news'><p><i>" . $this->my_format_date($news_element->publishDate) . "</i>&nbsp;&nbsp;&nbsp;<b>" . $news_element->title . "</b></p>";
        echo "<p>" . $this->cut_text($news_element->text) . "</p>";
        echo "<p><a href='" . PROJECT_PATH . "/news?id=" . $news_element->newsId . "'>Подробно</a></p></div>";
    }
    
    /**
     * Показывает полный текст новости из
     * объекта NewsItem на отдельной странице
     * @param NewsItem $news_element
     */
    public static function writeFullNew($news_element) {
        echo "<h1>" . $news_element->title . "</h1>";
        echo "<p>" . $news_element->text . "</p>";
        echo "<p>" . $news_element->publishDate . "</p>";
        echo "<p><a href='" . PROJECT_PATH . "'>к списку новостей</a></p>";
    }
    
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
    public function my_format_date( $date, $format = self::DEFAULT_DATE_FORMAT){
        $timestamp = strtotime($date);
        $formatedDate = date($format, $timestamp); 
        return $formatedDate;
    }
}