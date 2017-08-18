<?php
if(!defined('_WORKDIR_'))
{
    exit;
}

if($users_->CheckAuth(false))
{
    header('location:/');
    exit;
}

if(isset($_POST['userid']) and isset($_POST['password']))
{
    $msg_ = $users_->Login($_POST['userid'],$_POST['password']);
    if($msg_===true)
    {
        header('location:/');
        exit;
    }
}

$custom_header = '<style>html,body{height:100%;margin:0;padding:0;background-color: #3498DB;}</style>';
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'header.php');
?>
<div class="container-login">
    <div class="row-login">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="login-form">
                <form method="post">
                    <h2><i class="glyphicon glyphicon-user"></i> Login</h2>
                    <?php
                    if(isset($msg_))
                    {
                        echo($helper_->Alert('warning', $msg_));
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control login-field" placeholder="Userid" name="userid" type="text" autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control login-field" placeholder="Password" name="password" type="password"/>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');