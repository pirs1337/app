<?php

echo '<div class="modal fade text-dark" id="exampleModal'.$arr['element']['id'].'" tabindex="-1" aria-labelledby="exampleModalLabel'.$arr['element']['id'].'" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel'.$arr['element']['id'].'">'.$arr['msg'].'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                '.$arr['msg2'].'
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <form action="/app/User/AdminClass.php" method="POST">
                    <input type="hidden" name="'.$arr['name'].'" value="'.$arr['element']['id'].'">
                    <button type="submit" name="'.$arr['btn'].'" class="btn btn-danger">'.$arr['btn_text'].'</button>
                </form>
            </div>
            </div>
        </div>
      </div>';