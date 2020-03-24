<?php
require_once 'init.php';
$user = new User;
if (input::exists('post')) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, [
            'name' => ['required' => true, 'min' => 3, 'max' => 15],
            'status' => ['min' => '5'],
        ]);
        if ($validate->passed()) {
//обновление пользователя
            $update = $user->update(['name' => Input::get('name'), 'status' => Input::get('status')]);

            Session::flash('success', '<div class="alert alert-success">Профиль обновлен</div>');
        } else {
            $viewError = [];
            foreach ($validate->errors() as $error) {
                $viewError[] = '<li>' . $error . '</li>';
            }
            $viewErrors = implode($viewError);
        }
    }
}
$user = new User;
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

<!--подключение меню пользователя-->
<? require_once 'Components/inludes/user-menu.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Профиль пользователя - <?php echo $user->data()->name ?></h1>

            <?php echo Session::flash('success');
            if ($viewErrors != null) {
                ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php echo $viewErrors ?>
                    </ul>
                </div>
            <?php } ?>
            <ul>
                <li><a href="changepassword.php">Изменить пароль</a></li>
            </ul>
            <form action="" class="form" method="post">
                <div class="form-group">
                    <label for="username">Имя</label>
                    <input name="name" type="text" id="username" class="form-control"
                           value="<?php echo $user->data()->name ?>">
                </div>
                <div class="form-group">
                    <label for="status">Статус</label>
                    <input name="status" type="text" id="status" class="form-control"
                           value="<?php echo $user->data()->status ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="token" value="<?php echo Token::generate() ?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-warning">Обновить</button>
                </div>
            </form>


        </div>
    </div>
</div>
</body>
</html>