<?php
session_start();
define('_WORKDIR_', dirname(__FILE__));
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'autoload.php');
$users_ = new \Users;
$helper_ = new \Helper;
$helper_->GenConf();
$route_ = new \Route;
$view_ = $route_->GetView(0);
$pview_ = _WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'index.php';
if($view_)
{
    if(file_exists(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.$view_.'.php'))
    {
        $pview_ = _WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.$view_.'.php';
    }
}
require_once($pview_);
?>