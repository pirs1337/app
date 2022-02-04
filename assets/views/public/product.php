<? 
    require_once '../../includes/include.php';
    require_once '../../../app/ImgClass.php';
    $products = new Product;
    $product = $products->getProductBySlug();
    Base::errorPage($product);
    $title = $product->name;
    require_once '../layouts/head.php'; 
?>
    <main class="container text-white">
        <h1><? echo $title ?></h1>
            <div class="row flex-wrap">
                <div class="col">
                    <? if (count($products->getProductImgs($product->id)) > 1){
                            echo 
                                '<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">';
                                        
                                            foreach($products->getProductImgs($product->id) as $key => $img){
                                                echo 
                                                    '<div class="carousel-item '.($key === 0 ? 'active' : '').'">
                                                        <img src="'.Img::DIR['products'].$img['img'].'" alt="картинка продукта" class="d-block w-100">
                                                    </div>';
            
                                                }

                                       echo '</div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                </div>';
                        }else{
                            foreach($products->getProductImgs($product->id) as $key => $img){
                                echo 
                                    '<img src="'.Img::DIR['products'].$img['img'].'" alt="картинка продукта" class="w-100">';
                            }
                        } 
                    ?>
                </div>
                <div class="col-lg">
                    <p>Цена: <? echo $product->price ?> ₽</p>
                    <p>Описание: <? echo $product->descr ?></p>
                </div>
            </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>