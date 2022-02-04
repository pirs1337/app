<?php

session_start();

require_once __DIR__. '/../CookieClass.php';
require_once __DIR__. '/../Redirect/RedirectClass.php';

class Validator{

    protected $errors = [];

    protected function unique($db, $table, $field, $value, $errorMsg, $id = null){
        $stmt = $db->prepare("SELECT `id` FROM $table WHERE `$field` = ?");
        $stmt->execute([$value]);
        $result = $stmt->fetchColumn();

        if($result && $result != $id){
            $this->errors[$field] = $errorMsg;
        }
    }

    protected function required($value, $field, $errorMsg = 'Поле обязательно для заполнения'){
        if(empty($value)){
            $this->errors[$field] = $errorMsg;
        }   
    }

    // protected function email($email){
    //     $field = 'tel_or_email';
    //     if(!filter_var($email, FILTER_VALIDATE_EMAIL ))
    //     {
    //         $this->errors[$field] = 'Некорректно указан e-mail адрес';
    //     }
    // }


    protected function min($min, $value, $field, $errorMsg){
        if(!array_key_exists($field, $this->errors)){
            if(mb_strlen($value, 'utf-8') < $min){
                $this->errors[$field] = $errorMsg;
            }
        }
    }

    protected function max($max, $value, $field, $errorMsg){
        if(mb_strlen($value, 'utf-8') > $max){
            $this->errors[$field] =  $errorMsg;
        }
    }

    protected function file($value, $field, $required = null){
            if($required){
                if(!file_exists($value['tmp_name']) || !is_uploaded_file($value['tmp_name'])){
                    $this->errors[$field] =  'Изображение обязательно для загрузки';
                }else{
                    $this->validImg($value, $field);
                }
            }else{
                if(file_exists($value['tmp_name']) || is_uploaded_file($value['tmp_name'])){
                    $this->validImg($value, $field);
                } 
            }
            
    }

    // protected function requiredFile($value, $field){
    //     if(!file_exists($value['tmp_name']) || !is_uploaded_file($value['tmp_name'])){
    //         $this->errors[$field] =  'Изображение обязательно для загрузки';
    //     }
    // }
    
    // protected function notRequiredFile($value, $field){
    //     if(file_exists($value['tmp_name']) || is_uploaded_file($value['tmp_name'])){
    //         $this->file($value, $field);
    //     }
    // }

    protected function validImg($value, $field){
        $types = array(2, 3, 18);
        if(!in_array(exif_imagetype($value['tmp_name']), $types)){
            $this->errors[$field] =  'Изображение может иметь только типы: jpeg, png, webp';
        }
        if($value['size'] > 1048576){
            $this->errors[$field] =  'Максимальный размер загружаемого файла 1Мб';
        }
        if($value['error'] != 0){
            if(!$this->errors[$field]){
                $this->errors[$field] =  'Ошибка загрузки';
            }
        }
    }


    protected function validateErrors($fields = []){
        if(!empty($this->errors)){
            $_SESSION['formData'] = $fields;
            Cookie::setCookie('formErrors', serialize($this->errors));
            Redirect::redirectBack();
        }
    }
}


