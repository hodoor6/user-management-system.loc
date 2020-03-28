<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/init.php');

//проверка при отправке формы
if(Input::exists('get') && Input::get('id') && $user->hasPermissions('admin') ){
$userDelete= new User(Input::get('id'));

// проверка на несуществующего пользователя в бд
    if(empty($userDelete->data())){
        Session::flash('danger','Упс что-то пошло не так, не удалось найти пользователя, так как данный пользователь не существует');
        Redirect::to(Config::get('links.admin.index'));
        exit();
    }
// проверка на чтобы себя администратор не удалил
    if($userDelete->data()->id == $user->data()->id){
 Session::flash('info','Себя удалить нельзя, Вас может удалить только другой Администратор');
       Redirect::to(Config::get('links.admin.index'));
        exit();
    }


    //удаление пользователя
    if($userDelete->data()->id == Input::get('id') && !empty(Input::get('id'))){
        $name = $userDelete->data()->name;
        $user->delete($userDelete->data()->id);
        Session::flash('success',"Пользователь {$name}, успешно удален");
        Redirect::to(Config::get('links.admin.index'));
        exit();
    }
}else{
    redirect::to('404');
  exit();
}