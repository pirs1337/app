<? 
    require_once '../../../../includes/include.php';
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    $title = "Добавить запись";
    require_once '../../../../../assets/views/layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
        <? 
            Base::showSuccessMsg();
            Base::showErrorMsg();
        ?>
        <form class="text-white" action="../../../../../app/User/AdminClass.php" method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Дата</label>
                <input type="date" class="form-control" id="date" name="date" value="<? echo $formData['date'] ?>">
            </div>
            <? if($formErrors['date']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['date'].'</div>';
                } 
            ?>
            <div class="mb-3">
                <label for="time" class="form-label">Время</label>
                <input type="time" class="form-control" id="time" name="time" value="<? echo $formData['time'] ?>">
            </div>
            <? if($formErrors['time']){
                        echo '<div class="alert alert-danger" role="alert">'.$formErrors['time'].'</div>';
                } 
            ?>
             <button type="submit" name="add_record" class="btn bg-purple text-white">Добавить</button>
        </form>
    </main>
    <? require_once '../../../layouts/footer.php'; ?>
</body>
</html>