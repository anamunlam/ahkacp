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
    
    public function LoginAs($userid)
    {
        if(isset($_SESSION['userid']))
        {
            if($_SESSION['userid']=='admin')
            {
                $userid = trim($userid);
                if(file_exists(AHKA.'/data/users/'.$userid))
                {
                    $_SESSION['true_userid'] = $_SESSION['userid'];
                    $_SESSION['userid'] = $userid;
                    return true;
                }
            }
        }
        return false;
    }
    
    public function Lists($limit=false, $offset=0)
    {
        $return = array();
        $list = array_diff(scandir(AHKA.'/data/users'), array('..', '.'));
        //$list = array_values($list);
        $i=0;
        foreach($list as $user)
        {
            $return[$i]['userid'] = $user;
            $fh = fopen(AHKA.'/data/users/'.$user.'/user.conf', 'r');
            while($line = fgets($fh))
            {
                $pieces = array();
                if(preg_match('/^FNAME=\'(.*)?\'$/', $line, $pieces))
                {
                    $return[$i]['fname'] = $pieces[1];
                }
                if(preg_match('/^LNAME=\'(.*)?\'$/', $line, $pieces))
                {
                    $return[$i]['lname'] = $pieces[1];
                }
                if(preg_match('/^CONTACT=\'(.*)?\'$/', $line, $pieces))
                {
                    $return[$i]['contact'] = $pieces[1];
                    break;
                }
            }
            $i++;
        }
        if($limit!==false)
        {
            return array_slice($return, $offset, $limit);
        }
        return $return;
    }
    
    public function Add($userid, $password, $fname, $lname, $email)
    {
        $userid = escapeshellarg(trim($userid));
        $fname = escapeshellarg(trim($fname));
        $lname = escapeshellarg(trim($lname));
        $email = escapeshellarg(trim($email));
        $password = escapeshellarg($password);
        
        exec(AHKA_CMD.'user-add '.$userid.' '.$password.' '.$email.' '.$fname.' '.$lname, $output, $return_val);
        unset($output);
        if($return_val>0)
        {
            return false;
        }
        return true;
    }
    
    public function Edit($userid, $password, $fname, $lname, $email)
    {
        $ret['status'] = false;
        $ret['msg'] = 'Unknown Error';
        
        $userid = trim($userid);
        $fname = trim($fname);
        $lname = trim($lname);
        $email = trim($email);
        
        exec(AHKA_CMD.'user-edit '.escapeshellarg($userid).' '.escapeshellarg($email).' '.escapeshellarg($fname).' '.escapeshellarg($lname), $output, $return_val);
        unset($output);
        if($return_val===1)
        {
            $ret['msg'] = 'Invalid email format';
            return $ret;
        }
        
        if(!empty($password))
        {
            exec(AHKA_CMD.'user-change-password '.escapeshellarg($userid).' '.escapeshellarg($password), $output, $return_val);
            unset($output);
            if($return_val>0)
            {
                $ret['msg'] = 'Password failed to change';
                return $ret;
            }
        }
        
        $ret['status'] = true;
        $ret['msg'] = 'User detail changed';
        
        return $ret;
    }
    
    public function Delete($userid)
    {
        $ret['status'] = false;
        $ret['msg'] = 'Unknown Error';
        
        $userid = trim($userid);
        exec(AHKA_CMD.'user-delete '.escapeshellarg($userid), $output, $return_val);
        unset($output);
        if($return_val>0)
        {
            $ret['msg'] = 'Failed to delete user';
            return $ret;
        }
        
        $ret['status'] = true;
        $ret['msg'] = 'User deleted';
        return $ret;
    }
    
    public function ChangePass($old_pw, $new_pw, $con_pw)
    {
        $userid = trim($_SESSION['userid']);
        
        if($new_pw==$con_pw)
        {
            $shadow = shell_exec('sudo grep "^'.$userid.':" /etc/shadow | cut -f 2 -d :');
            $shadow = preg_replace('@\s+@', '', $shadow);
            if(!empty($shadow))
            {
                $pass = explode('$', $shadow);
                if(crypt($old_pw, '$'.$pass[1].'$'.$pass[2].'$')==$shadow)
                {
                    exec(AHKA_CMD.'user-change-password '.escapeshellarg($userid).' '.escapeshellarg($new_pw), $output, $return_val);
                    unset($output);
                    if($return_val==0)
                    {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
}