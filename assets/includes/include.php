<? 
    require_once __DIR__.'/../../app/User/UserClass.php';
    require_once __DIR__.'../../../app/Redirect/RedirectClass.php';
    require_once __DIR__.'/../../app/Category/CategoryClass.php';
    
    $user = new User;
    $user->authByRememberToken();

    $redirect = new Redirect;

    if($_SESSION['user'] && !$user->getUser($_SESSION['user'])){
        $user->logout(true);
    }

    $formErrors = Cookie::getUnserializeCookie('formErrors');
    if($formErrors){
        Cookie::deleteCookie('formErrors');
    }
   

    if($_SESSION['formData']){
        $formData = $_SESSION['formData'];
        unset($_SESSION['formData']);
    }

?>