<?php

echo '<div class="col text-white mb-4">
        <div class="card bg-purple" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Дата: <span>'.$record['date'].'<span></h5>
                <h5 class="card-title">Время: <span>'.$record['time'].'<span></h5>
                <button type="button" class="btn btn-danger text-white mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal'.$record['id'].'">
                    Удалить запись
                </button>
            </div>
        </div>
      </div>';


    