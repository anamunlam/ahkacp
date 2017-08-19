<?php
class Users
{
    public function CheckAuth($redirect=True)
    {
        global $helper_;
        $return = false;
        if(isset($_SESSION['userid']))
        {
            $return = true;
        }
        else
        {
            if($redirect)
            {
                header('location:/login');
                exit;
            }
        }
        
        return $return;
    }
    
    public function Login($userid, $password)
    {
        $return = 'Failed, wrong userid or password';
        $userid = trim($userid);
        if(!empty($userid) && !empty($password) && $userid!='root')
        {
            if(file_exists(AHKA.'/data/users/'.$userid))
            {
                $shadow = shell_exec('sudo grep "^'.$userid.':" /etc/shadow | cut -f 2 -d :');
                $shadow = preg_replace('@\s+@', '', $shadow);
                if(!empty($shadow))
                {
                    $pass = explode('$', $shadow);
                    if(crypt($password, '$'.$pass[1].'$'.$pass[2].'$')==$shadow)
                    {
                        $return = true;
                        $_SESSION['userid'] = $userid;
                    }
                }
            }
        }
        
        return $return;
    }
}