<?php
function __autoload($class)
{
    $class = strtolower($class);
    if(!defined('_WORKDIR_'))
    {
        exit('Silent is gold');
    }
    require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.$class.'.class.php');
}
?>