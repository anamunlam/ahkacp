<?php
if(!defined('_WORKDIR_'))
{
    require_once('../../includes/configs.php');
}
?>

<script src="/themes/<?php echo($helper_->GetConf('theme')); ?>/assets/jquery/jquery-3.2.1.min.js"></script>
<script src="/themes/<?php echo($helper_->GetConf('theme')); ?>/assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<?php
if(isset($custom_footer))
{
    if(is_array($custom_footer))
    {
        echo(implode("\n", $custom_footer));
    }
    else
    {
        echo($custom_footer);
    }
    echo("\n");
}
?>
</body>
</html>