<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_db extends CI_Model{
    function getRecords($table,$db = array(),$select = "*",$ordercol = '',$group = '',$start='',$limit='')
    {
        //echo ($limit != '' && $start !='');exit;
        $this->db->select($select);
        if(!empty($ordercol))
        {
            $this->db->order_by($ordercol);
        }
        if($limit != '')
        {   
            if( empty($start) ){ $start = 0; }
            $this->db->limit($limit,$start);
        }
        if($group != '')
        {
            $this->db->group_by($group);
        }
        $q=$this->db->get_where($table, $db);
        return $q !== FALSE ? $q->result() : array();
        //return $q->result();
        //return $this->db->last_query();
    }
	
	function insertRecord($table,$db=array())
    {
        $q=$this->db->insert($table, $db); 
        return $q !== FALSE ? $this->db->insert_id() : null;
        /* $total = $this->db->insert_id();
        if($total>0)
        return $total;
        else 
        return 0; */
    }
    function insert_batch($tbl,$data=array())
    {
        $q = $this->db->insert_batch($tbl, $data);
        return $q !== FALSE ? $this->db->insert_id() : null;
    }
    
    
	function getnumberformat($num){
    	return str_replace(".00", "", (string)number_format((float)$num, 0, '.', ','));
    }
    
    function getnumberformat_zero($num){
        return number_format((float)$num, 2, '.', ',');
    }
    
    function getnumberformatnocomma($num){
        return str_replace(".00", "", (string)number_format((float)$num, 2, '.', ''));
    }
    
	function deleterecord($table,$db=array())
	{
		$this->db->delete($table, $db);
	}
	
	function updateRecord($table,$data,$where=array())
	{
	    $q = $this->db->update($table,$data,$where);
	    return $q !== FALSE ? $this->db->affected_rows() : array();
	   
	}
	
	/* dont use this unnecessarily Ask to Aruna before using */
	function sqlExecute($sql)
	{
	    $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
	    return $q !== FALSE ? $q->result() : array();
	}
	
    public function create_unique_slug($string,$table,$field,$key=NULL,$value=NULL)
    {
        $t =& get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
    
        if($key)$params["$key !="] = $value;
    
        while ($t->db->where($params)->get($table)->num_rows())
        {
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
                
            $params [$field] = $slug;
        }
        return $slug;
    }

   
	
}
?>