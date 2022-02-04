<?php

require_once __DIR__.'/../ValidatorClass.php';



class Register extends Validator{

    private const table = 'users';

    private function username($value, $min = 2, $max = 50){
        $field = 'username';
        $this->required($value, $field);
        $this->min($min, $value, $field, 'Имя пользователя должно содержать минимум '.$min.' символа');
        $this->max($max, $value, $field, 'Имя пользователя должно быть не более чем '.$max.' символов');
    }

    private function tel($db, $value, $min = 17, $max = 17){
        $field = 'tel';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такой моб. телефон уже зарегистрирован');
        $this->min($min, $value, $field, 'Некорректный моб. телефон');
        $this->max($max, $value, $field, 'Некорректный моб. телефон');
    }

    public function validate($db, $username, $tel){
        $this->username($username);
        $this->tel($db, $tel);
        $this->validateErrors(['username' => $username, 'tel' => $tel]);
    }
}