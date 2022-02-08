<?php

class Redirect{

    private $url;

    public function __construct()
    {
        if(!empty($_SERVER['HTTPS'])){
            $this->url = 'https://'.$_SERVER['HTTP_HOST'];
        }else{
            $this->url  = 'http://'.$_SERVER['HTTP_HOST'];
        }
        
    }

    public static function redirectBack(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function redirectTo($url){
        header('Location: '.$this->url.$url);
        exit;
    }

    public function redirectToHome($id = null){
        session_start();
        if(!$id){
            $id = $_SESSION['user'];
        }
        if($id){
            header('Location: '.$this->url.'/assets/views/auth/home.php/?id='.$id);
            exit;
        }
    }

    public function redirectNotAuth(){
        if(!$_SESSION['user']){
            $this->redirectTo('/assets/views/unauth/auth/login.php');
        }
    }
}