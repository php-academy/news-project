<?php

class User {

    public $userId;
    public $login;
    public $password;
    public $salt;
   
    protected $role;
    
   
    public function __construct($userId = null, $login = null, $password = null, $salt = null, $role = null) {
       
        if($userId)$this->userId = $userId;
        if($login)$this->login = $login;
        if($password)$this->password = $password;
        if($salt)$this->salt = $salt;
        if($role)$this->role = $role;
    }

}

class DB {
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = '';
    const DRIVER = 'mysql';
    const DBNAME = 'student07';
    
    protected $_db;


    public function __construct(){
        $dsn = self::DRIVER.":host=".self::HOST . ";dbname=". self::DBNAME;
        
        try{
            $db = new PDO($dsn, self::USER, self::PASSWORD);
        } catch (PDOException $ex) {
            throw new Exception("Can't connect");
        }
        $this->_db = $db;
    }
    /**
     * Недоделланое гибкое решение
     * @param srring $table
     * @param array $columns
     * @param array $params
     */
    /*public function select($table, array $columns, array $params) {
        $query = "SELECT * ";
        if($columns)
             $query .= implode(',', $columns); 
        else
            {
          $query .= "*";    
        }
        $query .= " from". $table;
        /**
         * array (
         *   'userId' => 123,
         *   'login' => 'user1'
         * )
         * where userId = 123 and login = 'user1'
         
        if($params)
            $query .= "";
        foreach ($params as $key => $value){
            $where = $key . "=" . $value;
            $where .= " and";
        }
        */
       
        /**
        * Соединение
        * @return object PDO
        */
       public function connection(){
           return $this->_db;
       }
    
}

class NewsItem {

    public $itemId;
    public $publish_date;
    public $title;
    public $text;

    public function __construct($itemId, $publish_date, $title, $text) {
        $this->itemId = $itemId;
        $this->publish_date = $publish_date;
        $this->title = $title;
        $this->text = $text;
    }

}

class NewsItemWriter {

    protected $news;
    
    public function __construct($news) {
        $this->news = $news;
    }
    
    
    /**
     * Выводит новость целиком на страницу
     * @param NewsItem $new
     * @return array $newItem
     */
    public function writeFullNewsItem($id)
    {
        $new = $this->news[$id]; 
        
        $newItem['title'] = $new->title;
        $newItem['text'] = $new->text;
        $newItem['publish_date'] = $new->publish_date;
        
                return $newItem;
      
    }
    /**
     * Выводит новость в кратком виде
     * @param NewsItem $new
     * @return array $newItem
     */
    public function writeShotNewsItem($page) 
    {
        
        $arNewsOnPage = array_slice($this->news, ($page - 1) * NEWS_ITEMS_ON_PAGE, NEWS_ITEMS_ON_PAGE);
            foreach ($arNewsOnPage as $id => $new) {
                $newsItems[$id] = $new; 
            }
            return $newsItems;
    }
    
