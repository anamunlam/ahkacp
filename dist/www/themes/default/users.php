<?php
if(!defined('_WORKDIR_'))
{
    header('location:/');
    exit(1);
}

if($_SESSION['userid']!='admin')
{
    header('location:/');
    exit(2);
}

if($helper_->IsPost($_POST, 'act'))
{
    if($_POST['act']=='add')
    {
        if($helper_->IsPost($_POST, array('userid', 'password', 'fname', 'lname', 'email')))
        {
            if($helper_->IsNotEmpty($_POST, array('userid', 'password', 'fname', 'lname', 'email')))
            {
                if($users_->Add($_POST['userid'], $_POST['password'], $_POST['fname'], $_POST['lname'], $_POST['email']))
                {
                    $msg_ = Helper::Alert('success', 'New user added');
                }
                else
                {
                    $msg_ = Helper::Alert('warning', 'Failed to add new user');
                }
            }
        }
    }
}

require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'header.php');
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'nav.php');
?>
<div class="brc">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li class="active">Users</li>
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
                        <span class="panel-title">Users</span>
                        <span class="pull-right">
                            <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modaladd"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Userid</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th colspan="2">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a_users = $users_->Lists();
                                if($a_users)
                                {
                                    for($i=0;$i<count($a_users);$i++)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo($a_users[$i]['userid']) ?></td>
                                            <td><?php echo($a_users[$i]['fname']) ?></td>
                                            <td><?php echo($a_users[$i]['lname']) ?></td>
                                            <td><?php echo($a_users[$i]['contact']) ?></td>
                                            <td>
                                                <button class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-pencil"></span></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modaladd" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-sm">
        <div class="modal-content norad">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New User</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" autocomplete="off" placeholder="UserID" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="First Name" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" class="form-control" autocomplete="off" placeholder="Last Name" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" autocomplete="off" placeholder="Email" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Add</button>
                </div>
                <input type="hidden" name="act" value="add" />
            </form>
        </div>
     </div>
</div>
<?php
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');