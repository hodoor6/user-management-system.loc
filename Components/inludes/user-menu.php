<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <? if ($user->hasPermissions('admin')) : // admin menu?>
        <a class="navbar-brand" href="users/index.php">User Management</a>
    <? endif; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Главная</a>
            </li>
            <? if ($user->hasPermissions('admin')) : // admin menu?>
                <li class="nav-item">
                    <a class="nav-link" href="users/index.php">Управление пользователями</a>
                </li>
            <? endif ?>
        </ul>

        <ul class="navbar-nav">
            <?php if(!$user->isLoggedIn()) :?>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Войти</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Регистрация</a>
                </li>
            <? else: ?>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link">Профиль</a>
                </li>
                <a href="logout.php" class="nav-link">Выйти</a>
                </li>
            <? endif; ?>
        </ul>
    </div>
</nav>


