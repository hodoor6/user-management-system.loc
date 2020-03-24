<?php
require_once 'init.php';

$validate = new Validate();
 $validate->check($_POST, [
    'name' => [
        'required' => true,
        'min' => '3',
        'max' => '15',
        'uniqie' => 'users'
    ],
    'email' => [
        'required' => true,
        'email' => true,
        'uniqie' => 'users'
    ],
    'password' => [
        'required' => true,
        'min' => '5',
    ],
    'password_again' => [
        'required' => true,
        'matches' => 'password',
    ],

    'rules'=>[
        'required' => true,

    ],

]);
if (Input::exists('post')) {
if (Token::check(Input::get('token'))) {
if ($validate->passed()) {
// создание пользователя  и хеширование пароля
    $user = new User;
    $user->create([
        'name' => Input::get('name'),
        'password' => password_hash(Input::get('name'), PASSWORD_DEFAULT),
        'email' => Input::get('email'),
        'date' => date("d/m/Y"),

    ]);
    Session::flash('success', 'register success');

//перенаправляет страницу
    Redirect::to('/index.php');


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
   <? require_once 'Components/inludes/header.php';?>
<!--подключение меню пользователя-->
<? require_once 'Components/inludes/user-menu.php' ?>

    <form class="form-signin" action="" method="post">
        <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

        <?php if($viewErrors != null){?>
        <div class="alert alert-danger">
            <ul>
              <?php echo $viewErrors ?>
            </ul>
            </div>
        <?php }?>
          	  <div class="form-group">
          <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
          <input name="name" type="text" class="form-control" id="name" placeholder="Ваше имя" value="<?php echo Input::get('name') ?>">
        </div>
        <div class="form-group">
          <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
        </div>
        
        <div class="form-group">
          <input name="password_again" type="password" class="form-control" id="password_again" placeholder="Повторите пароль">
        </div>
        <div class="form-group">
            <input name="token" type="hidden" class="form-control" value="<?php echo Token::generate() ?>">
        </div>
    	  <div class="checkbox mb-3">
    	    <label>
    	      <input  name="rules" type="checkbox" > Согласен со всеми правилами
    	    </label>
    	  </div>
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
