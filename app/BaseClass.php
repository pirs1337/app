<?php
require_once __DIR__.'/./Redirect/RedirectClass.php';
require __DIR__.'/./Msg/Msg.php';

// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);

class Base extends Redirect implements Msg{

    public static function formatDate($date){
        if($date){
            $date = date("d.m.Y", strtotime($date));
            return $date;
        }
    }

    public static function errorPage($var, $msg = null){
        if(!$var){
            if($msg){
                die($msg);
            }else{
                self::notFound();
            }
            
        }
    }
    public static function showSuccessMsg(){
        if($_SESSION['success']){
            echo '<div class="alert alert-success mt-5" role="alert">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
        }
    }

    public static function showErrorMsg(){
        if($_SESSION['error']){
            echo '<div class="alert alert-danger mt-5" role="alert">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        }
    }

    public static function result($result, $key = false, $redirect = true, $session = false){
        if($redirect){
            if($result){
                $_SESSION['success'] = self::SUCCESS_MSG[$key];
                self::redirectBack();
            }else{
                $_SESSION['error'] = self::ERROR_MSG['error'];
                self::redirectBack();
            }
        }else{
            if($result){
                if($session && $key){
                    $_SESSION['success'] = self::SUCCESS_MSG[$key]; 
                }
                return true;
            }else{
                $_SESSION['error'] = self::ERROR_MSG['error'];
                self::redirectBack();
            }
        }
    }

    public static function jsonResult($status, $arr = []){
        $response['status'] = $status;
        foreach($arr as $key => $element ){
            $response[$key] = $element;
        }  
        echo json_encode($response);
        die;
    }

    public static function notFound(){
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        exit;
    }
}
