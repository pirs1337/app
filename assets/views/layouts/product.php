<?php
    require_once '../../../app/ImgClass.php';
    $product_imgs = new Product;
    echo 
        '<div class="mb-4">
                <div class="card h-100" style="width: 18rem;">
                    <a href="/assets/views/public/product.php/?product='.$product['slug'].'" class="text-dark">';
                        foreach($product_imgs->getProductImgs($product['id']) as $key => $img){
                            if($key == 0){
                                echo '<img src="'.Img::DIR['products'].$img['img'].'" class="card-img-top" alt="картинка продукта">';
                            }
                        }
                       echo '<div class="card-body">
                            <h5 class="card-title">'.$product['name'].'</h5>
                            <p class="card-text descr">'.$product['descr'].'</p>
                            <p class="card-text">'.$product['price'].' ₽</p>
                        </div>
                    </a>';
                    $arr = [
                        'element' => $product,
                        'path_edit' => '/admin/product/edit.php/?product',
                        'msg' => 'Удалить продукт',
                        'msg2' => 'Вы уверены что хотите удалить продукт <b>'.$product['name'].'</b>',
                        'name' => 'product',
                        'btn' => 'delete_product',       
                        'btn_text' => 'Удалить'                                             
                    ];
                    require '../layouts/modals/edit_delete.php';
               echo '</div>
        </div>';


    