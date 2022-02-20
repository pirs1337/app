<?php

require_once './UserClass.php';
require_once '../Validation/Admin/record/AddRecordClass.php';
require_once '../Validation/Admin/category/AddCategoryClass.php';
require_once '../Validation/Admin/product/AddProductClass.php';
require_once '../Validation/Admin/category/EditCategoryClass.php';
require_once '../Validation/Admin/product/EditProductClass.php';
require_once '../ImgClass.php';
require_once '../Product/ProductClass.php';


class Admin extends User{


    public function addRecord(){
        if(isset($_POST['add_record'])){
            $this->getFormData(['date', 'time']);

            $date = self::formatDate($this->form_data['date']);
            
            $validator = new AddRecord;
            $validator->validate($this->db, $date, $this->form_data['time']);

            $query = "INSERT INTO `records` (`date`, `time`) VALUES (:date, :time)";
            $params = [
                ':date' => $date,
                ':time' => $this->form_data['time']
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, 'record_add');
        }
        
    }

    public function addCategory(){
        if(isset($_POST['add_category'])){
            $this->getFormData(['name', 'slug']);

            $img = $_FILES['img'];

            $validator = new addCategory;
            $validator->validate($this->db, $this->form_data['name'], $this->form_data['slug'], $img);

            $path = Img::uploadImg($img, 'categories', $this->form_data['name']);
            

            $query = "INSERT INTO `categories` (`name`, `slug`, `img`) VALUES (:name, :slug, :img)";
            $params = [
                ':name' => $this->form_data['name'],
                ':slug' => $this->form_data['slug'],
                ':img' => $path
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, 'category');
        }
    }

    public function addProduct(){
        if(isset($_POST['add_product'])){
            $this->getFormData(['name', 'category', 'slug', 'descr', 'price']);

            $imgs = Img::getImages($_FILES['imgs']);

            $validator = new AddProduct;
            $validator->validate($this->db, $this->form_data['name'], $this->form_data['category'], $this->form_data['slug'], $this->form_data['descr'], $this->form_data['price'], $imgs);


            $this->form_data['price'] = ( int ) $this->form_data['price'];


            $query = "INSERT INTO `products` (`name`, `category_id`, `slug`, `descr`, `price`) VALUES (:name, :category_id, :slug, :descr, :price)";
            $params = [
                ':name' => $this->form_data['name'],
                ':category_id' => $this->form_data['category'],
                ':slug' => $this->form_data['slug'],
                ':descr' => $this->form_data['descr'],
                ':price' => $this->form_data['price'],
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, 'category', false);

            // добавление изображений продукта

            $product = new Product;
            $product = $product->getProductBySlug($this->form_data['slug']);

            foreach ($imgs as $img){
                $result = $this->addProductImgs($img, $product);
            }

            self::result($result, 'product');
        }
    }

