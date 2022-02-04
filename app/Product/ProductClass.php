<?php

require_once __DIR__.'/../config/DataBaseClass.php';

class Product {
    
    public function __construct()
    {
        $this->db = new DataBase;
        $this->db = $this->db->getDb();
    }

    public function getProducts(){
        $products = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $products;
    }

    public function getProductBySlug($slug = null){
        if(!$slug){
            $slug = $_GET['product'];
        }
        $stmt = $this->db->prepare("SELECT * FROM products WHERE `slug` = ?");
        $stmt->execute([$slug]);
        $product = $stmt->fetch(PDO::FETCH_LAZY);
        return $product;
    }

    public function getProductsByCategory($id){
        
        if(isset($_GET['page'])){
            if(ctype_digit($_GET['page'])){
                $page = $_GET['page'];
            }else{
                die('404');
            }       
        }else{
            $page = 1;
        }
        $count_products = 3;
        $page = ($page - 1) * $count_products;
        

        $stmt = $this->db->prepare("SELECT * FROM products WHERE `category_id` = ?  ORDER BY id DESC LIMIT $page, $count_products");
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProductsByCategoryNoLimit($id){
        $stmt = $this->db->prepare("SELECT * FROM products WHERE `category_id` = ? ORDER BY id DESC");
        $stmt->execute([$id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }


    public function getProductImgs($id){
        $stmt = $this->db->prepare("SELECT * FROM products_imgs WHERE `product_id` = ?");
        $stmt->execute([$id]);
        $imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $imgs;
    }

    public function getProductImg($id){
        $stmt = $this->db->prepare("SELECT * FROM products_imgs WHERE `id` = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetch(PDO::FETCH_LAZY);
        return $img;
    }

    public function getProductById($id){
        $stmt = $this->db->prepare("SELECT * FROM products WHERE `id` = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_LAZY);
        return $product;
    }
}

