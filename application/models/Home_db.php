<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_db extends CI_Model{

	    public function rows_by_paginations($query,$order_by,$order_by_arr,$db="default")
    {
        $this->load->database($db);

        if(isset($_POST["order"]))
        {
            $order_by = " order by ".$order_by_arr[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];
        }
        
        $limit = " ";
        if($_POST["length"] != -1)
        {
            $limit = " limit {$_POST['length']}";
            if($_POST['start'] > 0){
                $limit = " limit {$_POST['start']}, {$_POST['length']}";
            }
        }
        $query = $this->db->query($query.$order_by.$limit);
        
        return $query->result();
    }   
  
    public function run_manual_query_result($query,$db="default")
    {
        $this->load->database($db);
        $query = $this->db->query($query);
        return $query->result();
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
	    function getlogin($username){
        //try {
        //$username = $this->db->escape($db['username']);
        $wdb = array("username"=>$username);
        $this->db->select("id, username,password")
                 ->from('admin')
                 ->where($wdb);
        $q = $this->db->get();
        return $q !== FALSE ? $q->result() : array();
    }
    
    
}