    public function deleteRecord(){
        if(isset($_POST['delete_record'])){

            $record_id = $_POST['record_id'];
            $record = new Record;
            $record = $record->getRecordById($record_id);

            if(!$record){
                $_SESSION['error'] = self::ERROR_MSG['record_delete'];
                self::redirectBack();
            }

            $query = "DELETE FROM `records` WHERE `id` = ?";
            $params = [$record_id];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, 'record_delete');
            
        }
    }

    public function deleteCategory(){
        if(isset($_POST['delete_category'])){
            $category_id = trim($_POST['category']);

            $category = self::checkCategory($category_id);

            $product = new Product;
            $products = $product->getProductsByCategory($category_id);

            foreach ($products as $product_in_category){
                Img::deleteDir('products', $product_in_category['name']);
            }

            $query = "DELETE FROM `categories` WHERE `id` = ?";
            $params = [$category_id];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, null, false);
            Img::deleteDir('categories', $category['name']);
            self::result($result, 'category_delete');
        }
    }

    public function deleteProduct(){
        if(isset($_POST['delete_product'])){
            $product_id = trim($_POST['product']);

            $product = self::checkProduct($product_id);

            $query = "DELETE FROM `products_imgs` WHERE `product_id` = ?";
            $params = [$product_id];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            self::result($result, null, false);

            $query = "DELETE FROM `products` WHERE `id` = ?";
            $params = [$product_id];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);

            Img::deleteDir('products', $product['name']);

            self::result($result, 'product_delete');
        }
    }


    public function editCategory(){
        if(isset($_POST['edit_category'])){
            $this->getFormData(['name', 'slug','category']);

            $category = self::checkCategory($this->form_data['category']);

            $img = $_FILES['img'];

            $validator = new EditCategory;
            $validator->validate($this->db, $this->form_data['name'], $this->form_data['slug'], $img, $this->form_data['category']);
            
            $query = "UPDATE `categories` SET `name` = :name, `slug` = :slug, `img` = :img  WHERE `id` = :id";
            $params = [
                ':id' => $this->form_data['category'],
                ':name' => $this->form_data['name'],
                ':slug' => $this->form_data['slug']
            ];

            if(file_exists($img['tmp_name']) || is_uploaded_file($img['tmp_name'])){
                Img::deleteDir('categories', $category->name);
                $params[':img'] = Img::uploadImg($img, 'categories', $this->form_data['name']);
            }else{
                $new_path = str_replace($category->name, $this->form_data['name'], $category->img);
                $params[':img'] = $new_path;
                Img::renameDir('categories', $category->name, $this->form_data['name']);
            }

            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
            self::result($result, 'category_edit', false, true);

            $this->redirectTo('/assets/views/auth/admin/category/edit.php/?category='.$this->form_data['slug'].'');
        }
    }

    public function editProduct(){
        if(isset($_POST['edit_product'])){
            $this->getFormData(['name', 'category', 'slug', 'descr', 'price', 'product']);
        
            $product = self::checkProduct($this->form_data['product']);
            $imgs = Img::getImages($_FILES['imgs']);


            $validator = new EditProduct;
            $validator->validate($this->db, $this->form_data['name'], $this->form_data['category'], 
                $this->form_data['slug'], $this->form_data['descr'], $this->form_data['price'], 
                $imgs, $this->form_data['product']);

            
            $this->form_data['price'] = ( int ) $this->form_data['price'];    

            foreach ($imgs as $img){
                if(is_uploaded_file($img['tmp_name'])){
                    
                   $this->editProductImgs($product);
                   $this->addProductImgs($img, $product);
    
                }else{
                    $this->editProductImgs($product);
                }
            }

            $query = "UPDATE `products` SET `name` = :name, `category_id` = :category_id, `slug` = :slug, 
                `descr` = :descr, `price` = :price  WHERE `id` = :id";
            $params = [
                ':id' => $this->form_data['product'],
                ':name' => $this->form_data['name'],
                ':category_id' => $this->form_data['category'],
                ':slug' => $this->form_data['slug'],
                ':descr' => $this->form_data['descr'],
                ':price' => $this->form_data['price'],
            ];

            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
            self::result($result, 'product_edit', false, true);
            $this->redirectTo('/assets/views/auth/admin/product/edit.php/?product='.$this->form_data['slug'].'');
        }

        if($_POST['img_id']){

            $img_id = trim($_POST['img_id']);
            $product = new Product;
            $product_img = $product->getProductImg($img_id);
            if(!$product_img){
                self::jsonResult(false, ['msg' => self::ERROR_MSG['img']]);
            }

            $query = "DELETE FROM `products_imgs` WHERE `id` = ?";
            $params = [$img_id];
            $stmt = $this->db->prepare($query);
            $result =  $stmt->execute($params);

            $product = $product->getProductById($product_img->id);
            
            if($result){
                $delete_img = Img::deleteImg('products', $product->name, $product_img->img);
                if($delete_img){
                    self::jsonResult(true, ['msg' => self::SUCCESS_MSG['img']]);
                }else{
                    self::jsonResult(false, ['msg' => self::ERROR_MSG['img']]);
                } 
            }else{
                self::jsonResult(false, ['msg' => self::ERROR_MSG['img']]);
            }
        }
    }

    private static function checkCategory($id){
        $category = new Category;
        $category = $category->getCategoryById($id);

        if(!$category){
            $_SESSION['error'] = self::ERROR_MSG['category'];
            Redirect::redirectBack();
        }else{
            return $category;
        }
    }

    private function editProductImgs($product){
        $product_imgs = new Product;
        $product_imgs = $product_imgs->getProductImgs($product->id);
        Img::renameDir('products', $product->name, $this->form_data['name']);

        foreach ($product_imgs as $img){
            $new_path = str_replace($product->name, $this->form_data['name'], $img['img']);
            $query = "UPDATE `products_imgs` SET `img` = :img WHERE `id` = :id";
            $params = [
                ':id' => $img['id'],
                ':img' => $new_path
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
           
        }

        return $result;
    }

    private function addProductImgs($img, $product){
            $query = "INSERT INTO `products_imgs` (`product_id`, `img`) VALUES (:product_id, :img)";
            $params = [
                ':product_id' => $product->id,
                ':img' => Img::uploadImg($img, 'products', $this->form_data['name'])
            ];
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($params);
            return $result;
    }

    private static function checkProduct($id){
        $product = new Product;
        $product = $product->getProductById($id);

        if(!$product){
            $_SESSION['error'] = self::ERROR_MSG['product'];
            Redirect::redirectBack();
        }else{
            return $product;
        }
    }

    public function findUsers(){
        $name = 'users';
        if(isset($_GET[$name])){
            $query = $_GET[$name];
            $_SESSION['users'] = $this->search('users', 'username',  $query, 'tel');
            $this->redirectTo('/assets/views/auth/admin/users.php');
        }
    }


}

$admin = new Admin;
$admin->addRecord();
$admin->addCategory();
$admin->addProduct();

$admin->deleteRecord();
$admin->deleteCategory();
$admin->deleteProduct();

$admin->editCategory();
$admin->editProduct();

$admin->findUsers();