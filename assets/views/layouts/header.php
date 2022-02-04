<header class="mb-5">
    <nav class="container-fluid d-flex justify-content-between flex-row">
        <div class="menu">
            <svg data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#460b55" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
            <div class="offcanvas bg-purple offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close text-reset bg-light" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/assets/views/public/about.php">О нас</a>
                        </li>
                        <?
                            $category = new Category; 
                            // $categories_with_products = $category->getCategoriesWithProducts();
                            if($category->getCategories()){
                                echo 
                                    '<li class="nav-item">
                                        <a class="nav-link text-white" href="/assets/views/public/catalog.php">Каталог</a>
                                    </li>';
                            }
                        ?>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/assets/views/public/events.php">Мероприятия</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/assets/views/public/contacts.php">Контакты</a>
                        </li>
                        <? 
                            if($_SESSION['user']){
                                if($user->isAdmin()){
                                    echo 
                                        '<li class="nav-item">
                                            <a class="nav-link text-white" href="/assets/views/auth/admin/record/all.php">Все свободные записи</a>
                                        </li>',
                                        '<li class="nav-item">
                                            <a class="nav-link text-white" href="/assets/views/auth/admin/record/add.php">Добавить запись</a>
                                        </li>',
                                        '<li class="nav-item">
                                            <a class="nav-link text-white" href="/assets/views/auth/admin/category/add.php">Добавить категорию</a>
                                        </li>',
                                        '<li class="nav-item">
                                            <a class="nav-link text-white" href="/assets/views/auth/admin/product/add.php">Добавить продукт</a>
                                        </li>';
                                }
                                echo 
                                    '<li class="nav-item">
                                        <a class="nav-link text-white" href="/assets/views/public/record.php">Записаться онлайн</a>
                                    </li>',
                                    '<li class="nav-item">
                                        <a class="nav-link text-white" href="/assets/views/auth/home.php/?id='.$_SESSION['user'].'">Личный кабинет</a>
                                    </li>',
                                    '<li class="nav-item">
                                        <form action="/../../../app/User/UserClass.php">
                                            <button type="submit" name="logout" class="btn bg-dark text-white ms-3 mt-3">Выйти</button>
                                        </form>
                                    </li>';
                            }else{
                                echo 
                                    '<li class="nav-item">
                                        <a class="nav-link text-white" href="/assets/views/unauth/auth/login.php">Войти</a>
                                    </li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <img src="/./assets/imgs/logo.png" class="logo" alt="" srcset="">
    </nav>

</header>