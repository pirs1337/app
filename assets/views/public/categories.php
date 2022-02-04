<? 
    require_once '../../includes/include.php';
    require_once '../../../app/ImgClass.php';
    $categories = new Category;
    $categories_with_products = $categories->getCategoriesWithProducts();

    if(!$_SESSION['success'])Base::errorPage($categories->getCategories());
    $title = 'Категории';
    require_once '../layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
            <? Base::showSuccessMsg();
               Base::showErrorMsg();
            ?>
            <div class="row row-cols-auto">
                <?       
                    $arr = [
                        'path_edit' => '/admin/category/edit.php/?category',
                        'msg' => 'Удалить категорию',
                        'name' => 'category',
                        'btn' => 'delete_category',       
                        'btn_text' => 'Удалить'                                             
                    ];

                            if($user->isAdmin()){
                                foreach($categories->getCategories() as $category){
                                    echo 
                                        '<div class="col mb-4">
                                                <div class="card h-100" style="width: 18rem;">
                                                    <a href="/assets/views/public/category.php/?category='.$category['slug'].'" class="text-dark">
                                                    <img src="'.Img::DIR['categories'].$category['img'].'" class="card-img-top" alt="картинка ктегории">
                                                    <div class="card-body">
                                                        <h5 class="card-title">'.$category['name'].'</h5>
                                                    </div>
                                                    </a>';
                                                        $arr['element'] = $category;
                                                        $arr['msg2'] = 'Вы уверены что хотите удалить категорию <b>'.$category['name'].'</b>';                                          
                                                        require '../layouts/modals/edit_delete.php';
                                            echo '</div>
                                        </div>';
                                }
                            }else{
                                foreach($categories_with_products as $category){
                                    echo 
                                        '<div class="col mb-4">
                                                <div class="card h-100" style="width: 18rem;">
                                                    <a href="/assets/views/public/category.php/?category='.$category['slug'].'" class="text-dark">
                                                    <img src="'.Img::DIR['categories'].$category['img'].'" class="card-img-top" alt="картинка ктегории">
                                                    <div class="card-body">
                                                        <h5 class="card-title">'.$category['name'].'</h5>
                                                    </div>
                                                    </a>';
                                                        $arr['element'] = $category;
                                                        $arr['msg2'] = 'Вы уверены что хотите удалить категорию <b>'.$category['name'].'</b>';
                                                        require '../layouts/modals/edit_delete.php';
                                               echo '</div>
                                        </div>';
                                }
                            }
                        
                ?>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>