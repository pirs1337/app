<?php

require_once __DIR__.'/../ValidatorClass.php';


class Auth extends Validator{

    private function username($value){
        $this->required($value, 'username');
    }

    private function tel($value){
        $this->required($value, 'tel');
    }

    public function validate($username, $tel){ 
        $this->username($username);
        $this->tel($tel);
        $this->validateErrors(['username' => $username, 'tel' => $tel]);
    }
}