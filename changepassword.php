<?php
require_once 'init.php';
$user = new User;
if (input::exists('post')) {
if (Token::check(Input::get('token'))) {
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
Session::flash('success', ' <div class="alert alert-success">Пароль обновлен</div>');

}else{
    Session::flash('error-current_password', ' <div class="alert alert-danger">Неправильно веден текущий пароль</div>');
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
</head>
<body>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <? if($user->hasPermissions('admin')){?>
          <a class="navbar-brand" href="users/index.php">Admin Management</a>
      <?  } else{ ?>
          <a class="navbar-brand" href="user_profile.php">User Management</a>
      <?  }?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Главная</a>
          </li>
            <? if($user->hasPermissions('admin')){?>
                <li class="nav-item">
                    <a class="nav-link" href="users/index.php">Управление пользователями</a>
                </li>
            <?  }?>
        </ul>

        <ul class="navbar-nav">
          <li class="nav-item">
            <li class="nav-item">
              <a href="profile.php" class="nav-link">Профиль</a>
            </li>
            <a href="logout.php" class="nav-link">Выйти</a>
          </li>
        </ul>
      </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>
                   <?php
           echo Session::flash('error-current_password');
           echo Session::flash('success');
           if($viewErrors != null){?>
               <div class="alert alert-danger">
                   <ul>
                       <?php echo $viewErrors ?>
                   </ul>
               </div>
           <?php }?>
         <ul>
           <li><a href="profile.php">Изменить профиль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="current_password">Текущий пароль</label>
             <input name="current_password" type="text" id="current_password" class="form-control" placeholder="Ведите текущый пароль">
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
                 <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
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