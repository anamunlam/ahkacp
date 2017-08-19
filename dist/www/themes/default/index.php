<?php
if(!defined('_WORKDIR_'))
{
    exit;
}

$users_->CheckAuth();
$server_ = new \Server;

require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'header.php');
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'nav.php');
?>
<div class="brc">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li class="active">Home</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div id="page">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo($server_->Hostname()); ?></span>
                        <span class="pull-right"><?php echo($server_->Uptime()); ?></span>
                    </div>
                    <div class="panel-body">
                        <pre><code><?php echo(implode("\n", $server_->RAM())); ?></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');