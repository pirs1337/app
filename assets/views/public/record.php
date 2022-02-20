<?  
    require_once '../../includes/include.php';

    Cookie::deleteCookie('records');
    Cookie::deleteCookie('date');
    Cookie::deleteCookie('error');

    $title = 'Запись онлайн';
    require_once '../layouts/head.php';
?>
    <main class="container d-flex align-items-center justify-content-center flex-column">
        <h1 class="purple"><? echo $title ?></h1>
        <? 
            if(!$_SESSION['user']){
                echo '<a href="../unauth/auth/login.php" class="btn bg-purple text-white fs-4">Войдите в аккаунт чтобы записаться</a>';
                echo '</main>';
                require_once '../layouts/footer.php';
            }

            Base::showSuccessMsg();
            Base::showErrorMsg();
        ?>
        <form action="/app/User/AdminClass.php" method="POST" class="bg-purple p-5 border border-3 rounded-3">
            <div class="mb-3 row">
                <label for="date" class="form-label text-white">Дата</label>
                <input type="date" class="form-control" id="date" name="date" value="<? echo $_COOKIE['date'] ?>">
                <button type="submit" name="find_record" class="btn bg-dark text-white btn-lg mt-3">Показать время</button>
            </div>
            <? if($_COOKIE['records']){
                    $records= Cookie::getUnserializeCookie('records');
                    echo '
                        <div class="wrapper-record">
                            <p class="text-white">Выберите время : </p>
                            <div class="row row-cols-auto time">
                        
                      
                    ';

                    foreach ($records as $record){
                        echo '
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="time" id="time" value="'.$record['time'].'">
                                        <label class="form-check-label text-white" for="time">'.$record['time'].'</label>
                                    </div>
                                </div>';
                    }

                    echo '
                            </div>
                        </div>';

                    echo '<button type="submit" name="record" class="btn bg-dark text-white btn-lg mt-3">Записаться</button>';

                }
            ?>
        </form>
    </main>
    <? require_once '../layouts/footer.php' ?>
</body>
</html>
