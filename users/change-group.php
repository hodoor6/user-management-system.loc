<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/init.php');

$user = new User;

if (Input::exists('get') && Input::get('id') && Input::get('role') && $user->hasPermissions('admin')) {
    $updateGroup= new User(Input::get('id'));
    //проверка если пользователь Input::get('id') существует
    if (empty($updateGroup->data())) {
        Session::flash('danger', 'Упс что-то пошло не так, не удалось найти пользователя, так как данный пользователь не существует');
        Redirect::to(Config::get('links.admin.index'));
        exit();
    }



 // проверка на то чтобы администратор не перевел себя в группу пользователи
    if ($updateGroup->data()->group_id == $user->data()->group_id && $updateGroup->data()->id == $user->data()->id) {
        Session::flash('info', 'Если вы поменяете себе группу на пользователи то вы потеряете доступ в админ панель, Вас может разжаловать только другой Администратор');
        Redirect::to(Config::get('links.admin.index'));
        exit();
    }

// обновление роли пользователя если она существует
            $db = DataBase::getInstance();
            if($db->get('groups',['id','=',Input::get('role')])->count()){
                $nameGroup = $db->first()->name;
                $name = $updateGroup->data()->name;
                $user->update(['group_id'=>Input::get('role')], $updateGroup->data()->id);
                Session::flash('success', "Пользователь {$name}, переведен в группу {$nameGroup}");
                Redirect::to(Config::get('links.admin.index'));
                exit();
            }
//если переданая роль не существует в бд перенаправляем администратора на главную страницу админки
        Session::flash('danger', 'Что-то пошло не так. Группы с такой ролью не существует.');
        Redirect::to(Config::get('links.admin.index'));
        exit();

} else {
    redirect::to('404');
    exit();
}
