<? 
    require_once '../../../../includes/include.php'; 
    require_once '../../../../../app/Record/RecordClass.php';
    $redirect->redirectNotAuth();
    $user->isAdmin(true);
    $record = new Record;
    $title = "Все свободные записи";
    require_once '../../../../../assets/views/layouts/head.php'; 
?> 
    <main class="container">
        <h1 class="text-white"><? echo $title ?></h1>
        <? 
            Base::showErrorMsg(); 
            Base::showSuccessMsg();
        ?>
            <div class="row row-cols-auto text-white">
                <? 
                    $records = $record->getUnbusyRecords();
                    if(count($records) < 1){
                        echo '<p>Нет свободных записей</p>';
                    }
                    foreach ($records as $record){
                        require '../../../layouts/record.php';
                        $arr = [
                            'element' => $record,
                            'msg' => 'Удалить запись',
                            'msg2' => 'Вы уверены что хотите отменить запись на <b>'.$record['date'].' в '.$record['time'].'</b>',
                            'name' => 'record_id',
                            'btn' => 'delete_record',
                            'btn_text' => 'Удалить' 
                        ];
                        require '../../../layouts/modals/modal.php';
                    }
                    
                ?>
            </div>
    </main>
    <? require_once '../../../layouts/footer.php'; ?>
</body>
</html>