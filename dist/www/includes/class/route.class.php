<?php
class Route
{
    private $view = array();
    private $query = array();
    
    public function __construct()
    {
        if (isset($_SERVER['REQUEST_URI']))
        {
            $request_path = explode('?', $_SERVER['REQUEST_URI']);
            
            $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
            $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
            $path['call'] = utf8_decode($path['call_utf8']);
            if ($path['call'] == basename($_SERVER['PHP_SELF']))
            {
                $path['call'] = '';
            }
            $path['call_parts'] = explode('/', $path['call']);
            for($i=0;$i<count($path['call_parts']);$i++)
            {
                $path['call_parts'][$i] = trim($path['call_parts'][$i]);
                if($path['call_parts'][$i]!='')
                {
                    $this->view[] = $path['call_parts'][$i];
                }
            }
            
            if(isset($request_path[1]))
            {
                $path['query_utf8'] = urldecode($request_path[1]);
                $path['query'] = utf8_decode(urldecode($request_path[1]));
                $vars = explode('&', $path['query']);
                foreach ($vars as $var)
                {
                    $t = explode('=', $var);
                    $this->query[$t[0]] = isset($t[1])?$t[1]:'';
                }
            }
        }
    }
    
    /**
     * Get view by index
     * return string if index is set and found, false if not found, array if index is not set
    */
    public function GetView($idx=null)
    {
        if($this->view)
        {
            if(!is_null($idx))
            {
                if(isset($this->view[$idx]))
                {
                    return $this->view[$idx];
                }
            }
            else
            {
                return $this->view;
            }
        }
        return false;
    }
    
    /**
     * Search view by string
     * return string if found or false if not found
    */
    public function SearchView($search)
    {
        $index_search = array_search($search, $this->view);
        if($index_search!==false)
        {
            $index_search = $index_search+1;
            if(isset($this->view[$index_search]))
            {
                return $this->view[$index_search];
            }
        }
        return false;
    }
    
    /**
     * Get query by key
     * return string if key is set and found, false if not found, array if key is not set
    */
    public function GetQuery($key=null)
    {
        if($this->query)
        {
            if(!is_null($key))
            {
                if(isset($this->query[$key]))
                {
                    return $this->query[$key];
                }
            }
            else
            {
                return $this->query;
            }
        }
        return false;
    }
}
?>