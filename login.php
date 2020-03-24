<?php
require_once 'init.php';
if (input::exists('post')) {
    if (Token::check(Input::get('token'))) {
//проверка на существование чекбокса
        $remember = Input::get('remember') === 'on' ? true : false;
        //валидация
        $validate = new Validate();
        $validate->check($_POST, [
            'email' => ['required' => true, 'email' => 'email'],
            'password' => ['required' => true]
        ]);
        if ($validate->passed()) {
//авторизация пользователя
            $user = new User;
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);
            $errorMassage = '';
            if ($login) {
                Session::flash('success', '<div class="alert alert-success">logged in successfully</div>');
                Redirect::to('/profile.php');
            } else {
                $errorMassage = 'Логин или пароль неверны';
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

<?php require_once 'Components/inludes/header.php'; ?>
  <body class="text-center">
    <form class="form-signin" action="" method="post">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
        <?php if($viewErrors != null){?>
            <div class="alert alert-danger">
                <ul>
                    <?php echo $viewErrors ?>
                </ul>
            </div>
        <?php }?>
        <?php if(!empty($errorMassage)){?>
        <div class="alert alert-info">
            <?php echo $errorMassage ?>
        </div>
        <?php }?>
    	  <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="remember"> Запомнить меня
    	    </label>
    	  </div>
        <div class="form-group">
            <input name="token" type="hidden" class="form-control" value="<?php echo Token::generate() ?>">
        </div>
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
