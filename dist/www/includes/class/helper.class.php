<?php
class Helper
{
    private $conf = array();
    
    /**
     * Set config from config file
     * @return none
     */
    public function GenConf()
    {
        if(!defined('_WORKDIR_'))
        {
            exit('Silent is gold');
        }
        require_once(_WORKDIR_.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'configs.php');
        $this->conf = $configs;
        $this->conf['title'] = $configs['name'].' - '.$configs['desc'];
    }
    
    /**
     * Set config
     * @return none
     */
    public function SetConf($key, $val)
    {
        $this->conf[$key] = trim($val);
    }
    
    /**
     * Get config from config file
     * @return value of array
     */
    public function GetConf($key)
    {
        return isset($this->conf[$key])?$this->conf[$key]:false;
    }
    
    /**
     * Create notification alert using bootstrap
     * @return string
     */
    public function Alert($type, $message, $dismisable=true, $norad=false)
    {
        if($dismisable)
        {
            $return = '<div class="alert alert-'.$type.' alert-dismissible'.($norad!==false?' norad':'').'" role="alert">';
            $return .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $return .= $message;
            $return .= '</div>';
        }
        else
        {
            $return = '<div class="alert alert-'.$type.($norad!==false?' norad':'').'" role="alert">'.$message.'</div>';
        }
        return $return;
    }
    
    public function pagination($left=1, $right=1, $last=1, $active=1, $href)
    {
        global $url;
        $return = '<ul class="pagination">';
        $return .= '<li class="previous"><a href="'.$href.'/page/1" aria-label="First page" rel="tooltip" title="First page">&laquo;</a></li>'."\r\n";
        for($left;$left<=$right;$left++)
        {
            if($active==$left)
            {
                $return .= '<li class="active"><a href="#" aria-label="Page '.$left.'" rel="tooltip" title="Page '.$left.'">'.$left.'</a></li>'."\r\n";
            }
            else
            {
                $return .= '<li><a href="'.$href.'/page/'.$left.'" aria-label="Page '.$left.'" rel="tooltip" title="Page '.$left.'">'.$left.'</a></li>'."\r\n";
            }
        }
        $return .= '<li class="next"><a href="'.$href.'/page/'.$last.'" aria-label="Last page" rel="tooltip" title="Last page"><span aria-hidden="true">&raquo;</span></a></li>'."\r\n";
        $return .= '</ul>';
        return $return;
    }
    
    public function Sec2Human($time)
    {
        $seconds = $time%60;
        $mins = floor($time/60)%60;
        $hours = floor($time/60/60)%24;
        $days = floor($time/60/60/24);
        return $days > 0 ? $days . ' day'.($days > 1 ? 's' : '') : $hours.':'.$mins.':'.$seconds;
    }
    
    public function IsPost($data=array(), $check)
    {
        $return = true;
        if(is_array($check))
        {
            foreach($check as $val)
            {
                if(!isset($data[$val]))
                {
                    $return = false;
                }
            }
        }
        else
        {
            if(!isset($data[$check]))
            {
                $return = false;
            }
        }
        return $return;
    }
    
    public function IsNotEmpty($data=array(), $check)
    {
        $return = true;
        if(is_array($check))
        {
            foreach($check as $val)
            {
                if($data[$val]=='')
                {
                    $return = false;
                }
            }
        }
        else
        {
            if($data[$check]=='')
            {
                $return = false;
            }
        }
        return $return;
    }
    
    /**
     * Generate alphanumeric random string
     * @return string
     */
    public function RandomString($length=10)
    {
        $str = 'qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM';
        while($length>strlen($str))
        {
            $str = $str.$str;
        }
        return substr(str_shuffle($str),0,$length);
    }
}
?>