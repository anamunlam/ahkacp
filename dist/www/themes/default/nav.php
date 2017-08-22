<?php
if(!defined('_WORKDIR_'))
{
    exit;
}
?>
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="/"><?php echo($helper_->GetConf('name')); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/domain" title="Domain">Domain</a></li>
                <?php
                if($_SESSION['userid']=='admin')
                {
                    ?>
                    <li><a href="/users" title="Users">Users</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Server <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/server-status" title="Status">Status</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo($_SESSION['userid']); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/password">Password</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout"><?php echo(isset($_SESSION['true_userid'])?'Logout As':'Logout'); ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>