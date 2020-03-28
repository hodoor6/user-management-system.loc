<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?=Config::get('links.home')?>">User Management</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?=Config::get('links.home')?>">Главная</a>
            </li>
            <? if ($user->hasPermissions('admin')) : // admin menu?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=Config::get('links.admin.index')?>">Управление пользователями</a>
                </li>
            <? endif ?>
        </ul>

        <ul class="navbar-nav">

            <?php if($user->isLoggedIn()) :?>


                <li class="nav-item">
                    <a href="<?=Config::get('links.profile')?>" class="nav-link">Имя - <?=$user->data()->name?></a>
                </li>   <li class="nav-item">
                    <a href="<?=Config::get('links.profile')?>" class="nav-link">Профиль</a>

                </li>
                <a href="<?=Config::get('links.logout')?>" class="nav-link">Выйти</a>
                </li>
                      <? else: ?>
                <li class="nav-item">
                    <a href="<?=Config::get('links.login')?>" class="nav-link">Войти</a>
                </li>
                <li class="nav-item">
                    <a href="<?=Config::get('links.register')?>" class="nav-link">Регистрация</a>
                </li>
            <? endif; ?>
        </ul>
    </div>
</nav>


