<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {
    protected $data;
    public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('master_db');
        $this->load->model('home_db');
        $this->data['detail'] = "";
        $this->load->library('encryption');
        $this->load->library('form_validation');
        $this->data['session'] = ADMIN_SESSION;
        if (!$this->session->userdata($this->data['session'])) {
            redirect('Login', 'refresh');
        } else {
            $sessionval = $this->session->userdata($this->data['session']);
            $details = $this->home_db->getlogin($sessionval['name']);
            if (count($details)) {
                $this->data['detail'] = $details;
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Invalid Credentials.</div>');
                redirect(base_url() . "login/logout");
            }
        }
        $this->data['header'] = $this->load->view('includes/header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('includes/footer', $this->data, TRUE);
    }
    public function index() {
        $this->load->view('index', $this->data);
    }
    /* Category  */
    public function category() {
        $this->load->view('masters/category/category', $this->data);
    }
    public function getCategorylist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (cname like '%$val%') ";
            $where.= " or (image like '%$val%') ";
        }
        $order_by_arr[] = "cname";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from category " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            if (!empty($r->image)) {
                $image.= "<img src='" . app_url() . $r->image . "'  style='width:80px'/>";
            }
            $action = '<a href=' . base_url() . "master/editcategory/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            
            $sub_array[] = $i++;
            $sub_array[] = $action;
            // $sub_array[] = $image;
            $sub_array[] = ucfirst($r->cname);
            $sub_array[] =$r->id;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function categoryadd() {
        $this->load->view('masters/category/categoryadd', $this->data);
    }
    public function editcategory() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['category'] = $this->master_db->getRecords('category', ['id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/category/categoryedit', $this->data);
    }
    public function categorysave() {
        // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        if ($id == "") {
            $getCategory = $this->master_db->getRecords('category',['cname'=>$cname],'*');
            if(count($getCategory) >0) {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Category already exists</div>');
                 redirect(base_url() . 'master/categoryadd');
            }else {
                    $db['cname'] = $cname;
                   
                    $db['page_url'] = $this->master_db->create_unique_slug($cname,'category','page_url');
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('category', $db);
                    if ($in > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        redirect(base_url() . 'master/category');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                        redirect(base_url() . 'master/categoryadd');
                    }
            }
        } else {
            $ids = $this->input->post('cid');
            //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
            $getCategory = $this->master_db->getRecords('category',['cname'=>$cname],'*');
            // if(count($getCategory) >0) {
            //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Category already exists</div>');
            //             redirect(base_url() . 'master/category');
            // }else {
                $db['cname'] = $cname;
              
                $db['page_url'] = $this->master_db->create_unique_slug($cname,'category','page_url');
                $db['modified_at'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('category', $db, ['id' => $id]);
                if ($update > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    redirect(base_url() . 'master/category');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                    redirect(base_url() . 'master/category');
                }   
            //}
        }
    }
    public function setcategoryStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('category', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status ==3) {
            $where_data = array('showcategory' => 0);
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
        else if ($status ==4) {
            $where_data = array('showcategory' => 1);
            $this->master_db->updateRecord('category', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }

    /****** States ******/
    public function states() {
        $this->load->view('masters/states/states', $this->data);
    }
    public function getStates() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (name like '%$val%') ";
        }
        $order_by_arr[] = "name";
        $order_by_arr[] = "";
        $order_by_arr[] = "id";
        $order_by_def = " order by id desc";
        $query = "select * from states " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editstates?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = ucfirst($r->name);
            $sub_array[] = $r->id;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function stateadd() {
        $this->load->view('masters/states/statesadd', $this->data);
    }
    public function savestates() {
        //echo "<pre>";print_r($_POST);exit;
        $title = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('title', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $getState = $this->master_db->getRecords('states',['name'=>$title],'*');
        if(count($getState) >0) {
                  $results = ['status' => false, 'msg' => 'State already exists try another ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
        }else {
                if (!empty($id)) {
                $db['name'] = $title;
                $db['modified_date'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('states', $db, ['id' => $id]);
                if ($update) {
                    $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    echo json_encode($results);
                } else {
                    $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
                }
            } else {
                if (!empty($title)) {
                    $db['name'] = $title;
                    $db['status'] = 0;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('states', $db);
                    if ($in) {
                        $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                    } else {
                        $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    }
                } else {
                    $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($result);
                }
            }  
        }
    }
    public function setstatesStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('states', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('states', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('states', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function editstates() {
        $this->load->library('encrypt');
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $getStates = $this->master_db->getRecords('states', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['property'] = $getStates;
        $this->load->view('masters/states/statesadd', $this->data);
    }
    /****** City ******/
    public function city() {
        $this->load->view('masters/city/cities', $this->data);
    }
    public function getcity() {
        $where = "where c.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (c.cname like '%$val%') ";
            $where.= " or (s.name like '%$val%') ";
            $where.= " or (c.created_at like '%$val%') ";
        }
        $order_by_arr[] = "c.name";
        $order_by_arr[] = "";
        $order_by_arr[] = "c.id";
        $order_by_def = " order by c.id desc";
        $query = "select c.id,c.cname,s.name as sname,c.created_at,c.status,c.noofdays from cities c left join states s on s.id = c.sid  " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editcity?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->sname;
            $sub_array[] = $r->id;
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function cityadd() {
        $getStates = $this->master_db->getRecords('states', ['status' => 0], 'id,name', 'name asc');
        $this->data['states'] = $getStates;
        $this->load->view('masters/city/cityadd', $this->data);
    }
    public function setcityStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('cities', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('cities', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_date' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('cities', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function savecity() {
        //echo "<pre>";print_r($_POST);exit;
        $state = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('state', true))));
        $city = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('city', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $noofdays = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('noofdays', true))));
        $getCity = $this->master_db->getRecords('cities',['cname'=>$city],'*');
        if(count($getCity) >0) {
            $results = ['status' => false, 'msg' => 'City already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
        }else {
                    if (!empty($id)) {
                $db['sid'] = $state;
                $db['cname'] = $city;
                $db['noofdays'] = $noofdays;
                $db['modified_date'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('cities', $db, ['id' => $id]);
                if ($update) {
                    $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    echo json_encode($results);
                } else {
                    $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($results);
                }
            } else {
                if (!empty($city)) {
                    $db['sid'] = $state;
                    $db['cname'] = $city;
                    $db['noofdays'] = $noofdays;
                    $db['status'] = 0;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('cities', $db);
                    if ($in) {
                        $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                    } else {
                        $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                    }
                } else {
                    $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                    echo json_encode($result);
                }
            }
        }
        
    }
    public function editcity() {
        $id = icchaDcrypt($_GET['id']);
        $getStates = $this->master_db->getRecords('states', ['status' => 0], 'id,name', 'name asc');
        $this->data['states'] = $getStates;
        //echo $id;exit;
        $cities = $this->master_db->getRecords('cities', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['city'] = $cities;
        $this->load->view('masters/city/cityadd', $this->data);
    }
    /****** Area ******/
    public function area() {
        $this->load->view('masters/area/area', $this->data);
    }
    public function getarea() {
        $where = "where a.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (c.cname like '%$val%') ";
            $where.= " or (a.areaname like '%$val%') ";
            $where.= " or (a.created_at like '%$val%') ";
        }
        $order_by_arr[] = "a.areaname";
        $order_by_arr[] = "";
        $order_by_arr[] = "a.id";
        $order_by_def = " order by a.id desc";
        $query = "select a.areaname,a.created_at,a.status,c.cname,a.id from area a left join  cities c on c.id = a.cid  " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editarea?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->areaname;
            $sub_array[] = $r->id;
            //$sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function areaadd() {
        $getcities = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname', 'cname asc');
        $this->data['cities'] = $getcities;
        $this->data['type'] = "add";
        $this->load->view('masters/area/areaadd', $this->data);
    }
    public function setareaStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('area', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('area', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('area', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
    public function savearea() {
        //echo "<pre>";print_r($_POST);exit;
        $city = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('city', true))));
        $area = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('area', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $getArea = $this->master_db->getRecords('area',['areaname'=>$area],'*');
        if(count($getArea) >0) {
                $results = ['status' => false, 'msg' => 'Area already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
        }else {
                     if (!empty($id)) {
                    $db['cid'] = $city;
                    $db['areaname'] = $area;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('area', $db, ['id' => $id]);
                    if ($update) {
                        $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        echo json_encode($results);
                    } else {
                        $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
                    }
                } else {
                    if (!empty($city)) {
                        $db['cid'] = $city;
                        $db['areaname'] = $area;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('area', $db);
                        if ($in) {
                            $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                            echo json_encode($result);
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        } else {
                            $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        }
                    } else {
                        $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                    }
                }  
        }
       
    }
    public function editarea() {
        $id = icchaDcrypt($_GET['id']);
        //echo $id;exit;
        $cities = $this->master_db->getRecords('cities', ['status' => 0], '*');
        $area = $this->master_db->getRecords('area', ['id' => $id], 'id,areaname,cid');
        //echo $this->db->last_query();exit;
        $this->data['cities'] = $cities;
        $this->data['type'] = "edit";
        $this->data['area'] = $area;
        $this->load->view('masters/area/areaadd', $this->data);
    }
    /*** Pincodes *******/
    public function pincodes() {
        $this->load->view('masters/pincodes/pincodes', $this->data);
    }
    public function pincodeadd() {
        $this->data['city'] = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname');
        $this->load->view('masters/pincodes/pincodesadd', $this->data);
    }
    public function getPincodes() {
        $where = "where p.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (p.pincode like '%$val%') ";
            $where.= " or (c.cname like '%$val%') ";
        }
        $order_by_arr[] = "p.name";
        $order_by_arr[] = "";
        $order_by_arr[] = "p.id";
        $order_by_def = " order by id desc";
        $query = "select p.id,p.pincode,p.cid,p.created_at,p.status,c.cname from pincodes p left join cities c on c.id = p.cid " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $action.= '<a href=' . base_url() . "master/editpincodes?id=" . icchaEncrypt($r->id) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            $status = '';
            $type = "";
            if ((int)$r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", -1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Activate' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            // $action .= "<button title='View Detail' class='btns' onClick='popUp()'><i class='fas fa-eye' ></i></button>&nbsp;";
            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->pincode;
            $sub_array[] = ucfirst($r->cname);
            // $sub_array[] = "<i class='fas fa-calendar' style='color:#620404;margin-right:3px'></i> ".date('d M y',strtotime($r->created_at))."<br/>"."<i class='fas fa-clock' style='color:#620404;margin-right:3px'></i> ".date('h:i:s A',strtotime($r->created_at));
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function pincodesave() {
        //echo "<pre>";print_r($_POST);exit;
        $pincode = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('pincode', true))));
        $id = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('id', true))));
        $cid = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('cid', true))));
        $amount = trim(preg_replace('!\s+!', ' ', html_escape($this->input->post('amount', true))));
        $getPincode = $this->master_db->getRecords('pincodes',['pincode'=>$pincode],'*');
        // if(count($getPincode) >0) {
        //     $results = ['status' => false, 'msg' => 'Pincode already exists try another', 'csrf_token' => $this->security->get_csrf_hash() ];
        //                 echo json_encode($results);
        // }else {
                  if (!empty($id)) {
                    $db['cid'] = $cid;
                    $db['pincode'] = $pincode;
                    // $db['amount'] = $amount;
                    $db['modified_at'] = date('Y-m-d H:i:s');
                    $update = $this->master_db->updateRecord('pincodes', $db, ['id' => $id]);
                    if ($update) {
                        $results = ['status' => true, 'msg' => 'Updated successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                        echo json_encode($results);
                    } else {
                        $results = ['status' => false, 'msg' => 'Error in updating ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($results);
                    }
                } else {
                    if (!empty($pincode)) {
                        $db['cid'] = $cid;
                        $db['pincode'] = $pincode;
                        $db['amount'] = $amount;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('pincodes', $db);
                        if ($in) {
                            $result = ['status' => true, 'msg' => 'Inserted successfully', 'csrf_token' => $this->security->get_csrf_hash() ];
                            echo json_encode($result);
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        } else {
                            $result = ['status' => false, 'msg' => 'Error in inserting ', 'csrf_token' => $this->security->get_csrf_hash() ];
                        }
                    } else {
                        $result = ['status' => false, 'msg' => 'Required fields are missing', 'csrf_token' => $this->security->get_csrf_hash() ];
                        echo json_encode($result);
                    }
                }
        //}
    }
    public function editpincodes() {
        $this->load->library('encrypt');
        $id = icchaDcrypt($_GET['id']);
        $this->data['city'] = $this->master_db->getRecords('cities', ['status' => 0], 'id,cname');
        //echo $id;exit;
        $getPackage = $this->master_db->getRecords('pincodes', ['id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->data['pincodes'] = $getPackage;
        $this->load->view('masters/pincodes/pincodesadd', $this->data);
    }
    public function setpincodesStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('pincodes', ['id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == - 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('pincodes', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('pincodes', $where_data, array('id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }

        /* Art Type  */
    public function art() {
        $this->load->view('masters/art/art', $this->data);
    }
    public function getArttypelist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (art_name like '%$val%') ";
            $where.= " or (status like '%$val%') ";
        }
        $order_by_arr[] = "art_name";
        $order_by_arr[] = "";
        $order_by_arr[] = "art_id";
        $order_by_def = " order by art_id desc";
        $query = "select * from arttype " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
            $image = "";
            
            $action = '<a href=' . base_url() . "master/editarttype/" . icchaEncrypt(($r->art_id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->art_id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->art_id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->art_id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";
            
            $sub_array[] = $i++;
            $sub_array[] = $action;
            // $sub_array[] = $image;
            $sub_array[] = ucfirst($r->art_name);
            $sub_array[] =$r->art_id;
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function arttypeadd() {
        $this->load->view('masters/art/artadd', $this->data);
    }
    public function editarttype() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['category'] = $this->master_db->getRecords('arttype', ['art_id' => $id], '*');
        // echo $this->db->last_query();exit;
        $this->load->view('masters/art/artedit', $this->data);
    }
    public function arttypesave() {
        // echo "<pre>";print_r($_POST);print_r($_FILES);exit;
        $id = $this->input->post('cid');
        $cname = trim(html_escape($this->input->post('cname', true)));
        if ($id == "") {
            $getCategory = $this->master_db->getRecords('arttype',['art_name'=>$cname],'*');
            if(count($getCategory) >0) {
                 $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Art name already exists</div>');
                 redirect(base_url() . 'master/arttypeadd');
            }else {
                    $db['art_name'] = $cname;
                   
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('arttype', $db);
                    if ($in > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Inserted successfully</div>');
                        redirect(base_url() . 'master/art');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in inserting</div>');
                        redirect(base_url() . 'master/arttypeadd');
                    }
            }
        } else {
            $ids = $this->input->post('cid');
            //echo "<pre>";print_r($_POST);print_r($_FILES);exit;
            $getCategory = $this->master_db->getRecords('arttype',['art_name'=>$cname],'*');
            // if(count($getCategory) >0) {
            //     $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Category already exists</div>');
            //             redirect(base_url() . 'master/category');
            // }else {
                $db['art_name'] = $cname;
                $db['modified_at'] = date('Y-m-d H:i:s');
                $update = $this->master_db->updateRecord('arttype', $db, ['art_id ' => $id]);
                if ($update > 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Updated successfully</div>');
                    redirect(base_url() . 'master/art');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Errro in updating</div>');
                    redirect(base_url() . 'master/art');
                }   
            //}
        }
    }
    public function setarttypeStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('arttype', ['art_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('arttype', $where_data, array('art_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'));
            $this->master_db->updateRecord('arttype', $where_data, array('art_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
       
    }

      /* Police  */
    public function police() {
        $this->load->view('masters/police/police', $this->data);
    }
    public function getPolicelist() {
        $where = "where status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (station_name like '%$val%') ";
            $where.= " or (incharge_officer like '%$val%') ";
            $where.= " or (phoneno like '%$val%') ";
            $where.= " or (status like '%$val%') ";
        }
        $order_by_arr[] = "station_name";
        $order_by_arr[] = "";
        $order_by_arr[] = "po_id";
        $order_by_def = " order by po_id desc";
        $query = "select * from police " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
           
            $action = '<a href=' . base_url() . "master/editpolice/" . icchaEncrypt(($r->po_id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->po_id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->po_id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->po_id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";


            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->station_name;
            $sub_array[] = $r->incharge_officer;
            $sub_array[] = $r->phoneno;
            
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function policeadd() {
        $this->load->view('masters/police/policeadd', $this->data);
    }
    public function editpolice() {
        $id = icchaDcrypt($this->uri->segment(3));
        //echo $id;exit;
        $this->data['police'] = $this->master_db->getRecords('police', ['po_id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->load->view('masters/police/policeedit', $this->data);
    }
    public function policesave() {
        //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('sname','Station name','required|regex_match[/^([A-Za-z0-9 ])+$/i]',['required'=>'Station name is required','regex_match'=>'Only characters and numbers are allowed']);
        $this->form_validation->set_rules('siofficer','Station incharge officer','required|regex_match[/^([A-Za-z0-9 ])+$/i]',['required'=>'Station incharge officer is required','regex_match'=>'Only characters and numbers are allowed']);
        $this->form_validation->set_rules('phone','Mobile number','required|numeric|exact_length[10]',['required'=>'Station mobile number is required','regex_match'=>'Only characters and numbers are allowed']);
         if($this->form_validation->run() ==TRUE) {
            $sname = trim($this->input->post('sname'));
            $siofficer = trim($this->input->post('siofficer'));
            $phone = trim($this->input->post('phone'));
            $cid = trim($this->input->post('cid'));
         
            if(!empty($cid)) {
                      $db = array(
                        'station_name'=>$sname,
                        'incharge_officer'=>$siofficer,
                        'phoneno'=>$phone,
                        'modified_at'=>date('Y-m-d H:i:s')
                      
                );
                $update = $this->master_db->updateRecord('police',$db,['po_id'=>$cid]);
                  if($update >0) {
                        $resul = array('status'   => true, 'msg' =>'Updated successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }else {
                   $db = array(
                        'station_name'=>$sname,
                        'incharge_officer'=>$siofficer,
                        'phoneno'=>$phone,
                        'created_at'=>date('Y-m-d H:i:s')
                      
                );
                $res=$this->master_db->insertRecord('police',$db);
                if($res >0) {
                        $resul = array('status'   => true, 'msg' =>'Inserted successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }
           
         }else {
                $resul = array(
                     'formerror'   => false,
                    'phone_error' => form_error('phone'),
                    'siofficer_error' => form_error('siofficer'),
                    'sname_error' => form_error('sname'),
                   
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
         }
         echo json_encode($resul);
    }
    public function setpoliceStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('police', ['po_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('police', $where_data, array('po_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('police', $where_data, array('po_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }

    /* Celebrities  */
    public function celebrities() {
        $this->load->view('masters/celebrities/celebrities', $this->data);
    }
    public function getCelebritieslist() {
        $where = "where c.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (c.name like '%$val%') ";
            $where.= " or (at.art_name like '%$val%') ";
            $where.= " or (ci.cname like '%$val%') ";
            $where.= " or (c.name like '%$val%') ";
            $where.= " or (c.experience like '%$val%') ";
            $where.= " or (c.totalfans like '%$val%') ";
            $where.= " or (c.phone like '%$val%') ";
        }
        $order_by_arr[] = "c.name";
        $order_by_arr[] = "";
        $order_by_arr[] = "c.c_id";
        $order_by_def = " order by c.c_id desc";
        $query = "select at.art_name,ci.cname,c.name,c.experience,c.totalfans,c.phone,c.c_id as id,c.status from celebrities c left join arttype at on at.art_id = c.art_type left join cities ci on ci.id = c.city_id " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
           
            $action = '<a href=' . base_url() . "master/editcelebrities/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";


            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->name;
            $sub_array[] = $r->art_name;
            $sub_array[] = $r->experience;
            $sub_array[] = $r->totalfans;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->phone;
            
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function celebritiesadd() {
        $this->data['arttype'] = $this->master_db->getRecords('arttype',['status'=>0],'*');
        $this->data['cities'] = $this->master_db->getRecords('cities',['status'=>0],'*');
        $this->load->view('masters/celebrities/celebritiesadd', $this->data);
    }
    public function editcelebrities() {
        $id = icchaDcrypt($this->uri->segment(3));
        $this->data['arttype'] = $this->master_db->getRecords('arttype',['status'=>0],'*');
        $this->data['cities'] = $this->master_db->getRecords('cities',['status'=>0],'*');
        //echo $id;exit;
        $this->data['celebrities'] = $this->master_db->getRecords('celebrities', ['c_id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->load->view('masters/celebrities/celebritiesedit', $this->data);
    }
    public function celebritiessave() {
        //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('arttype','Art type','required',['required'=>'Art type is required',]);
        $this->form_validation->set_rules('city','City','required',['required'=>'City is required']);
        $this->form_validation->set_rules('name','Celebrity name','required|regex_match[/^([A-Za-z0-9 ])+$/i]',['required'=>'Celebrity name is required','regex_match'=>'Only characters and numbers are allowed']);
        $this->form_validation->set_rules('experience','Experience','required',['required'=>'Experience is required','numeric'=>'Only numeric numbers are allowed']);
        $this->form_validation->set_rules('totalfans','Total Fans','required|numeric',['required'=>'Total Fans is required','numeric'=>'Only numeric numbers are allowed']);
        $this->form_validation->set_rules('phone','Mobile number','required|numeric|exact_length[10]',['required'=>'Station mobile number is required','regex_match'=>'Only characters and numbers are allowed']);
         if($this->form_validation->run() ==TRUE) {
            $name = trim($this->input->post('name'));
            $arttype = trim($this->input->post('arttype'));
            $city = trim($this->input->post('city'));
            $phone = trim($this->input->post('phone'));
            $totalfans = trim($this->input->post('totalfans'));
            $experience = trim($this->input->post('experience'));
            $cid = trim($this->input->post('cid'));
         
            if(!empty($cid)) {
                      $db = array(
                        'name'=>$name,
                        'art_type'=>$arttype,
                        'experience'=>$experience,
                        'totalfans'=>$totalfans,
                        'city_id'=>$city,
                        'phone'=>$phone,
                        'modified_at'=>date('Y-m-d H:i:s')
                      
                );
                $update = $this->master_db->updateRecord('celebrities',$db,['c_id'=>$cid]);
                  if($update >0) {
                        $resul = array('status'   => true, 'msg' =>'Updated successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }else {
                   $db = array(
                        'name'=>$name,
                        'art_type'=>$arttype,
                        'experience'=>$experience,
                        'totalfans'=>$totalfans,
                        'city_id'=>$city,
                        'phone'=>$phone,
                        'created_at'=>date('Y-m-d H:i:s')
                      
                );
                $res=$this->master_db->insertRecord('celebrities',$db);
                if($res >0) {
                        $resul = array('status'   => true, 'msg' =>'Inserted successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }
           
         }else {
                $resul = array(
                     'formerror'   => false,
                    'phone_error' => form_error('phone'),
                    'arttype_error' => form_error('arttype'),
                    'name_error' => form_error('name'),
                    'experience_error' => form_error('experience'),
                    'totalfans_error' => form_error('totalfans'),
                    'city_error' => form_error('city'),
                   
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
         }
         echo json_encode($resul);
    }
    public function setcelebritiesStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('celebrities', ['c_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('celebrities', $where_data, array('c_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('celebrities', $where_data, array('c_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
     /* Celebrities  */
    public function psychiatrist() {
        $this->load->view('masters/psychiatrist/psychiatrist', $this->data);
    }
    public function getPsychiatristlist() {
        $where = "where p.status !=2";
        if (isset($_POST["search"]["value"]) && !empty($_POST["search"]["value"])) {
            $val = trim($_POST["search"]["value"]);
            $where.= " and (p.dname like '%$val%') ";
            $where.= " or (p.fstudy like '%$val%') ";
            $where.= " or (p.experience like '%$val%') ";
            $where.= " or (p.phone like '%$val%') ";
            $where.= " or (c.cname like '%$val%') ";
           
        }
        $order_by_arr[] = "p.dname";
        $order_by_arr[] = "";
        $order_by_arr[] = "p.p_id";
        $order_by_def = " order by p.p_id desc";
        $query = "select p.dname,p.fstudy,c.cname,p.experience,p.phone,p.p_id as id,p.status from psychiatrist p left join cities c on c.id = p.city_id " . $where . "";
        $fetchdata = $this->home_db->rows_by_paginations($query, $order_by_def, $order_by_arr);
        //echo $this->db->last_query();exit;
        $data = array();
        $i = $_POST["start"] + 1;
        foreach ($fetchdata as $r) {
            $action = "";
            $sub_array = array();
           
            $action = '<a href=' . base_url() . "master/editpsychiatrist/" . icchaEncrypt(($r->id)) . "" . ' class="btn btn-primary" title="Edit Details"><i class="fas fa-pencil-alt"></i></a>&nbsp;';
            if ($r->status == 0) {
                $action.= "<button title='Deactive' class='btn btn-info' onclick='updateStatus(" . $r->id . ", 1)' ><i class='fas fa-times-circle'></i></button>&nbsp;";
            } else {
                $action.= "<button title='Active' class='btn btn-warning' onclick='updateStatus(" . $r->id . ", 0)' ><i class='fas fa-check'></i></button>&nbsp;";
            }
            $action.= "<button title='Delete' class='btn btn-danger' onclick='updateStatus(" . $r->id . ", 2)' ><i class='fas fa-trash'></i></button>&nbsp;";


            $sub_array[] = $i++;
            $sub_array[] = $action;
            $sub_array[] = $r->dname;
            $sub_array[] = $r->fstudy;
            $sub_array[] = $r->experience;
            $sub_array[] = $r->cname;
            $sub_array[] = $r->phone;
            
            $data[] = $sub_array;
        }
        $res = $this->home_db->run_manual_query_result($query);
        $total = count($res);
        $output = array("draw" => intval($_POST["draw"]), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $data);
        $output['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($output);
    }
    public function psychiatristadd() {
        $this->data['arttype'] = $this->master_db->getRecords('arttype',['status'=>0],'*');
        $this->data['cities'] = $this->master_db->getRecords('cities',['status'=>0],'*');
        $this->load->view('masters/psychiatrist/psychiatristadd', $this->data);
    }
    public function editpsychiatrist() {
        $id = icchaDcrypt($this->uri->segment(3));
        $this->data['cities'] = $this->master_db->getRecords('cities',['status'=>0],'*');
        //echo $id;exit;
        $this->data['psychiatrist'] = $this->master_db->getRecords('psychiatrist', ['p_id' => $id], '*');
        //echo $this->db->last_query();exit;
        $this->load->view('masters/psychiatrist/psychiatristedit', $this->data);
    }
    public function psychiatristsave() {
        //echo "<pre>";print_r($_POST);exit;
        $this->load->library('form_validation');
       
       
        $this->form_validation->set_rules('city','City','required',['required'=>'City is required']);
        $this->form_validation->set_rules('name','Doctor name','required|regex_match[/^([A-Za-z0-9 ])+$/i]',['required'=>'Doctor name is required','regex_match'=>'Only characters and numbers are allowed']);
        $this->form_validation->set_rules('experience','Experience','required',['required'=>'Experience is required','numeric'=>'Only numeric numbers are allowed']);
       $this->form_validation->set_rules('fstudy','Field of Study','required',['required'=>'Field of Study']);
        $this->form_validation->set_rules('phone','Mobile number','required|numeric|exact_length[10]',['required'=>'Mobile number is required','regex_match'=>'Only characters and numbers are allowed']);
         if($this->form_validation->run() ==TRUE) {
            $name = trim($this->input->post('name'));
            $fstudy = trim($this->input->post('fstudy'));
            $city = trim($this->input->post('city'));
            $phone = trim($this->input->post('phone'));
            $experience = trim($this->input->post('experience'));
            $cid = trim($this->input->post('cid'));
         
            if(!empty($cid)) {
                      $db = array(
                        'dname'=>$name,
                        'fstudy'=>$fstudy,
                        'experience'=>$experience,
                        'city_id'=>$city,
                        'phone'=>$phone,
                        'modified_at'=>date('Y-m-d H:i:s')
                      
                );
                $update = $this->master_db->updateRecord('psychiatrist',$db,['p_id'=>$cid]);
                  if($update >0) {
                        $resul = array('status'   => true, 'msg' =>'Updated successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }else {
                   $db = array(
                        'dname'=>$name,
                        'fstudy'=>$fstudy,
                        'experience'=>$experience,
                        'city_id'=>$city,
                        'phone'=>$phone,
                        'created_at'=>date('Y-m-d H:i:s')
                      
                );
                $res=$this->master_db->insertRecord('psychiatrist',$db);
                if($res >0) {
                        $resul = array('status'   => true, 'msg' =>'Inserted successfully','csrf_token'=> $this->security->get_csrf_hash());
                }
                else {
                    $resul = array('status'   => false,'msg' =>'Error in inserted','csrf_token'=> $this->security->get_csrf_hash());  
                }
            }
           
         }else {
                $resul = array(
                     'formerror'   => false,
                    'phone_error' => form_error('phone'),
                    'name_error' => form_error('name'),
                    'experience_error' => form_error('experience'),
                    'fstudy_error' => form_error('fstudy'),
                    'city_error' => form_error('city'),
                   
                    'csrf_token'=> $this->security->get_csrf_hash()
                );
         }
         echo json_encode($resul);
    }
    public function setpsychiatristStatus() {
        $id = trim($this->input->post('id'));
        //echo "<pre>";print_r($_POST);exit;
        $status = trim($this->input->post('status'));
        if ($status == 2) {
            $this->master_db->deleterecord('psychiatrist', ['p_id' => $id]);
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 1) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('psychiatrist', $where_data, array('p_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        } else if ($status == 0) {
            $where_data = array('status' => $status, 'modified_at' => date('Y-m-d H:i:s'),);
            $this->master_db->updateRecord('psychiatrist', $where_data, array('p_id' => $id));
            echo json_encode(['status' => 1, 'csrf_token' => $this->security->get_csrf_hash() ]);
        }
    }
}
?>