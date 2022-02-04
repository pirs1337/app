<? 
    require_once '../../../../includes/include.php';
    require_once '../../../../../app/ImgClass.php'; 
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    
    $products = new Product;
    $product = $products->getProductBySlug();
    $title = 'Редактировать  '.$product->name.'';
    require_once '../../../../../assets/views/layouts/head.php';
?> 
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
        <? 
             Base::showSuccessMsg();
             Base::showErrorMsg();
        ?>
        <form class="text-white" action="/app/User/AdminClass.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="<? echo $product->name ?>">
            </div>
            <? if($formErrors['name']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['name'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="category" class="form-label">Категория</label>
                <select class="form-select" aria-label="Default select example" id="category" name="category">
                    <? 
                        $categories = new Category;
                        $current_product_category = $categories->getCategoryById($product->category_id);
                        foreach($categories->getCategories() as $key => $category){
                            if($key == 0){
                                echo '<option selected value="'.((true ? $formData['category']: false) ? $formData['category'] : $current_product_category->id).'">'.((true ? $formData['category']: false) ? $categories->getCategoryById($formData['category'])['name'] : $current_product_category->name).'</option>';
                            }
                            if($current_product_category->name != $category['name']){
                                echo '<option value='.$category['id'].'>'.$category['name'].'</option>';
                            }
                           
                        }
                    ?>
                </select>
            </div>
            <? if($formErrors['category']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['category'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="slug" class="form-label">Код</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<? echo $product->slug ?>">
            </div>
            <? if($formErrors['slug']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['slug'].'</div>';
                } 
            ?>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" id="descr" name="descr" style="height: 100px"><? echo $product->descr ?></textarea>
                <label for="descr">Описание</label>
            </div>
            <? if($formErrors['descr']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['descr'].'</div>';
                }    
            ?>
            <div class=" mb-3">
                <label for="price" class="form-label">Цена</label>
                <input type="number" class="form-control" id="price" name="price" value="<? echo $product->price ?>">
            </div>
            <? if($formErrors['price']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['price'].'</div>';
                }    
            ?>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Добаваьте изображения</label>
                <input class="form-control" type="file" name="imgs[]" id="formFileMultiple" multiple accept=".jpg,.jpeg,.png,.webp">
            </div>
            <? if($formErrors['imgs']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['imgs'].'</div>';
                } 
            ?>
            <input type="hidden" name="product" value="<? echo $product->id ?>">
            <button type="submit" name="edit_product" class="btn bg-purple text-white">Сохранить</button>
        </form>
        <div class="edit-msg mt-5"></div>
        <div class="row row-cols-auto mt-5">
                
                

                <? foreach($products->getProductImgs($product->id) as $img){

                    $arr['element'] = $img;
                    $arr['msg'] = 'Удалить картинку';
                    $arr['msg2'] = 'Вы уверены что хотите удалить это изображение?';
                    $arr['btn_text'] = 'Удалить';
                    $arr['btn'] = 'delete_product_img';

                    echo 
                        '<div class="col-lg-3 mb-3">
                            <div class="position-relative wrapper">
                                <img class="img-fluid" src="'.Img::DIR['products'].$img['img'].'">
                                    <i data-bs-toggle="modal" data-bs-target="#exampleModal'.$img['id'].'" class="fas fa-times text-danger bg-dark px-3 py-1 fs-5 btn border position-absolute top-0 end-0 p-0"></i>
                            </div>';

                            require '../../../layouts/modals/modal.php';
                    
                    echo '</div>';
                } ?>
        </div>
    </main>
    <?  require_once '../../../layouts/footer.php'; ?>
</body>
</html>   