<?php
if(!defined('_WORKDIR_'))
{
    header('location:/');
    exit(1);
}

if(isset($_SESSION['true_userid']))
{
    $_SESSION['userid'] = $_SESSION['true_userid'];
    unset($_SESSION['true_userid']);
    header('location:/');
    exit(0);
}
else
{
    session_destroy();
    header('location:/login');
}
?>