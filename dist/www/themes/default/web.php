<?php
if(!defined('_WORKDIR_'))
{
    header('location:/');
    exit(1);
}

$users_->CheckAuth();

$web_ = new \Web;

if($helper_->IsPost($_POST, 'act'))
{
    if($_POST['act']=='add')
    {
        if($helper_->IsPost($_POST, array('domain', 'alias', 'tpl')))
        {
            if($helper_->IsNotEmpty($_POST, array('domain', 'tpl')))
            {
                $ret_ = $web_->Add($_POST['domain'], $_POST['alias'], $_POST['tpl']);
                if($ret_['status']===true)
                {
                    $msg_ = Helper::Alert('success', $ret_['msg']);
                }
                else
                {
                    $msg_ = Helper::Alert('warning', $ret_['msg']);
                }
            }
        }
    }
    if($_POST['act']=='edit')
    {
        if($helper_->IsPost($_POST, array('domain', 'alias', 'tpl')))
        {
            if($helper_->IsNotEmpty($_POST, array('domain', 'tpl')))
            {
                $ret_ = $web_->Edit($_POST['domain'], $_POST['alias'], $_POST['tpl']);
                if($ret_['status']===true)
                {
                    $msg_ = Helper::Alert('success', $ret_['msg']);
                }
                else
                {
                    $msg_ = Helper::Alert('warning', $ret_['msg']);
                }
            }
        }
    }
    else if($_POST['act']=='delete')
    {
        if($helper_->IsPost($_POST, array('domain')))
        {
            if($helper_->IsNotEmpty($_POST, array('domain')))
            {
                $ret_ = $web_->Delete($_POST['domain']);
                if($ret_['status']===true)
                {
                    $msg_ = Helper::Alert('success', $ret_['msg']);
                }
                else
                {
                    $msg_ = Helper::Alert('warning', $ret_['msg']);
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
                <li class="active">Web</li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div id="page">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php
                if(isset($msg_))
                {
                    echo($msg_);
                }
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span class="panel-title">Web</span>
                        <span class="pull-right">
                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#modaladd" title="Add new web"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                    </div>
                    <?php
                    $a_web = $web_->Lists();
                    if($a_web)
                    {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>Alias</th>
                                        <th colspan="2">Template</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($a_web as $domain => $val)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo($domain); ?></td>
                                            <td><?php echo(str_replace(',', ', ', $val['ALIAS'])); ?></td>
                                            <td><?php echo($val['TPL']); ?></td>
                                            <td class="pull-right nowrap">
                                                <button class="btn btn-xs btn-warning web-edit" title="Edit this web" data-domain="<?php echo($domain); ?>" data-alias="<?php echo($val['ALIAS']); ?>" data-tpl="<?php echo($val['TPL']); ?>"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button class="btn btn-xs btn-danger web-delete" title="Delete web" data-domain="<?php echo($domain); ?>"><span class="glyphicon glyphicon-trash"></span></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    else
                    {
                        echo('<div class="panel-body">'.$helper_->Alert('info', 'Nothing found').'</div>');
                    }
                    ?>
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
                    <h4 class="modal-title">Add New Web</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="domain">Domain</label>
                        <input type="text" name="domain" class="form-control" autocomplete="off" placeholder="Domain" />
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias</label>
                        <textarea class="form-control" name="alias" placeholder="One line per alias"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tpl">Template</label>
                        <select name="tpl" class="form-control">
                            <?php
                            $tpl_ = $web_->ListTemplate();
                            foreach($tpl_ as $tpl)
                            {
                                ?>
                                <option value="<?php echo($tpl); ?>"><?php echo($tpl); ?></option>
                                <?php
                            }
                            ?>
                        </select>
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
<div id="modaledit" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-sm">
        <div class="modal-content norad">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Web</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="domain">Domain</label>
                        <input type="text" id="domain" class="form-control" readonly="yes" />
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias</label>
                        <textarea class="form-control" name="alias" id="alias" placeholder="One line per alias"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tpl">Template</label>
                        <select name="tpl" id="tpl" class="form-control">
                            <?php
                            $tpl_ = $web_->ListTemplate();
                            foreach($tpl_ as $tpl)
                            {
                                ?>
                                <option value="<?php echo($tpl); ?>"><?php echo($tpl); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Add</button>
                </div>
                <input type="hidden" name="domain" id="domain" />
                <input type="hidden" name="act" value="edit" />
            </form>
        </div>
     </div>
</div>
<div id="modaldelete" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-sm">
        <div class="modal-content norad">
            <form method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirm</h4>
                </div>
                <div class="modal-body">
                    Are you sure want to delete web <strong id="domainb"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-warning">Yes</button>
                </div>
                <input type="hidden" name="domain" id="domain" />
                <input type="hidden" name="act" value="delete" />
            </form>
        </div>
     </div>
</div>
<?php
$custom_footer[] = '<script type="text/javascript" src="/themes/'.$helper_->GetConf('theme').'/assets/js/javascript.js"></script>';
require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$helper_->GetConf('theme').DIRECTORY_SEPARATOR.'footer.php');