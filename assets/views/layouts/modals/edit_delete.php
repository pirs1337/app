<?php
    if($user->isAdmin()){
        echo 
            '<div class="row mb-3 px-2">
                <div class="col d-flex">
                    <a href="/assets/views/auth'.$arr['path_edit'].'='.$arr['element']['slug'].'" class="btn btn-primary">Редактировать</a>
                </div>
                <div class="col d-flex justify-content-end">
                    <form method="POST" action="/app/User/AdminClass.php">
                        <input type="hidden" value="'.$arr['element']['id'].'">
                        <button type="button" class="btn btn-danger" name="'.$arr['btn'].'" data-bs-toggle="modal" data-bs-target="#exampleModal'.$arr['element']['id'].'">Удалить</button>
                    </form>
                </div>
            </div>';
            require __DIR__.'/./modal.php';       
    }