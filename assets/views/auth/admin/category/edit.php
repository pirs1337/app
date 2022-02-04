<? 
    require_once '../../../../includes/include.php';
    require_once '../../../../../app/ImgClass.php'; 
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    
    $category = new Category;
    $category = $category->getCategoryBySlug();
    $title = 'Редактировать категорию '.$category->name.'';
    require_once '../../../../../assets/views/layouts/head.php';
    $category = $category->getCategoryBySlug();
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
                <input type="text" class="form-control" id="name" name="name" value="<? echo $category->name ?>">
            </div>
            <? if($formErrors['name']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['name'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="slug" class="form-label">Код</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<? echo $category->slug ?>">
            </div>
            <? if($formErrors['slug']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['slug'].'</div>';
                    } 
            ?>
            <div class="mb-3">
                <label for="img" class="form-label">Картинка</label>
                <div>
                    <img src="<? echo Img::DIR['categories'].$category->img ?>" class="w-25" alt="">
                    <input class="form-control mt-3" name="img" type="file" id="img" accept=".jpg,.jpeg,.png,.webp">
                </div>
            </div>
            <input type="hidden" name="category" value="<? echo $category->id ?>">
            <? if($formErrors['img']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['img'].'</div>';
                    } 
            ?>
            <button type="submit" name="edit_category" class="btn bg-purple text-white">Сохранить</button>
        </form>
    </main>
    <?  require_once '../../../layouts/footer.php'; ?>
</body>
</html>   