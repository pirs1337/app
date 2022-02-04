<?php
require_once __DIR__.'/../../ValidatorClass.php';


class AddCategory extends Validator {

    private const table = 'categories';

    private function name($db, $value){
        $field = 'name';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такая категория уже существует');

    }

    private function slug($db, $value){
        $field = 'slug';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такой код уже существует');
    }

    private function img($value){
        $field = 'img';
        $this->file($value, $field, true);
    }

    public function validate($db, $name, $slug, $img){ 
        $this->name($db, $name);
        $this->slug($db, $slug);
        $this->img($img);
        $this->validateErrors(['name' => $name, 'slug' => $slug]);
    }
}