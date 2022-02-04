<? 
    require_once '../../includes/include.php';
    $title = 'Каталог';
    require_once '../layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
            <? 
                Base::showSuccessMsg(); 
                Base::showErrorMsg();
            ?>
             <form class="" method="GET" action="/app/User/UserClass.php">
                    <input class="form-control mb-3" name="query"  type="search" placeholder="Поиск продуктов по категории" aria-label="Search">
            </form>
            <div class="row g-2">
                <div class="col-2 me-3">
                    <div class="d-flex flex-column categories-list flex-shrink-0 p-3 bg-light mb-4" style="max-width: 280px; min-width:min-content;">
                        <a href="/assets/views/public/categories.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                            <span class="fs-5">Категории</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-auto">
                            <? 
                                $categories = new Category;
                               

                                if($user->isAdmin()){
                                    foreach($categories->getCategories() as $key => $category){
                                        echo 
                                            '<li class="nav-item">
                                                <a href="/assets/views/public/category.php/?category='.$category['slug'].'" class="nav-link text-dark">'.$category['name'].'</a>
                                            </li>';   
                                    }
                                  
                                }else{
                                    foreach($categories->getCategoriesWithProducts() as $key => $category){
                                        echo 
                                            '<li class="nav-item">
                                                <a href="/assets/views/public/category.php/?category='.$category->slug.'&page=1" class="nav-link text-dark">'.$category->name.'</a>
                                            </li>';
                                    }
                                }
                            ?>
                        </ul>
                        <hr>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="row row-cols-auto">
                        <?
                            $products = new Product;
                                foreach($products->getProducts() as $key => $product){
                                    if($key < 3){
                                        require '../layouts/product.php';
                                    }
                                }
                        ?>
                    </div>                  
                </div>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>