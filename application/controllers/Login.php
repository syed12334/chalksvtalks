<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	protected $data;
	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->helper('utility_helper');
        $this->load->model('master_db');   
        $this->load->model('home_db'); 
        $this->data['session'] = ADMIN_SESSION; 
	}
	public function index() {
		if(!$this->session->userdata($this->data['session'])){
	        $this->load->view('login_view',$this->data);
	    }else{
	      redirect('home');
	    }
	}
	public	function checklogin(){
	 	$name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
	    $password = trim(preg_replace('!\s+!', '',$this->input->post('password',true)));
	    //echo "<pre>";print_r($_POST);exit;
		$details = $this->home_db->getlogin($name);
		//echo $this->db->last_query();exit;
		if(count($details) >0){		
			if(password_verify($password, $details[0]->password)) {
				$savesession =array('id'=>$details[0]->id,'name'=>$details[0]->username);
				$this->session->set_userdata(ADMIN_SESSION, $savesession);	
				echo 1;
			}else {
				echo 0;
			}			
		}else{
			echo -1;
		}
	}
	public function logout()
	{
	    $this->session->unset_userdata($this->data['session']);
	    redirect(base_url().'login');
	}
}