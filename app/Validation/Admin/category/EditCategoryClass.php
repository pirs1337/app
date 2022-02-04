<?php
require_once __DIR__.'/../../ValidatorClass.php';
require_once __DIR__.'/../../../Category/CategoryClass.php';


class EditCategory extends Validator {

    private const table = 'categories';

    private function name($db, $value, $id){
        $field = 'name';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такая категория уже существует', $id);

    }

    private function slug($db, $value, $id){
        $field = 'slug';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такой код уже существует', $id);
    }

    private function img($value){
        $field = 'img';
        $this->file($value, $field);
    }

    public function validate($db, $name, $slug, $img, $id){ 
        $this->name($db, $name, $id);
        $this->slug($db, $slug, $id);
        $this->img($img);
        $this->validateErrors(['name' => $name, 'slug' => $slug]);
    }
}