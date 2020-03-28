<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Config.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/config/dbconfig.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/DataBase.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Validate.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Input.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Token.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Session.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Redirect.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/Components/Cookie.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/app/model/Model.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/app/controller/User.php');


if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))){
    $hash =Cookie::get(Config::get('cookie.cookie_name'));
$hashCheck = DataBase::getInstance()->get('user_sessions',['hash','=',$hash]);

if($hashCheck->count())
{
    $user = new User($hashCheck->first()->user_id);
    $user->login();

}
}
$user= new User;