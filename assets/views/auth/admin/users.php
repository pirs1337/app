<? 
    require_once '../../../includes/include.php'; 
    $redirect->redirectNotAuth();
    $title = 'Пользователи';
    require_once '../../layouts/head.php';
?>
    <main class="container mt-5 text-white">
            <? 
            if(!$_SESSION['users']){
                echo 'Нет результатов по данному запросу';
            }else{
                echo 'Найденные результаты: ';
                echo '<div class="row mt-5 row-cols-auto">';
                    foreach($_SESSION['users'] as $user){
                        echo 
                            '<div class="col mb-4">
                                <div class="card bg-purple" style="width: 18rem;">
                                    <a class="text-white" href="/assets/views/auth/home.php/?id='.$user['id'].'">
                                        <div class="card-body">
                                            <h5 class="card-title">'.$user['username'].'</h5>
                                            <p class="card-text">'.$user['tel'].'</p>
                                        </div>
                                    </a>
                                </div>
                            </div>';
                    } 
                echo '</div>';
            }
             ?>
    </main>
    <? require_once '../../layouts/footer.php'; ?>
</body>
</html>