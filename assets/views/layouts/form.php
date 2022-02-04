<? 
  echo 
    '<div class="mb-2">
        <label for="username" class="form-label text-white fs-6 fw-normal">Имя пользователя</label>
        <input type="text" class="form-control fs-6 fw-normal" name="username" id="username" value="'.$formData['username'].'">
    </div>';
    if(isset($formErrors['username'])){
      echo '<div class="alert alert-danger" role="alert">'.$formErrors['username'].'</div>';
    } 

  echo 
    '<div class="mb-2">
      <label for="tel" class="form-label text-white fs-6 fw-normal">Мобильный номер</label>
      <input type="text" class="form-control fs-6 fw-normal" name="tel" id="tel" value="'.$formData['tel'].'">
    </div>';
    if(isset($formErrors['tel'])){
      echo '<div class="alert alert-danger" role="alert">'.$formErrors['tel'].'</div>';
    }
?> 