<? 
    require_once '../../includes/include.php';
    $redirect->redirectNotAuth();
    $user->thisUser();
    Base::errorPage($user->getUser());
    $title = $user->getUser()->username;
    $record = new Record;
    require_once '../layouts/head.php'
   
?>
    <main class="container">
        <? if($user->isAdmin()){
            echo 
                '<form class="" method="GET" action="/app/User/AdminClass.php">
                    <input class="form-control  w-75 mb-3" name="users"  type="search" placeholder="Поиск пользователей" aria-label="Search">
                </form>';
        } ?> 
        <h1 class="text-white">Информация о пользователе <? echo $title; if($user->getUser($_SESSION['user'])->admin && $_GET['id'] == $_SESSION['user']) echo ' (Администратор)'?></h1>
        <div class="row text-white flex-column">
            <div class="col fs-5">
                Имя: <? echo $user->getUser()->username ?> 
            </div>
            <div class="col fs-5">
                Моб. телефон: <? echo $user->getUser()->tel ?> 
            </div>
        </div>
        <div class="text-white">
            <? $user_records = $record->getUserRecords(); ?>

            <p class="fs-5">
                <?  $count_user_records = count($user_records);
                    if($_SESSION['user'] == $user->getUser()->id){
                        echo 'Ваши записи: ('.$count_user_records.')';
                    }else{
                       echo 'Записи пользователя: '.$user->getUser()->username.' ('.$count_user_records.')';
                    }
                ?> 
            </p>
            <? 
                Base::showErrorMsg();
                Base::showSuccessMsg();
            ?>
            <div class="row row-cols-auto">
                <?
                    foreach ($user_records as $user_record){
                        $record = new Record;
                        $records = $record->getRecordById($user_record['record_id']);
                            foreach ($records as $record){
                                $record['id'] = $user_record['id'];
                                require '../layouts/record.php';
                            }
                            $arr = [
                                'element' => $record,
                                'msg' => 'Удалить запись',
                                'msg2' => 'Вы уверены что хотите отменить запись на <b>'.$record['date'].' в '.$record['time'].'</b>',
                                'name' => 'record_id',
                                'btn' => 'delete_user_record',
                                'btn_text' => 'Отменить запись'
                            ];
                             
                            require  '../layouts/modals/modal.php';
                        }
                ?>
            </div>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>