<?  require_once './assets/includes/include.php';
    $title = 'Beauty-Lab';
    require_once './assets/views/layouts/head.php'; 
?>
    <main class="container d-flex align-items-center justify-content-center flex-column">
        <img src="/./assets/imgs/logo.png" class="img-fluid w-50  mb-5" alt="лого">
        <p class="purple fs-5 fw-normal">Лаборатория по созданию персональной косметики и парфюма</p>
        <div class="row">
            <div class="col">
                <a class="btn bg-purple text-white btn-lg my-mb" href="./assets/views/public/record.php">Запись онлайн</a>
            </div>
            <div class="col">
                <button type="button" class="btn bg-purple text-white btn-lg" id="gift" data-bs-toggle="modal" data-bs-target="#exampleModal">
                   Подарочный сертификат
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Подарочный сертификат</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur et atque voluptatum, ad rerum est. Repudiandae eum quaerat, aut cum sunt nihil assumenda repellat commodi deleniti, facere illum? Aspernatur laboriosam ipsam molestiae incidunt odio quae delectus nobis ratione, corrupti officiis. Ducimus quos, ipsam ut praesentium nobis earum a beatae provident, suscipit modi, quae iusto voluptas accusamus nostrum? Laboriosam reprehenderit pariatur, quia et expedita voluptates distinctio maiores. Ipsam expedita quia possimus, rerum est ab nesciunt, impedit in natus placeat amet consequuntur omnis aliquid dignissimos fugiat vero dicta assumenda laborum facilis commodi corrupti? Ea molestias sed laboriosam consectetur aliquam eligendi totam repellat!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <? require_once './assets/views/layouts/footer.php'; ?>
</body>
</html>