<?php

require_once __DIR__.'/../config/DataBaseClass.php';
require_once __DIR__.'/../Product/ProductClass.php';

class Category {
    
    public function __construct()
    {
        $this->db = new DataBase;
        $this->db = $this->db->getDb();
    }

    public function getCategories(){
        $categories = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        $categories = $categories->fetchAll();
        return $categories;
        
    }

    public function getCategoryBySlug(){
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE `slug` = ?");
        $stmt->execute([$_GET['category']]);
        $category = $stmt->fetch(PDO::FETCH_LAZY);
        return $category;
    }

    private function getCategoryWithProducts($id){
        $stmt = $this->db->prepare("SELECT categories.* FROM categories INNER JOIN products ON (categories.id = products.category_id) WHERE categories.id = ? ORDER BY id DESC");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_LAZY);
        return $category;
    }

    public function getCategoriesWithProducts(){
        $categories_with_products = [];
        foreach($this->getCategories() as $category){
            $category_with_products = $this->getCategoryWithProducts($category['id']);
            if($category_with_products){
                $categories_with_products[] = $category_with_products;
            }
        }
        return $categories_with_products;
    }

    public function getCategoryById($id){
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE `id` = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_LAZY);
        return $category;
    }
}

