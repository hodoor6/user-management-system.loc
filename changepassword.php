<?php
require_once 'init.php';

if (input::exists('post')) {
if (Token::check(Input::get(Config::get('form.field_token')))) {
$validate = new Validate();
$validate->check($_POST, [
'current_password' => ['required' => true, 'min' => 6],
'new_password' => ['required' => true, 'min' => 6],
'new_password_again' => ['required' => true, 'min' => 6, 'matches'=>'new_password'],

]);
if ($validate->passed()) {
// проверка на совпадение пароля с текущим
if($user->checkPassword(Input::get('current_password'))){
// обновление  пароля пользователя
$update = $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
Session::flash('success', 'Пароль успешно обновлен');
Redirect::to(Config::get('links.change_password'));
exit();
}else{
    Session::flash('info', 'Неправильно веден текущий пароль');
    Redirect::to(Config::get('links.change_password'));
    exit();
}
} else {
    $viewError=[];
    foreach ($validate->errors() as $error) {
        $viewError[] ='<li>'.$error.'</li>';
    }
    $viewErrors = implode($viewError);

}
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
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
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>

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
        <? if($viewErrors != null){?>
               <div class="alert alert-danger">
                   <ul>
                       <?php echo $viewErrors ?>
                   </ul>
               </div>
           <?php }?>
         <ul>
           <li><a href="<?=Config::get('links.profile')?>">Изменить профиль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="current_password">Текущий пароль</label>
             <input name="current_password" type="text" id="current_password" class="form-control" placeholder="Ведите текущий пароль">
           </div>
           <div class="form-group">
             <label for="new_password">Новый пароль</label>
             <input name="new_password"type="text" id="new_password" class="form-control" placeholder="Ведите новый пароль">
           </div>
           <div class="form-group">
             <label for="new_password_again">Повторите новый пароль</label>
             <input name="new_password_again"type="text" id="current_password" class="form-control" placeholder="Повторите новый пароль">
           </div>
             <div class="form-group">
                 <input type="hidden" class="form-control" name="<?= Config::get('form.field_token') ?>" value="<?php echo Token::generate() ?>">
             </div>
           <div class="form-group">
             <button class="btn btn-warning">Изменить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>