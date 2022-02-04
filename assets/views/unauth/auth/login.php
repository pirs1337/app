<?  
    require_once '../../../includes/include.php';
    $redirect->redirectToHome();
    $title = 'Вход';
    require_once '../../layouts/head.php';
?>
    <main class="container d-flex align-items-center justify-content-center flex-column">
        <h1 class="purple"><? echo $title ?></h1>

        <? 
            Base::showErrorMsg();
        ?>    

        <form action="../../../../app/User/UserClass.php" method="POST" class="w-50 bg-purple p-5 border border-3 rounded-3">
        <? require_once '../../layouts/form.php' ?>
            <div class="form-check mb-2">
                <input class="form-check-input bg-dark" type="checkbox" name="remember" id="flexCheckChecked" checked>
                    <label class="form-check-label text-white" for="flexCheckChecked">
                        Запомнить меня
                    </label>
            </div>
            <button type="submit" name="auth" class="btn bg-dark text-white btn-lg">Войти</button>
            <a class="pink" href="./register.php">Нет аккаунта?</a>
        </form>
    </main>
    <? require_once '../../layouts/footer.php'; ?>
</body>
</html>
