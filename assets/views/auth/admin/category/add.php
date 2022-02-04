<? 
    require_once '../../../../includes/include.php'; 
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    $title = "Добавить категорию";
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
                <label for="name" class="form-label">Название категории</label>
                <input type="text" class="form-control" id="name" name="name" value="<? echo $formData['name'] ?>">
            </div>
            <? if($formErrors['name']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['name'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="slug" class="form-label">Код категории</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<? echo $formData['slug'] ?>">
            </div>
            <? if($formErrors['slug']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['slug'].'</div>';
                    } 
            ?>
            <div class="mb-3">
                <label for="img" class="form-label">Картинка категории</label>
                <input class="form-control" name="img" type="file" id="img" accept=".jpg,.jpeg,.png,.webp">
            </div>
            <? if($formErrors['img']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['img'].'</div>';
                    } 
            ?>
            <button type="submit" name="add_category" class="btn bg-purple text-white">Добавить</button>
        </form>
    </main>
    <?  require_once '../../../layouts/footer.php'; ?>
</body>
</html>