<?php
if(!defined('_WORKDIR_'))
{
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="/themes/<?php echo($helper_->GetConf('theme')); ?>/assets/images/favicon.ico" />
    <title id="title"><?php echo($helper_->GetConf('title')); ?></title>
    <link href="/themes/<?php echo($helper_->GetConf('theme')); ?>/assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/themes/<?php echo($helper_->GetConf('theme')); ?>/assets/css/style.css" rel="stylesheet"/>
    <?php
    if(isset($custom_header))
    {
        if(is_array($custom_header))
        {
            echo(implode("\n", $custom_header));
        }
        else
        {
            echo($custom_header);
        }
    }
    ?>
</head>
<body>