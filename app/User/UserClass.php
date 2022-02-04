<?php

session_start();

require_once __DIR__.'/../config/DataBaseClass.php';
require_once __DIR__.'/../CookieClass.php';
require_once __DIR__.'/../Validation/Auth/RegisterClass.php';
require_once __DIR__.'/../Validation/Auth/AuthClass.php';
require_once __DIR__.'/../Record/RecordClass.php';
require_once __DIR__.'/../BaseClass.php';

class User extends Base{

   protected $form_data = [];

   public function __construct()
   {
        $this->db = new DataBase;
        $this->db = $this->db->getDb();
   }

    protected function getFormData($keys){
        foreach ($keys as $key){
            $this->form_data[$key] = trim($_POST[$key]);
            
            if($key == 'img' || $key == 'imgs'){
                $this->form_data[$key] = $_FILES[$key];
            }
        }
    }

    public function register(){
        if(isset($_POST['register'])){

            $this->getFormData(['username', 'tel']);

            $validator = new Register;
            $validator->validate($this->db, $this->form_data['username'], $this->form_data['tel']);
    
            $query = "INSERT INTO `users` (`username`, `tel`) VALUES (:username, :tel)";
            $params = [
                ':username' => $this->form_data['username'],
                ':tel' => $this->form_data['tel'],
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, null, false);
            $this->redirectNotAuth();
        }
    }

    public function auth(){
        if(isset($_POST['auth'])){

            $this->getFormData(['username', 'tel']);

            $validator = new Auth;
            $validator->validate($this->form_data['username'], $this->form_data['tel']);

            $stmt = $this->db->prepare("SELECT * FROM users WHERE `username` = ? AND `tel` = ?");
            $stmt->execute([$this->form_data['username'], $this->form_data['tel']]);
            $user = $stmt->fetch(PDO::FETCH_LAZY);

            if($user){
                $_SESSION['user'] = $user->id;
            
                if(isset($_POST['remember'])){
                    $this->generateRememberToken($user->id);
                }
                $this->redirectToHome();
            }else{
                $_SESSION['error'] = self::ERROR_MSG['auth'];
                $_SESSION['formData'] = ['username' => $this->form_data['username'], 'tel' => $this->form_data['tel']];
                self::redirectBack();
            }
        } 
    }

    public function record(){

        if(isset($_POST['find_record'])){
           $date = self::formatDate($_POST['date']);
           $stmt = $this->db->prepare("SELECT * FROM records WHERE `date` = ? AND `id` NOT IN (SELECT `record_id` FROM users_records)"); 
           $stmt->execute([$date]);
           $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
            if($records){
                Cookie::setCookie('date', $_POST['date']);
                Cookie::setCookie('records', serialize($records));
            }else{
                $_SESSION['error'] = self::ERROR_MSG['record_find'];
            }

           
            self::redirectBack();
        }
        if(isset($_POST['record'])){
            $record = new Record;
            $record_id = $record->getRecordByDateAndTime();
            $result = $this->addUserRecord($record_id);
            self::result($result, 'record');
        } 
    }

    private function addUserRecord($record_id){
        if($record_id){
            $query = "INSERT INTO `users_records` (`user_id`, `record_id`) VALUES (:user_id, :record_id)";
            $params = [
                ':user_id' => $_SESSION['user'],
                ':record_id' => $record_id,
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
            
            return $result;
        }else{
            $_SESSION['error'] = self::ERROR_MSG['record_time'];
            self::redirectBack();
        }
        
    }

    public function getUser($user_id = null){
        if($user_id){
            $user_id = $_SESSION['user'];
        }elseif($_GET['id']){
            $user_id = $_GET['id'];
        }
        $stmt = $this->db->prepare("SELECT * FROM users WHERE `id` = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_LAZY);
        return $user; 
    }

    public function deleteUserRecord(){
        if(isset($_POST['delete_user_record'])){

            $users_record_id = $_POST['record_id'];

            $record = new Record;
            $record = $record->getUserRecordByUserId($users_record_id);

            if(!$record){
                $_SESSION['error'] = self::ERROR_MSG['record_delete'];
                self::redirectBack();
            }

            if($_SESSION['user'] == $record->user_id || $this->isAdmin()){
                $query = "DELETE FROM `users_records` WHERE `id` = ?";
                $params = [$users_record_id];
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute($params);

                self::result($result, 'record_delete');
            }else{
                die(self::ACCESS_DENIED);
            }
        }
    }
    
    private function generateRememberToken($user_id){
        
            $remember_token = bin2hex(random_bytes(127));

            $query = "UPDATE `users` SET `remember_token` = :remember_token WHERE `id` = :id";
            $params = [
                ':id' => $user_id,
                ':remember_token' => $remember_token
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
            
            if($result){
                Cookie::setCookie('remember_token', $remember_token);
                return true;
            }else{
                $_SESSION['error'] = self::ERROR_MSG['error'];
                unset($_SESSION['user']);
                $this->redirectNotAuth();
            }
    }


    public function thisUser(){
        if($_GET['id'] != $_SESSION['user'] && !$this->isAdmin()){
            die(self::ACCESS_DENIED);
        }
    }

    public function logout($logout = null){
        if(isset($_GET['logout']) || $logout){
            Cookie::deleteCookie('remember_token');
            session_destroy();
            self::redirectBack();
        } 
    }

    public function isAdmin($die = null){
        $user = $this->getUser($_SESSION['user']);
        if(!$user->admin){
            if($die){
                die(self::ACCESS_DENIED);
            }else{
                return false;
            }
        }
        return true;
    }

    public function authByRememberToken(){
        
        if(isset($_COOKIE['remember_token']) && !$_SESSION['user']){
            $stmt = $this->db->prepare("SELECT * FROM users WHERE `remember_token` = ?");
            $stmt->execute([$_COOKIE['remember_token']]);
            $user = $stmt->fetch(PDO::FETCH_LAZY);

            if($user){
                $_SESSION['user'] = $user->id;
                $this->generateRememberToken($user->id);
            }
        }
    }

    public function search($table, $field, $str, $field2 = null){
        $query = "SELECT * FROM $table WHERE $field LIKE (:str)";
        if($field2){
            $query .= "OR $field2 LIKE (:str)";
        }
        $params = [':str' => "$str%"];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;

    }

    public function findProduct(){
        $name = 'query';
        if(isset($_GET[$name])){
            if($_SESSION['data']){
                unset($_SESSION['data']);
            }
        
            $query = $_GET[$name];
            if(!$query){
                $this->redirectTo('/assets/views/public/search_results.php/?q='.$query.'');
            }
            $_SESSION['query'] = $query;
            $categories =  $this->search('categories', 'name',  $query);
            if(!$categories){
                $products =  $this->search('products', 'name',  $query);
                if($products){
                    $_SESSION['data'] = $products;
                }
                $this->redirectTo('/assets/views/public/search_results.php/?q='.$query.'&page=1');
            }else{
                foreach($categories as $category){
                    $this->redirectTo('/assets/views/public/category.php/?category='.$category['slug'].'&page=1');
                }  
            }
            
        }
    }
}

$user = new User;
$user->register();

$user->auth();

$user->record();

$user->deleteUserRecord();

$user->logout();

$user->findProduct();


