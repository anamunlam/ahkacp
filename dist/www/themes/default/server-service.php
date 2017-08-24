<?php
if(!defined('_WORKDIR_'))
{
    header('location:/');
    exit(1);
}

$users_->CheckAuth();

if($_SESSION['userid']!='admin')
{
    header('location:/');
    exit(2);
}

$server_ = new \Server;

require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'header.php');
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'nav.php');
?>
<div class="brc">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li class="active">Service</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div id="page">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span class="panel-title">Service</span>
                    </div>
                    <div class="panel-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');