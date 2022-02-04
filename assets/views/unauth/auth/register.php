<?  
    
    require_once '../../../includes/include.php'; 
    $redirect->redirectToHome();
    $title = 'Регистрация';
    require_once '../../layouts/head.php';
?>
    <main class="container d-flex align-items-center justify-content-center flex-column">
        <h1 class="purple"><? echo $title ?></h1>

        <? 
            Base::showErrorMsg(); 
        ?> 

        <form action="../../../../app/User/UserClass.php" method="POST" class="w-50 bg-purple p-5 border border-3 rounded-3">
            <? require_once '../../layouts/form.php' ?>
            <div class="fs-small">
                <span class="text-white">Нажимая «Зарегистрироваться», вы даете свое согласие на обработку персональных данных</a>
            </div>
            <button type="submit" name="register" class="btn bg-dark text-white btn-lg mt-3">Зарегистрироваться</button>
        </form>
    </main>
    <? require_once '../../layouts/footer.php'; ?>
</body>
</html>
