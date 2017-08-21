<?php
if(!defined('_WORKDIR_'))
{
    header('location:/');
    exit;
}

$users_->CheckAuth();

if($helper_->IsPost($_POST, array('old_password', 'new_password', 'con_password')))
{
    if($helper_->IsNotEmpty($_POST, array('old_password', 'new_password', 'con_password')))
    {
        if($users_->ChangePass($_POST['old_password'], $_POST['new_password'], $_POST['con_password']))
        {
            $msg_ = Helper::Alert('success', 'Password changed');
        }
        else
        {
            $msg_ = Helper::Alert('warning', 'Failed to change password');
        }
    }
    else
    {
        $msg_ = Helper::Alert('warning', 'All field must not empty');
    }
}

require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'header.php');
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'nav.php');
?>
<div class="brc">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li class="active">Password</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div id="page">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php
                if(isset($msg_))
                {
                    echo($msg_);
                }
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span class="panel-title">Change Password</span>
                    </div>
                    <div class="panel-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" name="old_password" class="form-control" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="con_password">Confirm Password</label>
                                <input type="password" name="con_password" class="form-control" autocomplete="off" />
                            </div>
                            <span class="pull-right">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?');">Save</button>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');