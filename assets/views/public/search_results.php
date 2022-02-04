<? 
    require_once '../../includes/include.php';
    require_once '../../../app/ImgClass.php';

    if($_SESSION['data']){
        $data = $_SESSION['data'];
        $title = $_GET['q'];
    }else{
        $title = 'По данному запросу ничего не найдено';
    }
    require_once '../layouts/head.php'; 
?>
    <main class="container">
        <h1 class="text-white"><? 
            if($data)
            {
                echo 'Результаты по запросу: '.$title;
            }else {
                  echo  $title;
            } ?>
        </h1>
            <? 
                Base::showSuccessMsg(); 
                Base::showErrorMsg();
            ?>


            <div class="row row-cols-auto">
                <?
                    if($data){
                        foreach($data as $product){
                            require '../layouts/product.php';
                        }
                    }
                ?>
        </div>
    </main>
    <? require_once '../layouts/footer.php'; ?>
</body>
</html>