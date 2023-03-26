<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	    protected $data;
      public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('master_db');   
        $this->load->model('home_db'); 
        $this->data['detail']="";
        $this->data['session'] = ADMIN_SESSION; 
        if (!$this->session->userdata($this->data['session'])) {
            redirect('Login', 'refresh');
        }else{
                $sessionval = $this->session->userdata($this->data['session']);
                $details = $this->home_db->getlogin($sessionval['name']);
                if(count($details)){
                    $this->data['detail']=$details;
                }else{
                    $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                    redirect(base_url()."login/logout");
                }
        } 
        $this->data['header']=$this->load->view('includes/header', $this->data , TRUE);
        $this->data['footer']=$this->load->view('includes/footer', $this->data , TRUE);
  }
	public function index()
	{
		 $this->data['category'] = $this->master_db->getRecords('category',['status'=>0],'*');
        $this->data['psychiatrist'] = $this->master_db->getRecords('psychiatrist',['status'=>0],'*');
        $this->data['celebrities'] = $this->master_db->getRecords('celebrities',['status'=>0],'*');
        $this->data['states'] = $this->master_db->getRecords('states',['status'=>0],'*');
		$this->load->view('index',$this->data);
	}
}