    /**
     * Считает новости
     * @return interger
     */
    public function countNewsItem()
    {
        $count = count($this->news);
        return $count;
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
    public function login($login, $password) {
        if (
                $this->validateLogin($login) &&
                $this->validatePassword($password)
        ) {
            $rememberMe = (isset($_POST['rememberMe']) && $_POST['rememberMe']) ? true : false;

            if ($user = $this->findUserByLogin($login)) {
                if ($this->checkPassword($password, $user)) {
                    $_SESSION['userId'] = $user->userId;
                    if ($rememberMe) {
                        setcookie("news_project_user", $this->generateUserCookie($user), time() + 60 * 60 * 24, '/');
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
    public function authorize() {
        if (
                isset($_COOKIE['news_project_user']) &&
                ( $userCookie = $_COOKIE['news_project_user'])
        ) {
            $arUserCookie = explode(':', $userCookie);
            if (count($arUserCookie) == 2) {
                $login = $arUserCookie[0];
                $md5 = $arUserCookie[1];
                if ($user = $this->findUserByLogin($login)) {
                    if ($userCookie == $this->generateUserCookie($user)) {
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
        if (isset($_SESSION['userId'])) {
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
        if ($this->isUserAuthorized()) {
            $user = $this->findUserById($_SESSION['userId']);
            return $user;
        }
        return false;
    }

    public function logout() {
        unset($_SESSION['userId']);
        setcookie('news_project_user', '', time() - 100, '/');
    }
    
    /**
     * Регистрация пользователя
     * @param type $login
     * @param type $password
     * @param type $repeat
     * @param type $name
     * @param type $age
     * @param type $avatar
     * @return string
     */
    public function register($login, $password, $repeat, $name = null, $age = null, $avatar = null) {
        $result = array (
            'result' => false,
            'message' => 'unknown error'
        );
        
        if($this->validateLogin($login))
            { 
            
            if($this->validatePassword($password)) 
                {
                
                if ($password == $repeat) 
                    {
                   
                    if(!$this->findUserByLogin($login))
                        {
                      
                        if(!is_null( $name))
                            {
                            $name = strip_tags($name);
                            $name = htmlspecialchars($name);
                            }
                            if(!is_null($age)) 
                                $age = intval($age);
                            if($age>0) 
                                {
                                $salt = md5(time() . "+" . rand()); //случайно генерируем соль
                                $cryptPassword = $this->cryptPassword($password, $salt);
                                
                                if($this->saveUser($login, $password, $salt, 'user', $name, $age, $avatar)) 
                                    $result['message'] = 'Пользователь успешно зарегистрирован';
                                    $result['result'] = true;
                                
                                }
                            else {
                                $result['message'] = 'Мал возраст';
                            }
                        }
                        else {$result['message'] = 'Пользователь уже существует';
                        
                        }
                    }
                    else {
                        $result['message'] = 'Пароль и подтверждение не совпали';
                    }
                }
            
                else {
                $result['message'] = 'Неверный формат пароля';
            }
       
        }
        else {
            $result['message'] = 'Неверный пароль пользователя';
        }
        
        return $result;
    }
    
    /**
     * Сохраняем пользователя в БД
     * @param string $login
     * @param string $password
     * @param string $salt
     * @param string $role
     * @param string $name
     * @param integer $age
     * @param string $avatar
     * @return boolean
     */
    protected function saveUser($login, $password, $salt, $role, $name, $age, $avatar){
       
        $connection = $this->_db->connection();
        
        $connection->beginTransaction();
       
        try
        {
            $st1 = $connection->prepare("INSERT INTO users (login, password, salt, role) value (:login,:password,:salt,:role)");
           
            $st1->bindParam(':login', $login);
            $st1->bindParam(':password', $password);
            $st1->bindParam(':salt', $salt);
            $st1->bindParam(':role', $role);
            
           
            if($st1->execute()) {
                $userId = $connection->lastInsertId();
                
                $st2 = $connection->prepare("INSERT INTO user_profile (userId, name, age, avatar) value (:userId,:name,:age,:avatar)");
                $st2->bindParam(':userId', $userId);
                $st2->bindParam(':name', $name);
                $st2->bindParam(':age', $age);
                $st2->bindParam(':avatar', $avatar);
       
                if($st2->execute()) {
                    $connection->commit();
                    return true;
                }
            }
            
            throw new Exception ('Сохранить пользователя не удалось'); 
        
        }
            catch(Exception $e){
            $connection->rollBack();
            echo "Ошибка:  "   .  $e->getMessage();
            
            return false;
     
        }
   
    }

    /**
     * Проверяет корректность логина
     * @param string $login
     * @return boolean
     */
    public function validateLogin($login) {
        if (preg_match("/^[a-zA-Z0-9]{3,20}$/", $login)) {
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
    protected function validatePassword($password) {
        if (preg_match("/^[a-zA-Z0-9]{6,20}$/", $password)) {
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
    protected function generateUserCookie($user) {
        $string = $_SERVER["REMOTE_ADDR"] . "+" . date('Y-m-d') . "+" . $user->salt . "+" . $user->password;
        return $user->login . ":" . md5($string);
    }
    
    /**
     * Шифрование пароля
     * @param string $rawPassword
     * @param string $salt
     * @return type
     */
    protected function cryptPassword ($rawPassword, $salt) {
        return md5($rawPassword . $salt);
    }
    /**
     * Проверяем корректность введенного пользователем пароля
     * @param string $rawPassword
     * @param User $user
     * @return boolean
     */
    protected function checkPassword($rawPassword, User $user) {
        if (md5($rawPassword . $user->salt) == $user->password) {
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
    protected function findUserByLogin($login) {
        $st = $this->_db->connection()->prepare("SELECT * from users where login=:login"); 
        
        $st->bindParam(':login', $login);
        $st->setFetchMode(PDO::FETCH_CLASS, 'User');
        $st->execute();
        if($st->execute() && ($user = $st->fetch())) {
             return $user;
            }
        
        else 
        {
        return false;
        }
    }

    /**
     * Поиск пользователя по ID
     * @param integer $userId
     * @return boolean | User
     */
    protected function findUserById($userId) {
      $st = $this->_db->connection()->prepare("SELECT * from users where userId=:userid"); 
        
        $st->bindParam(':userid', $login);
        $st->setFetchMode(PDO::FETCH_CLASS, 'User');
        $st->execute();
        if($st->execute() && ($user = $st->fetch())) {
           
                return $user;
            }
        
        else 
        {
        return false;
        }
    }

}
