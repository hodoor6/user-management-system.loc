<?php

require_once'init.php';

$user = new User;

$users = $user->getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Главная страница</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="/css/alert.css" rel="stylesheet">
</head>
<body>


<!--подключение меню пользователя-->
<? require_once 'Components/inludes/user-menu.php' ?>
<div class="container">
<? if(!$user->isLoggedIn()) : ?>

    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4">Привет, мир!</h1>
          <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
          <hr class="my-4">
          <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
          <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
        </div>
      </div>
    </div>
      <? endif ?>
    <div class="row">
      <div class="col-md-12">
        <h1>Пользователи</h1>
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
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Дата</th>
            </tr>
          </thead>

          <tbody>
          <? foreach ($users as $user):  ?>
          <tr>
              <td><?=$user->id?></td>
              <td><a href="<?=Config::get('links.user_profile')?>?id=<?=$user->id?>"><?=$user->name?></a></td>
              <td><?=$user->email?></td>
              <td><?=$user->date?></td>
            </tr>
          <?   endforeach; ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>