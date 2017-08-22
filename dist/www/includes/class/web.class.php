<?php
class Web
{
    public function Add($domain, $alias, $tpl)
    {
        $domain = escapeshellarg(trim($domain));
        $alias = trim($alias);
        $alias = preg_replace('@\s+@', ',', $alias);
        $alias = escapeshellarg($alias);
        $tpl = escapeshellarg(trim($tpl));
        
        exec(AHKA_CMD.'web-add '.$_SESSION['userid'].' '.$domain.' '.$alias.' '.$tpl, $output, $return_val);
        
        $return['status'] = true;
        if($return_val>0)
        {
            $return['status'] = false;
        }
        $return['msg'] = implode('<br />', $output);
        
        return $return;
    }
    
    public function Delete($domain)
    {
        $domain = escapeshellarg(trim($domain));
        exec(AHKA_CMD.'web-delete '.$_SESSION['userid'].' '.$domain, $output, $return_val);
        
        $return['status'] = true;
        if($return_val>0)
        {
            $return['status'] = false;
        }
        $return['msg'] = implode('<br />', $output);
        
        return $return;
    }
    
    public function Lists()
    {
        exec(AHKA_CMD.'web-list '.$_SESSION['userid'].' json', $output, $return_val);
        $output = implode('', $output);
        $arr = json_decode($output, true);
        if($arr)
        {
            return $arr;
        }
        return false;
    }
    
    public function ListTemplate()
    {
        exec(AHKA_CMD.'web-list-templates json', $output, $return_val);
        $output = implode('', $output);
        $arr = json_decode($output, true);
        if($arr)
        {
            return $arr;
        }
        return false;
    }
}