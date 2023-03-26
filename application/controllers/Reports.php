<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    protected $data;
      public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('master_db');   
        $this->load->model('home_db'); 
        $this->data['detail']="";
        $this->data['session'] = ADMIN_SESSION; 
         $this->load->library("excel");
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
  }
    public function exportproducts() {
        $query = "select p.id as pid,p.ptitle,p.pcode,p.overview,p.pspec,p.meta_title,p.meta_description,p.meta_keywords,p.tax,p.youtubelink,p.discount,p.length,p.weight,p.breadth,p.height,p.modalno,p.cqa,c.cname as catname,s.sname,ss.ssname,b.name as bname from products p left join category c on c.id =p.cat_id left join subcategory s on s.id = p.subcat_id left join subsubcategory ss on ss.id =p.sub_sub_id left join brand b on b.id= p.brand_id"; 
        $arr = $this->master_db->sqlExecute($query);
        //echo $this->db->last_query();exit;
        $count = 1;
        $table_columns = array("Sl No","Category Name","Subcategory Name","Subsubcategory Name","Brand Name","Product Title","Product Code","Product Description","Product Specification","Product Sizes","Product Price","Product Colors","Inventory","Length","Breadth","Weight","Height","Meta Title","Meta Description","Meta Keywords","Youtube Link","Discount","Tax","Modal Number","Customer Q&A");
        $count = 1;
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $column = 0;
        foreach($table_columns as $field)
        {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }
        $count_row = 2;
        foreach($arr as $r)
        { 
            $pid = $r->pid;
            $sizeQuery = "select s.sname as siname,co.name as coname, ps.selling_price as price,ps.stock from product_size ps left join sizes s on s.s_id = ps.sid left join colors co on co.co_id = ps.coid where ps.pid = ".$pid."";
            $getSize = $this->master_db->sqlExecute($sizeQuery);
            $sizename = [];$colorname =[];$price = [];$stock =[];
            if(count($getSize) >0) {
              foreach ($getSize as $key => $value) {
                  $sizename[] = $value->siname;
                  $colorname[] = $value->coname;
                  $price[] = $value->price;
                  $stock[] = $value->stock;
              }
            }
            $sizecomma = implode(",",$sizename);
            $colorcomma = implode(",",$colorname);
            $pricecomma = implode(",",$price);
            $stockcomma = implode(",",$stock);
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $count_row, strval($count++));
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $count_row, $r->catname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $count_row,$r->sname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $count_row, $r->ssname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $count_row, $r->bname);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $count_row, $r->ptitle);
           $object->getActiveSheet()->setCellValueByColumnAndRow(6, $count_row, $r->pcode);
           $object->getActiveSheet()->setCellValueByColumnAndRow(7, $count_row, $r->overview);
           $object->getActiveSheet()->setCellValueByColumnAndRow(8, $count_row, $r->pspec);
           $object->getActiveSheet()->setCellValueByColumnAndRow(9, $count_row, $sizecomma);
           $object->getActiveSheet()->setCellValueByColumnAndRow(10, $count_row, $pricecomma);
           $object->getActiveSheet()->setCellValueByColumnAndRow(11, $count_row, $colorcomma);
           $object->getActiveSheet()->setCellValueByColumnAndRow(12, $count_row, $stockcomma);
           $object->getActiveSheet()->setCellValueByColumnAndRow(13, $count_row, $r->length);
           $object->getActiveSheet()->setCellValueByColumnAndRow(14, $count_row, $r->breadth);
           $object->getActiveSheet()->setCellValueByColumnAndRow(15, $count_row, $r->weight);
           $object->getActiveSheet()->setCellValueByColumnAndRow(16, $count_row, $r->height);
           $object->getActiveSheet()->setCellValueByColumnAndRow(17, $count_row, $r->meta_title);
           $object->getActiveSheet()->setCellValueByColumnAndRow(18, $count_row, $r->meta_description);
           $object->getActiveSheet()->setCellValueByColumnAndRow(19, $count_row, $r->meta_keywords);
           $object->getActiveSheet()->setCellValueByColumnAndRow(20, $count_row, "https://www.youtube.com/watch?v=".$r->youtubelink);
           $object->getActiveSheet()->setCellValueByColumnAndRow(21, $count_row, $r->discount);
           $object->getActiveSheet()->setCellValueByColumnAndRow(22, $count_row, $r->tax);
           $object->getActiveSheet()->setCellValueByColumnAndRow(23, $count_row, $r->modalno);
           $object->getActiveSheet()->setCellValueByColumnAndRow(24, $count_row, $r->cqa);
           $count_row++;
        }
      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="products.xls"');
      header('Cache-Control: max-age=0');
      ob_end_clean();
      $object_writer->save('php://output');
    }
}
