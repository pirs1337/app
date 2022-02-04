<?php

require_once __DIR__.'/../../ValidatorClass.php';
require_once __DIR__.'/../../../Category/CategoryClass.php';

class AddProduct extends Validator{

    private const table = 'products';

    private function name($db, $value){
        $field = 'name';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такой продукт уже существует');
    }

    private function category($value){
        $field = 'category';
        $category = new Category;
        $category = $category->getCategoryById($value);

        if(!$category){
                $this->errors[$field] = 'Выберите категорию';
        }
    }

    private function slug($db, $value){
        $field = 'slug';
        $this->required($value, $field);
        $this->unique($db, self::table, $field, $value, 'Такой код уже существует');
    }

    private function descr($value){
        $field = 'descr';
        $this->required($value, $field);
    }

    private function price($value){
        $field = 'price';
        $this->required($value, $field);

        if(!$this->errors[$field]){
            if(!ctype_digit($value)){
                $this->errors[$field] = 'Неверный формат цены';
            }
        }
    }

    private function imgs($imgs){
        $field = 'imgs';
        foreach($imgs as $img){
            $this->file($img, $field, true);
        }
    }

    public function validate($db, $name, $category, $slug, $descr, $price, $imgs){ 
        $this->name($db, $name);
        $this->category($category);
        $this->slug($db, $slug);
        $this->descr($descr);
        $this->price($price);
        $this->imgs($imgs);
        $this->validateErrors(['name' => $name, 'category' => $category, 'slug' => $slug, 'descr' => $descr, 'price' => $price]);
    }
}