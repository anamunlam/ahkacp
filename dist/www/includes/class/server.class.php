<?php
Class Server
{
    public function Uptime()
    {
        global $helper_;
        $fh = fopen('/proc/uptime', 'r');
        $uptime = fgets($fh);
        fclose($fh);
        $uptime = explode('.', $uptime, 2);
        return $helper_->sec2human($uptime[0]);
    }
    
    public function RAM()
    {
        $return = array();
        exec('sudo free', $output, $return_var);
        return $output;
    }
    
    public function Hostname()
    {
        exec('sudo hostname -f', $output);
        if($output)
        {
            return $output[0];
        }
        return '';
    }
}
?>