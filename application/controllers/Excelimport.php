<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Excelimport extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('master_db');
        $this->load->model('home_db');
    }
    public function saveBrand() {
        if(!empty($_FILES["brand"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['brand']['name'];
            $arrayTemp1=$_FILES['brand']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["brand"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $brandname = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								if(!empty($brandname)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from brand where name in ("'.$brandname.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Brand already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
									      'name'  => $brandname,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("brand",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Brand name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
      public function saveColors() {
        if(!empty($_FILES["colors"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['colors']['name'];
            $arrayTemp1=$_FILES['colors']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["colors"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $colorname = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								if(!empty($colorname)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from colors where name in ("'.$colorname.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Color already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
									      'name'  => $colorname,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("colors",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Color name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
     public function saveSize() {
        if(!empty($_FILES["sizes"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['sizes']['name'];
            $arrayTemp1=$_FILES['sizes']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["sizes"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $sizename = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								if(!empty($sizename)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from sizes where sname in ("'.$sizename.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Sizes already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
									      'sname'  => $sizename,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("sizes",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Sizes name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }

    public function saveStates() {
        if(!empty($_FILES["states"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['states']['name'];
            $arrayTemp1=$_FILES['states']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["states"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $statename = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								if(!empty($statename)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from states where name in ("'.$statename.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'State already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
									      'name'  => $statename,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("states",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'States name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
    public function saveCategory() {
        if(!empty($_FILES["category"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['category']['name'];
            $arrayTemp1=$_FILES['category']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["category"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $categoryname = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
								if(!empty($categoryname)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from category where cname in ("'.$categoryname.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Category already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
									      'cname'  => $categoryname,
									      'page_url'=> $this->master_db->create_unique_slug($categoryname,'category','page_url'),
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("category",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Category name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
     public function saveCity() {
        if(!empty($_FILES["city"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['city']['name'];
            $arrayTemp1=$_FILES['city']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["city"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		$worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $sid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $cityname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							     $noofdays = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
								if(!empty($cityname) && !empty($sid)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from cities where cname in ("'.$cityname.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'City already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
						        		  'sid' =>$sid,
									      'cname'  => $cityname,
									      'noofdays' =>$noofdays,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("cities",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'City name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
    public function saveArea() {
        if(!empty($_FILES["area"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['area']['name'];
            $arrayTemp1=$_FILES['area']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["area"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $cid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $areaname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								if(!empty($areaname) && !empty($cid)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from area where areaname in ("'.$areaname.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Area already try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
						        		  'cid' =>$cid,
									      'areaname'  => $areaname,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("area",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Area name is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
     public function savePincode() {
        if(!empty($_FILES["pincode"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['pincode']['name'];
            $arrayTemp1=$_FILES['pincode']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["pincode"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $cid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $pincodes = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							     $amount = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
								if(!empty($pincodes) && !empty($cid) && !empty($amount)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from pincodes where pincode in ("'.$pincodes.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Pincode already exists try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		$data = array(
						        		  'cid' =>$cid,
									      'pincode'  => $pincodes,
									      'amount'	 => $amount,
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("pincodes",$data);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Pincode is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
    public function saveSubcategory() {
    	  if(!empty($_FILES["subcat"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['subcat']['name'];
            $arrayTemp1=$_FILES['subcat']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["subcat"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $cid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $sname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								if(!empty($sname) && !empty($cid)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from subcategory where sname in ("'.$sname.'")');
								     // if(count($getBrandval) >0) {
								     // 	$brand = array(
							      //   		'status'   => false,
							      //       	'msg' => 'Subcategory already exists try another',
							      //       	'csrf_token'=> $this->security->get_csrf_hash()
						       //  		);
								     // }else {
						        		$data = array(
						        		  'cat_id' =>$cid,
									      'sname'  => $sname,
									      'page_url'=> $this->master_db->create_unique_slug($sname,'subcategory','page_url'),
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("subcategory",$data);
								       //}
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Subcategory is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
     public function savesubSubcategory() {
    	if(!empty($_FILES["subsubcat"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['subsubcat']['name'];
            $arrayTemp1=$_FILES['subsubcat']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["subsubcat"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $cid = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $ssname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
								if(!empty($ssname) && !empty($cid)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from subsubcategory where ssname in ("'.$ssname.'")');
								     // if(count($getBrandval) >0) {
								     // 	$brand = array(
							      //   		'status'   => false,
							      //       	'msg' => 'Subsubcategory already exists try another',
							      //       	'csrf_token'=> $this->security->get_csrf_hash()
						       //  		);
								     // }else {
						        		$data = array(
						        		  'sub_id' =>$cid,
									      'ssname'  => $ssname,
									      'page_url' => $this->master_db->create_unique_slug($ssname,'subsubcategory','page_url'),
									      'created_at'   => date('Y-m-d H:i:s'),
									     );
								     	$in = $this->master_db->insertRecord("subsubcategory",$data);
								     // }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Subsubcategory is required',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
    public function saveProducts() {
    	if(!empty($_FILES["products"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['products']['name'];
            $arrayTemp1=$_FILES['products']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["products"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
							     $category = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(1, $row)->getValue())));
            					 $subcategory = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(2, $row)->getValue())));
            					 $subsubcategory = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(3, $row)->getValue())));
            					 $brand = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(4, $row)->getValue())));
            					 $ptitle = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(5, $row)->getValue())));
            					 $pcode = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(6, $row)->getValue())));
            					 $pdesc = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            					 $pspec = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            					 $size = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
            					 $sellprice = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
            					 $colors = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
            					 $stock = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
            					 $colorimg = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
            					 $length = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(14, $row)->getValue())));
            					 $breadth = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(15, $row)->getValue())));
            					 $weight = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(16, $row)->getValue())));
            					 $height = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(17, $row)->getValue())));
            					 $mtitle = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
            					 $mdesc = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
            					 $mkeywords = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
            					 $youtube = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(21, $row)->getValue())));
            					 $youtubeid = "";
            					 $tax = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(22, $row)->getValue())));
            					 $discount = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(23, $row)->getValue())));
            					 $modalno = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(24, $row)->getValue())));
            					 $cqa = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(25, $row)->getValue())));
								if(!empty($category) && !empty($subcategory) && !empty($ptitle) && !empty($pcode) && !empty($pdesc)) {
									  if(!empty($youtube)) {
                							$ex = explode("v=", $youtube);
                							$youtubeid .= $ex[1];
            							}
									$getProducts = $this->master_db->sqlExecute('select * from products where ptitle in ("'.$ptitle.'")');
								    if(count($getProducts) >0) {
								    	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Product title already exists try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								    }else {
								    	$sizeex = explode(",", $size);
								    	$sellex = explode(",", $sellprice);
								    	$colorsex = explode(",", $colors);
								    	$stockex = explode(",", $stock);
						        		$insert['cat_id'] = $category;
						                $insert['subcat_id'] = $subcategory;
						                $insert['sub_sub_id'] = $subsubcategory;
						                $insert['brand_id'] = $brand;
						                $insert['ptitle'] = $ptitle;
						                $insert['page_url'] =$this->master_db->create_unique_slug($ptitle,'products','page_url');
						                $insert['pcode'] = $pcode;
						                $insert['overview'] = $pdesc;
						                $insert['pspec'] = $pspec;
						                $insert['meta_title'] = $mtitle;
						                $insert['meta_keywords'] = $mkeywords;
						                $insert['meta_description'] = $mdesc;
						                $insert['modalno'] = $modalno;
						                $insert['cqa'] = $cqa;
						                $insert['tax'] = $tax;
						                $insert['youtubelink'] = $youtubeid;
						                $insert['discount'] = $discount;
						                $insert['created_at'] = date('Y-m-d h:i:s');
						                $insert['length'] = $length;
						                $insert['weight'] = $weight;
						                $insert['breadth'] = $breadth;
						                $insert['height'] = $height;
						                $products = $this->master_db->insertRecord('products',$insert);
						                if($products >0) {
						                	if(is_array($sizeex) && is_array($sellex) && !empty($sizeex) && !empty($sellex)) {
						                        foreach ($sizeex as $key => $si) {
						                            $db['pid'] = $products;
						                            $db['sid'] = $si;
						                            $db['coid'] = $colorsex[$key];
						                            $db['selling_price'] = $sellex[$key];
						                            $db['stock'] = $stockex[$key];
						                            $sizeimg = $this->master_db->insertRecord('product_size',$db);
						                        }
						                    }
						                }else {
						                	$brand = array(
								        		'status'   => false,
								            	'msg' => 'Error in inserting try again',
								            	'csrf_token'=> $this->security->get_csrf_hash()
							        		);
							        		echo json_encode($brand);exit;
						                }
								    }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Required fields is missing',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
			    			//exit;
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
    public function saveCoupons() {
    	if(!empty($_FILES["coupons"]["tmp_name"])) {
        	$arry = array("xlsx","csv");
			$arrayImage2=$_FILES['coupons']['name'];
            $arrayTemp1=$_FILES['coupons']['tmp_name'];
            $dd1 = explode(".", $arrayImage2);
            $ext = end($dd1);
            if(in_array($ext,$arry)){
                	$path = $_FILES["coupons"]["tmp_name"];
		   			 $objPHPExcel = PHPExcel_IOFactory::load($path);
            		 $objWorksheet = $objPHPExcel->getActiveSheet();
            		 $worksheet = $objWorksheet;
			    			$highestRow = $worksheet->getHighestRow();
			    			$highestColumn = $worksheet->getHighestColumn();
			    			for($row=2; $row <= $highestRow; $row++)
			    			{
			    				 $slno = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							     $ctype = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							     $ccode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							     $fdate = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							     $tdate = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							     $discount = trim(preg_replace('!\s+!', ' ',html_escape($worksheet->getCellByColumnAndRow(5, $row)->getValue())));
								if(!empty($ctype) && !empty($ccode) && !empty($fdate) && !empty($tdate) && !empty($discount)) {
								    $getBrandval = $this->master_db->sqlExecute('select * from vouchers where title in ("'.$ccode.'")');
								     if(count($getBrandval) >0) {
								     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Coupon code already exists try another',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
								     }else {
						        		 $db = array(
					                        'type'=>$ctype,
					                        'title'=>$ccode,
					                        'from_date'=>$fdate,
					                        'to_date'=>$tdate,
					                        'discount'=>$discount,
					                        'created_at'=>date('Y-m-d H:i:s'),
					                        'status'=>0,
					                	 );
                						$res=$this->master_db->insertRecord('vouchers',$db);
								      }
							     }else {
							     	$brand = array(
							        		'status'   => false,
							            	'msg' => 'Required fields is missing',
							            	'csrf_token'=> $this->security->get_csrf_hash()
						        		);
							     }
			    			}
		        			$brand = array(
				        		'status'   => true,
				            	'msg' => 'Imported successfully',
				            	'csrf_token'=> $this->security->get_csrf_hash()
			        		);
            }else {
            		$brand = array(
		        		'status'   => false,
		            	'msg' => 'Only .xlsx and .csv format are allowed',
		            	'csrf_token'=> $this->security->get_csrf_hash()
	        		);
            }
        }else {
        	$brand = array(
	        		'formerror'   => false,
	            	'file_error' =>"File is required",
	            	'csrf_token'=> $this->security->get_csrf_hash()
	        	);
        }
        echo json_encode($brand);
    }
}
