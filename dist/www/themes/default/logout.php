<?php
if(!defined('_WORKDIR_'))
{
    exit;
}

session_destroy();
header('location:/login');
?>