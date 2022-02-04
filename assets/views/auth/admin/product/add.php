<? 
    require_once '../../../../includes/include.php'; 
    require_once '../../../../../app/Category/CategoryClass.php';
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    $categories = new Category;
    Base::errorPage($categories->getCategories(), 'Создайте категорию чтобы получить доступ к странице');
    $title = "Добавить продукт";
    require_once '../../../../../assets/views/layouts/head.php'; 
?> 
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
        <? 
            Base::showSuccessMsg();
            Base::showErrorMsg();
        ?>
        <form class="text-white" action="../../../../../app/User/AdminClass.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Название продукта</label>
                <input type="text" class="form-control" id="name" name="name" value="<? echo $formData['name'] ?>">
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
                        foreach($categories->getCategories() as $key => $category){
                            if($key == 0){
                                echo '<option selected value="'.((true ? $formData['category']: false) ? $formData['category'] : '').'">'.((true ? $formData['category']: false) ? $categories->getCategoryById($formData['category'])['name'] : 'Выберите категорию').'</option>';
                            }
                           if($categories->getCategoryById($formData['category'])['name'] != $category['name']){
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
                <label for="slug" class="form-label">Код продукта</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<? echo $formData['slug'] ?>">
            </div>
            <? if($formErrors['slug']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['slug'].'</div>';
                } 
            ?>
            <div class="form-floating mb-3 text-dark">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="descr"><? echo $formData['descr'] ?></textarea>
                <label for="floatingTextarea2">Описание продукта</label>
            </div>
            <? if($formErrors['descr']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['descr'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="price" class="form-label">Цена продукта</label>
                <input class="form-control" type="number" name="price" id="price" value="<? echo $formData['price'] ?>">
            </div>
            <? if($formErrors['price']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['price'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Загрузите картинки</label>
                <input class="form-control" type="file" name="imgs[]" id="formFileMultiple" multiple accept=".jpg,.jpeg,.png,.webp">
            </div>
            <? if($formErrors['imgs']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['imgs'].'</div>';
                } 
            ?>
            <button type="submit" name="add_product" class="btn bg-purple text-white">Добавить</button>
        </form>
    </main>
    <?  require_once '../../../layouts/footer.php'; ?>
</body>
</html>