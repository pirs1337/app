<?php


class Cookie{

    public static function setCookie($key, $value){
        setcookie($key, $value, time() + (365 * 24 * 60 * 60), '/');
    }
  
    // public static function deleteCookies($keys){
    //         if(is_array($keys)){
    //             foreach ($keys as $key){
    //                 setcookie($key, '', time() - (365 * 24 * 60 * 60), '/');
    //             }
    //         }
    // }

    public static function deleteCookie($key){
        if($_COOKIE[$key]){
            setcookie($key, '', time() - (365 * 24 * 60 * 60), '/');
        }
    }

    public static function getUnserializeCookie($key){
        $get_cook = unserialize($_COOKIE[$key]);
        return $get_cook;
    }
}
