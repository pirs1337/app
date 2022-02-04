<? 
    require_once '../../includes/include.php';
    $category = new Category;
    $category_by_slug = $category->getCategoryBySlug();
    Base::errorPage($category_by_slug);

    $products = new Product;
    if(!$products->getProductsByCategory($category_by_slug->id) && isset($_GET['page'])){
        Base::notFound();
    }
    $title = $category_by_slug->name;
    require_once '../layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white">Категория <? echo $title ?></h1>
            <? 
                Base::showSuccessMsg(); 
                Base::showErrorMsg();
            ?>
            <div class="row row-cols-auto">
                <?
                    $products = new Product;

                    if(!$products->getProductsByCategory($category_by_slug->id)){
                        echo '<p class="text-white">В категории нет товаров</p>';
                    }

                    $last_product = end($products->getProductsByCategoryNoLimit($category_by_slug->id));

                        $page = (int) $_GET['page'];
                        if($page){
                            $nextPage = $page + 1;
                        }else{
                            $nextPage = $page + 2;
                        }
                        
                        $products = $products->getProductsByCategory($category_by_slug->id);

                        foreach($products as $key => $product){
                            require '../layouts/product.php';
                        }

                        if($last_product['id'] != $product['id']){
                            echo '<a class="btn h-25 bg-purple text-white" href="?category='. $category_by_slug->slug.'&page='.$nextPage.'">Далее</a>';
                        }
                        

                        if($page > 1){
                            $prevPage = $page -1;
                            echo '<a class="btn h-25 bg-purple text-white" href="?category='. $category_by_slug->slug.'&page='.$prevPage.'">Назад</a>';
                        } 
                ?>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>