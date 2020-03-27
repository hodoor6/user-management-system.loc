<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/init.php');

$user = new User();

if($user->hasPermissions('admin')){
    $users = $user->getAllUsers();
}else{
    Redirect::to(404);
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Management</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">

    <style>
        .alert-message .alert-icon {
            width: 3rem;
        }
        .alert-message .close{
            font-size: 1rem;
            color: #a6a6a6;
        }
        .alert-primary .alert-icon {
            background-color: #b8daff;
        }
        .alert-success .alert-icon {
            background-color: #c3e6cb;
        }

        .alert-danger .alert-icon {
            background-color: #f5c6cb;
        }
    </style>

</head>

<body>
<!--подключение меню пользователя-->
<? require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/inludes/user-menu.php') ?>

<div class="container">
    <div class="col-md-12">
        <h1>Пользователи</h1>

        <? if(Session::exists('danger')): ?>
        <div class="alert alert-danger alert-message d-flex rounded p-0" role="alert">
            <div class="alert-icon d-flex justify-content-center align-items-center flex-grow-0 flex-shrink-0 py-3">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="d-flex align-items-center py-2 px-3">
                <?  echo Session::flash('danger') ?>
            </div>
            <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <? endif;?>
        <? if(Session::exists('success')): ?>
        <div class="alert alert-success alert-message d-flex rounded p-0" role="alert">
            <div class="alert-icon d-flex justify-content-center align-items-center flex-grow-0 flex-shrink-0 py-3">
                <i class="fas fa-check"></i>
            </div>
            <div class="d-flex align-items-center py-2 px-3">
                <?  echo Session::flash('success') ?>
            </div>
            <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <? endif;?>
        <? if(Session::exists('info')): ?>
            <div class="alert alert-primary alert-message d-flex rounded p-0" role="alert">
                <div class="alert-icon d-flex justify-content-center align-items-center flex-grow-0 flex-shrink-0 py-3">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="d-flex align-items-center py-2 px-3">
                  <?  echo Session::flash('info') ?>
                </div>
                <a href="#" class="close d-flex ml-auto justify-content-center align-items-center px-3" data-dismiss="alert">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        <? endif;?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            <? foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td>
                        <? if ($user->group_id == 1) : ?>
                            <a href="<?=Config::get('links.admin.group')?>?role=2&id=<?=$user->id ?>" class="btn btn-success">Назначить администратором</a>
                        <? else : ?>
                            <a href="<?=Config::get('links.admin.group')?>?role=1&id=<?=$user->id ?>" class="btn btn-danger">Разжаловать</a>
                        <? endif; ?>
                        <a href="<?=Config::get('links.user_profile')?>?id=<?= $user->id ?>" class="btn btn-info">Посмотреть</a>
                        <a href="<?=Config::get('links.admin.edit')?>?id=<?= $user->id ?>" class="btn btn-warning">Редактировать</a>
                        <a href="<?=Config::get('links.admin.delete')?>?id=<?= $user->id ?>" class="btn btn-danger"
                           onclick="return confirm('Вы уверены?');">Удалить</a>
                    </td>

                </tr>
            <? endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
