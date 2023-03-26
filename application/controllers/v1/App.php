<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST,DELETE,UPDATE");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header('Content-type: application/json; charset=UTF-8');
class App extends CI_Controller {
	protected $data;
      public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
        parent::__construct();
        $this->load->helper('utility_helper');
        $this->load->model('master_db');   
        $this->load->model('home_db'); 
  }
  public function register() {
            $result = array('status'=>'failure','msg'=>'Required fields are missing.');
            $bodys = file_get_contents('php://input');
            $data = json_decode($bodys, true);
            $phone = trim(preg_replace('!\s+!', '',@$data['phone']));
            $fcm_id = trim(preg_replace('!\s+!', '',@$data['fcm_id']));
            if(!empty($phone) && !empty($fcm_id)) {
                $getPhone = $this->master_db->getRecords('users',['mno'=>$phone],'*');
                if(count($getPhone) >0) {
                     $lg['login_id'] =$getPhone[0]->u_id;
                           $lg['last_login'] = time()+10;
                           $this->master_db->insertRecord('login_report',$lg);
                    $otp = rand(1234,9999);
                      $message = "Dear ".ucfirst($getPhone[0]->uname)." Your OTP is ".$otp." - Regards, Team Padalekhani. Powered by Savithru.";
                         require_once("includes/smsAPI.php");
                         $mclass = new sendSms();
                        $res = $mclass->sendSmsToUser($message,$phone);
                        $this->master_db->updateRecord('users',['otp'=>$otp],['mno'=>$phone]);
                    $result = ['status'=>'success','msg'=>'otp sent to mobile number','user_name'=>$getPhone[0]->uname];
                }else {
                    $otp = rand(1234,9999);
                    $db['mno'] = $phone;
                    $db['otp'] = $otp;
                    $db['fcm_id'] = $fcm_id;
                    $db['created_at'] = date('Y-m-d H:i:s');
                    $in = $this->master_db->insertRecord('users',$db);
                    if($in >0) {
                           $lg['login_id'] = $in;
                           $lg['last_login'] = time()+10;
                           $this->master_db->insertRecord('login_report',$lg);
                           $message = "Dear admin Your OTP is ".$otp." - Regards, Team Padalekhani. Powered by Savithru.";
                         require_once("includes/smsAPI.php");
                         $mclass = new sendSms();
                        $res = $mclass->sendSmsToUser($message,$phone);
                        $result = ['status'=>'success','msg'=>'otp sent to mobile number','user_name'=>''];
                    }else {
                        $result = ['status'=>'failure','msg'=>'Error in inserting'];
                    }
                }
            }
         echo json_encode($result);
    }
    public function verifyOtp() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $otp = trim(preg_replace('!\s+!', '',@$data['otp']));
        $phone = trim(preg_replace('!\s+!', '',@$data['phone']));
        if(!empty($otp) && !empty($phone) ) {
             $getPhone = $this->master_db->getRecords('users',['mno'=>$phone,'otp'=>$otp],'*');
             //echo $this->db->last_query();exit;
             if(count($getPhone) >0) {
                $result =['status'=>'success','msg'=>'otp verified successfully','user_id'=>$getPhone[0]->u_id,'user_name'=>$getPhone[0]->uname];
             }else {
                $result =['status'=>'failure','msg'=>'OTP not verified'];
             }
        }
        echo json_encode($result);
    }
    public function resendOtp() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $phone = trim(preg_replace('!\s+!', '',@$data['phone']));
        if(!empty($phone) ) {
             $getPhone = $this->master_db->getRecords('users',['mno'=>$phone],'*');
             if(count($getPhone) >0) {
                $otp = rand(12345,99999);
               // $message = "Dear Devotees, Your OTP is ".$otp." - Regards, Sri Ramamrita Tarangini Trust.";
                $message = "Dear ".ucfirst($getPhone[0]->uname)." Your OTP is ".$otp." - Regards, Team Padalekhani. Powered by Savithru.";
                require_once("includes/smsAPI.php");
                $mclass = new sendSms();
                $res = $mclass->sendSmsToUser($message,$phone);
                $this->master_db->updateRecord('users',['otp'=>$otp],['mno'=>$phone]);
                $result =['status'=>'success','msg'=>'otp sent to mobile number'];
             }else {
                $result =['status'=>'failure','msg'=>'OTP not sent'];
             }
        }
        echo json_encode($result);
    }
    public function interestlist() {
        $category = $this->master_db->getRecords('category',['status'=>0],'id,cname as name');
        if(count($category) >0) {
            $result = ['interests'=>$category];
        }else {
            $result = ['interests'=>[]];
        }
        echo json_encode($result);
    }
    public function profile() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$data['user_id']));
        if(!empty($user_id)) {
            $getUser = $this->master_db->getRecords('users',['status'=>0,'u_id'=>$user_id],'u_id as user_id,uname as user_name, emailid as email_id,mno as mobile_number,profileimg as profile_pic');
            $getCat = $this->master_db->sqlExecute('select id,cname as name from category where status =0 order by id desc');
            if(!empty($getUser[0]->profile_pic)) {

                $getUser[0]->profile_pic =base_url().$getUser[0]->profile_pic;
            }else {
                $getUser[0]->profile_pic ="";
            }
            if(count($getCat) >0) {
              foreach ($getCat as $key => $value) {
                $id = $value->id;
                $getInter = $this->master_db->sqlExecute('select * from groups g left join group_category gc on gc.group_id = g.group_id left join category c on c.id = gc.cat_id where c.id ='.$id.' ');

                if(count($getInter) >0) {
                  $value->in_list = true;
                }else {
                  $value->in_list = false;
                }
              }
            }
            
            $result =['users'=>$getUser,'my_interest'=>$getCat];
        }
        echo json_encode($result);
    }
    public function updateprofile() {
        if(!empty($_POST['user_id']) && !empty($_POST['name']) && !empty($_POST['email'])) {
           $user_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('user_id', true))));
            $getUser = $this->master_db->getRecords('users',['status'=>0,'u_id'=>$user_id],'*');
            if(count($getUser) >0) {
             $name = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('name', true))));
             $email = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('email', true))));
             $db['uname'] = $name;
             $db['emailid'] = $email;
                        if (!empty($_FILES['profile_pic']['name'])) {
                            $uploadPath = './assets/groupimg/';
                            $config['upload_path'] = $uploadPath;
                            $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                            $ext = pathinfo($_FILES["profile_pic"]['name'], PATHINFO_EXTENSION);
                            $new_name = "MID" . rand(11111, 99999) . '.' . $ext;
                            $config['file_name'] = $new_name;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('profile_pic')) {
                                $array1 = ['status'=>false,'msg'=>"Profile Image : ".$this->upload->display_errors()];
                                echo json_encode($array1);exit;
                            } else {
                                $upload_data1 = $this->upload->data();
                                $db['profileimg'] = 'assets/groupimg/' . $upload_data1['file_name'];
                            }
                        }
                $up = $this->master_db->updateRecord('users',$db,['u_id'=>$user_id]);
                if($up >0) {
                    $result =['status'=>'success','msg'=>'Profile updated successfully'];
                }else {
                    $up = $this->master_db->updateRecord('users',$db,['u_id'=>$user_id]);
                    $result =['status'=>'success','msg'=>'Profile updated successfully'];
                }
            }else {
                $result = ['status'=>'failure','msg'=>'User id not exists try another'];
            }
        }else {
            $result = ['status'=>'failure','msg'=>'Required fields is missing'];
        }
        echo json_encode($result);
    }
    public function updateInterest() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$data['user_id']));
        $interest_id = trim(preg_replace('!\s+!', '',@$data['interest_id']));
        if(!empty($user_id) && !empty($interest_id)) {
            $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
            if(count($getUser) >0) {
                $getList = $this->master_db->sqlExecute('select * from category where id in ("'.$interest_id.'")');
                if(count($getList) >0) {
                   $inte =explode(",", $interest_id);
                    if(is_array($inte) && !empty($inte)) {
                        foreach ($inte as $key => $value) {
                            $dbs['user_id'] = $user_id;
                            $dbs['interest_id'] = $value;
                            $dbs['created_at'] = date('Y-m-d H:i:s');
                            $in = $this->master_db->insertRecord('interests',$dbs);
                        }
                        $result = ['status'=>'success','msg'=>'Updated successfully'];
                    } 
                }else {
                    $result = ['status'=>'failure','msg'=>'Interest id not exists try another'];
                }
            }else {
                $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
            }
        }
        echo json_encode($result);
    }
    public function creategroup() {
          if(!empty($_POST['user_id']) && !empty($_POST['group_title']) && !empty($_FILES['group_pic']['name']) && !empty($_POST['people_id']) && !empty($_POST['category_id'])) {
           $user_id = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('user_id', true))));
           $group_title = trim(preg_replace('!\s+!', ' ',html_escape($this->input->post('group_title', true))));
           $people_id = $this->input->post('people_id');
           $category_id = $this->input->post('category_id');
           $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
           if(count($getUser) >0) {
                $db['user_id'] = $user_id;
               $db['group_title'] = $group_title;
               if (!empty($_FILES['group_pic']['name'])) {
                    $uploadPath = './assets/groupimg/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|PNG|JPEG|jpeg';
                    $ext = pathinfo($_FILES["group_pic"]['name'], PATHINFO_EXTENSION);
                    $new_name = "MID" . rand(11111, 99999) . '.' . $ext;
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('group_pic')) {
                        $array1 = ['status'=>false,'msg'=>"Group Image : ".$this->upload->display_errors()];
                        echo json_encode($array1);exit;
                    } else {
                        $upload_data1 = $this->upload->data();
                        $db['group_pic'] = 'assets/groupimg/' . $upload_data1['file_name'];
                    }
                }
               $db['created_at'] = date('Y-m-d H:i:s');
               $in = $this->master_db->insertRecord('groups',$db);
               if($in >0) {
                 $peoples = explode(",", $people_id);
                 $category = explode(",", $category_id);
                 if(is_array($peoples) && !empty($peoples)) {
                    foreach ($peoples as $key => $gr) {
                        $g['group_id'] = $in;
                        $g['people_id'] = $gr;
                        $this->master_db->insertRecord('group_list',$g);
                    }
                 }
                 if(is_array($category) && !empty($category)) {
                    foreach ($category as $key => $group) {
                        $new['group_id'] = $in;
                        $new['cat_id'] = $group;
                        $this->master_db->insertRecord('group_category',$new);
                    }
                 }
                  $result = ['status'=>'success','msg'=>'Inserted successfully'];
               }else {
                 $result = ['status'=>'failure','msg'=>'Error in inserting'];
               }
           }else {
            $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
           }
       }else {
            $result =['status'=>'failure','msg'=>'Required fields is missing'];
       }
       echo json_encode($result);
    }
    public function mygroup() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$datas['user_id']));
        //echo "<pre>";print_r($datas);exit;
        if(!empty($user_id)) {
            $current_timestamps = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamps);
            $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
            if(count($getUser) >0) {
                $status =0;
                $getGroup = $this->master_db->sqlExecute('select g.group_id, g.group_title,g.group_pic from groups g where g.user_id='.$user_id.'');
                if(count($getGroup) >0) {
                    foreach ($getGroup as $key => $value) {
                        $value->group_pic = base_url().$value->group_pic;
                        $id = $value->group_id;
                        $getCat = $this->master_db->sqlExecute('select c.cname as catname from group_category gc left join category c on c.id=gc.cat_id where gc.group_id='.$id.'');
                        $getPep = $this->master_db->sqlExecute('select * from group_list where group_id='.$id.'');
                        if(count($getPep) >0) {
                            foreach ($getPep as $key => $pep) {
                                $ids = $pep->people_id;
                                $getLastLogin = $this->master_db->sqlExecute('select last_login from login_report where login_id='.$ids.' order by id desc limit 1');
                                 if($getLastLogin[0]->last_login > $current_timestamp) {
                                    $status =count($getLastLogin);
                                }
                            }
                        }
                        if(count($getCat) >0) {
                            $catn = [];
                            foreach ($getCat as $key => $cat) {
                                $catn[] = $cat->catname;
                            }
                            $im = implode(",", $catn);
                            $value->category = $im;
                        }
                        $value->members = count($getPep);
                        $value->online = $status;
                    }
                    $result = ['status'=>'success','group'=>$getGroup];
                }else {
                    $result = ['status'=>'failure','msg'=>[]];
                }
            }else {
                $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
            }
        }
        echo json_encode($result);
    }
    public function psychiatristlist() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$data['user_id']));
        //echo "<pre>";print_r($datas);exit;
        if(!empty($user_id)) {
            $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
            if(count($getUser) >0) {
                $getPsh = $this->master_db->getRecords('psychiatrist',['status'=>0],'p_id as id,dname as name,fstudy as speciality,experience,phone,address,profile_pic');
                if(count($getPsh) >0) {
                    foreach ($getPsh as $key => $value) {
                        if(!empty($value->profile_pic)) {
                           $value->profile_pic = base_url().$value->profile_pic; 
                        }
                    }
                }
                $result = ['status'=>'success','msg'=>$getPsh];
            }else {
                $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
            }
        }
        echo json_encode($result);
    }
    public function groups() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$data['user_id']));
        $interest_id = trim(preg_replace('!\s+!', '',@$data['interest_id']));
       // echo "<pre>";print_r($data);exit;
        if(!empty($user_id)) {
            $status =0;
            $current_timestamps = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamps);
             $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
             //echo $this->db->last_query();exit;
            if(count($getUser) >0) {
              $whereand = "";$where ="";
              if(!empty($interest_id)) {
                $whereand .=' and gc.cat_id in ('.$interest_id.')';
                $where .='where gc.cat_id in ('.$interest_id.')';
              }
                $getGroup = $this->master_db->sqlExecute('select g.group_id, g.group_title,g.group_pic from groups g left join group_category gc on gc.group_id =g.group_id  where g.user_id='.$user_id.' '.$whereand.' group by gc.group_id');
                //echo $this->db->last_query();exit;
                  if(count($getGroup) >0) {
                    foreach ($getGroup as $key => $value) {
                      $getPeopleavail = $this->master_db->getRecords('group_list',['people_id'=>$user_id],'*');
                      if(count($getPeopleavail) >0) {
                        $value->in_group = true;
                      }else {
                        $value->in_group = false;
                      }
                        $value->group_pic = base_url().$value->group_pic;
                        $id = $value->group_id;
                        $getCat = $this->master_db->sqlExecute('select c.cname as catname from group_category gc left join category c on c.id=gc.cat_id where gc.group_id ='.$id.' '.$whereand.' ');
                        //echo $this->db->last_query();exit;
                        $getPep = $this->master_db->sqlExecute('select * from group_list where group_id='.$id.'');
                        if(count($getPep) >0) {
                            foreach ($getPep as $key => $pep) {
                                $ids = $pep->people_id;
                                $getLastLogin = $this->master_db->sqlExecute('select last_login from login_report where login_id='.$ids.' order by id desc limit 1');
                                 if($getLastLogin[0]->last_login > $current_timestamp) {
                                    $status .=count($getLastLogin);
                                }
                            }
                        }
                        if(count($getCat) >0) {
                            $catn = [];
                            foreach ($getCat as $key => $cat) {
                                $catn[] = $cat->catname;
                            }
                            $im = implode(",", $catn);
                            $value->category = $im;
                        }else {
                            $value->category ="";
                        }
                        $value->members = count($getPep);
                        $value->online = $status;
                    }
                    $result = ['status'=>'success','group'=>$getGroup];
                }else {
                    $result = ['status'=>'failure','msg'=>[]];
                }
            }else {
                $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
            }
        }
        echo json_encode($result);
    }
    public function addmembers() {
         $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $data = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$data['user_id']));
        $people_id = trim(preg_replace('!\s+!', '',@$data['people_id']));
        $group_id = trim(preg_replace('!\s+!', '',@$data['group_id']));
       // echo "<pre>";print_r($data);exit;
        if(!empty($user_id) && !empty($people_id) && !empty($group_id)) {
             $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
             if(count($getUser) >0) {
                $getGroup = $this->master_db->getRecords('groups',['group_id'=>$group_id],'*');
                if(count($getGroup) >0) {
                    $ins =[];
                    $ex = explode(",", $people_id);
                    if(is_array($ex) && !empty($ex)) {
                        foreach ($ex as $key => $value) {
                           $db['group_id'] = $group_id;
                           $db['people_id'] = $value;
                         $ins[]=  $this->master_db->insertRecord('group_list',$db);
                        }
                    }
                    $result = ['status'=>'success','msg'=>count($ins).' Members added successfully'];
                }else {
                    $result = ['status'=>'failure','msg'=>'Group id not exists try another'];
                }
             }else {
                 $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
             }
        }
        echo json_encode($result);
    }
    public function peoples() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$datas['user_id']));
        $interest_id = @$datas['interest_id'];
        $current_timestamps = strtotime(date("Y-m-d H:i:s") . '- 10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamps);
        //echo "<pre>";print_r($datas);exit;
        if(!empty($user_id)) {
          $where = "";$join ="";
          if(!empty($interest_id)) {
            $join .=" left join groups g on g.user_id = u.u_id left join group_category gc on gc.group_id = g.group_id left join category c on c.id = gc.cat_id";
            $where .= 'where gc.cat_id in ('.$interest_id.') group by gc.group_id';
          }
          $getUser = $this->master_db->sqlExecute('select u.u_id as id,u.uname,profileimg from users u '.$join.' '.$where.'');
          //echo $this->db->last_query();exit;
          if(count($getUser) >0) {
              foreach ($getUser as $key => $value) {
                $getLastLogin = $this->master_db->sqlExecute('select last_login from login_report where login_id='.$value->id.' order by id desc limit 1');
                 if($getLastLogin[0]->last_login > $current_timestamp) {
                    $value->online =true;
                }else {
                  $value->online =false;
                }
                if(!empty($value->profileimg)) {
                  $value->profileimg = base_url().$value->profileimg;
                }else {
                  $value->profileimg = "";
                }
              }
              $result = ['status'=>'success','people'=>$getUser];
          }else {
            $result = ['status'=>'failure','msg'=>'Userid not exists try another'];
          }
        }
        echo json_encode($result);
    }
      public function postmsg() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $sender_id = trim(preg_replace('!\s+!', '',@$datas['sender_id']));
        $reciever_id = trim(preg_replace('!\s+!', '',@$datas['reciever_id']));
        $comment = trim(preg_replace('!\s+!', ' ',@$datas['comment']));
        $comment_id = trim(preg_replace('!\s+!', '',@$datas['comment_id']));
        if(!empty($sender_id) && !empty($reciever_id) && !empty($comment)) {
            $getUser = $this->master_db->getRecords('users',['u_id'=>$sender_id],'*');
            if(count($getUser) >0) {
                 if(!empty($comment_id)) {
                  $getComment = $this->master_db->getRecords('postcomment',['comment_id'=>$comment_id],'*');
                      if(count($getComment) >0) {
                          $db['sender_id'] = $sender_id;
                        $db['reciever_id'] = $reciever_id;
                          $db['comment'] = $comment;
                          $db['reply_to'] = $getComment[0]->comment;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('postcomment',$db);
                        //$this->master_db->updateRecord('postcomment',['reply_to'=>$comment],['comment_id'=>$comment_id]);
                        $result = ['status'=>'success','msg'=>'Comment posted successfully'];
                      }else {
                        $result = ['status'=>'failure','msg'=>'Comment id not exists try another'];
                      }
                    }else {
                       $db['sender_id'] = $sender_id;
                        $db['reciever_id'] = $reciever_id;
                        if(!empty($comment_id)) {
                        }else {
                          $db['comment'] = $comment;
                        }
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('postcomment',$db);
                        if($in >0) {
                          $result = ['status'=>'success','msg'=>'Comment posted successfully'];
                        }
                    }
            }else {
              $result = ['status'=>'failure','msg'=>'Sender id not exists'];
            }
        }
        echo json_encode($result);
    }
    public function postgroupmsg() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $sender_id = trim(preg_replace('!\s+!', '',@$datas['sender_id']));
        $group_id = trim(preg_replace('!\s+!', '',@$datas['group_id']));
        $comment = trim(preg_replace('!\s+!', ' ',@$datas['comment']));
        $comment_id = trim(preg_replace('!\s+!', '',@$datas['comment_id']));
        if(!empty($sender_id) && !empty($group_id) && !empty($comment)) {
            $getUser = $this->master_db->getRecords('users',['u_id'=>$sender_id],'*');
            if(count($getUser) >0) {
               $getPeople = $this->master_db->getRecords('group_list',['group_id'=>$group_id,'people_id'=>$sender_id],'*');
               //echo $this->db->last_query();exit;
              if(count($getPeople) >0) {
                   if(!empty($comment_id)) {
                      $getComment = $this->master_db->getRecords('groupmsg',['gid'=>$comment_id],'*');
                      if(count($getComment) >0) {
                        $db['sender_id'] = $sender_id;
                        $db['group_id'] = $group_id;
                        $db['comment'] = $comment;
                        $db['reply_to'] = $getComment[0]->comment;
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('groupmsg',$db);
                        $result = ['status'=>'success','msg'=>'Comment posted successfully'];
                      }else {
                        $result = ['status'=>'failure','msg'=>'Comment id not exists try another'];
                      }
                    }else {
                       $db['sender_id'] = $sender_id;
                        $db['group_id'] = $group_id;
                        if(!empty($comment_id)) {
                        }else {
                          $db['comment'] = $comment;
                        }
                        $db['created_at'] = date('Y-m-d H:i:s');
                        $in = $this->master_db->insertRecord('groupmsg',$db);
                        if($in >0) {
                          $result = ['status'=>'success','msg'=>'Comment posted successfully'];
                        }
                    }
              }else {
                $result = ['status'=>'failure','msg'=>'People id not exists'];
              }
            }else {
              $result = ['status'=>'failure','msg'=>'Sender id not exists'];
            }
        }
        echo json_encode($result);
    }
    public function groupinfo() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$datas['user_id']));
        $group_id = trim(preg_replace('!\s+!', '',@$datas['group_id']));
         $current_timestamps = strtotime(date("Y-m-d H:i:s") . '- 10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamps);
        if(!empty($user_id) && !empty($group_id)) {
          $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
            if(count($getUser) >0) {
              $getGroup = $this->master_db->getRecords('groups',['group_id'=>$group_id],'group_title as title,group_pic');
              $getMembers = $this->master_db->sqlExecute('select u.u_id as id,u.uname as name,u.profileimg as profile_pic,gl.people_id from groups g left join group_list gl on gl.group_id = g.group_id left join users u on u.u_id = gl.people_id where g.user_id ='.$user_id.' ');
              if(count($getGroup) >0) {
                  if(!empty($getGroup[0]->group_pic)) {
                    $getGroup[0]->group_pic = base_url().$getGroup[0]->group_pic;
                  }else {
                    $getGroup[0]->group_pic = "";
                  }
                  if(count($getMembers) >0) {
                    foreach ($getMembers as $key => $value) {
                      $getLastLogin = $this->master_db->sqlExecute('select last_login from login_report where login_id='.$value->people_id.' order by id desc limit 1');
                       if($getLastLogin[0]->last_login > $current_timestamp) {
                            $value->online =true;
                        }else {
                          $value->online =false;
                        }
                      if(!empty($value->profile_pic)) {
                        $value->profile_pic = base_url().$value->profile_pic;
                      }else {
                        $value->profile_pic = "";
                      }
                    }
                  }
                  $getGroup[0]->group_link ="";
                  $getGroup[0]->members =count($getMembers);
                  $getGroup[0]->people = $getMembers;

                  $result = ['status'=>'success','data'=>$getGroup];
              }else {
                $result = ['status'=>'failure','msg'=>'Group id not exists try another'];
              }
            }else {
              $result = ['status'=>'failure','msg'=>'User id not exists'];
            }
        }
        echo json_encode($result);
    }
    public function chat() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $sender_id = trim(preg_replace('!\s+!', '',@$datas['sender_id']));
        $reciever_id = trim(preg_replace('!\s+!', '',@$datas['reciever_id']));
        if(!empty($sender_id) && !empty($reciever_id)) {
            $getUsers = $this->master_db->getRecords('users',['u_id'=>$sender_id],'*');
            if(count($getUsers) >0) {
              $getCom = $this->master_db->sqlExecute('select * from postcomment p where p.sender_id ='.$sender_id.'  order by p.comment_id desc');
              if(count($getCom) >0) {
              	$getComment = $this->master_db->sqlExecute('select p.comment_id, p.comment,p.created_at as posted_date,p.reply_to,p.sender_id from postcomment p where p.sender_id in ('.$sender_id.','.$reciever_id.') and p.reciever_id in ('.$reciever_id.','.$sender_id.') order by p.comment_id asc');
              	//echo $this->db->last_query();exit;
	              	 if(count($getComment)>0) {
	                foreach ($getComment as $key => $value) {
                    $cid = $value->comment_id;
                    $getUse = $this->master_db->getRecords('postcomment',['sender_id'=>$value->sender_id],'*');
                    if(count($getUse) >0) {
                      $value->type ="me";
                    }else {
                      $value->type ="other";
                    }
	                  $value->posted_date = date('d-m-Y h:i A',strtotime($value->posted_date));
	                  //$value->type ="sender";
	                }
	              }
              	$result = ['status'=>'success','chat'=>$getComment];
              }else {
              	$getComment = $this->master_db->sqlExecute('select p.comment_id, p.comment,p.created_at as posted_date,p.reply_to,p.sender_id from postcomment p where p.sender_id in ('.$sender_id.','.$reciever_id.') and p.reciever_id in ('.$reciever_id.','.$sender_id.') order by p.comment_id asc');
//echo $this->db->last_query();exit;
              	$result = ['status'=>'success','chat'=>$getComment];
	              	 if(count($getComment)>0) {
	                foreach ($getComment as $key => $value) {
	                	$cid = $value->comment_id;
                      $getUse = $this->master_db->getRecords('postcomment',['sender_id'=>$value->sender_id],'*');
                    if(count($getUse) >0) {
                      $value->type ="me";
                    }else {
                      $value->type ="other";
                    }
                 
	                  $value->posted_date = date('d-m-Y h:i A',strtotime($value->posted_date));
	                  //$value->type ="sender";
	                }
	              }
              }
            }else {
              $result = ['status'=>'failure','msg'=>'User id not exists'];
            }
        }
        echo json_encode($result);
    }
    public function groupchat() {
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$datas['user_id']));
        $group_id = trim(preg_replace('!\s+!', '',@$datas['group_id']));
        if(!empty($user_id) && !empty($group_id)) {
            $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'u_id as user_id,uname as user_name,profileimg as profile_pic');
            if(count($getUser) >0) {
              $getPeople = $this->master_db->getRecords('group_list',['group_id'=>$group_id,'people_id'=>$user_id],'*');
              if(count($getPeople) >0) {
                   $getComments = $this->master_db->sqlExecute('select u.u_id as user_id,u.uname as user_name,u.profileimg as profile_pic,g.gid as comment_id,g.comment,g.created_at as posted_date, g.reply_to as reply_to_msg from groupmsg g left join users u on u.u_id = g.sender_id  where g.group_id='.$group_id.'');
              //echo $this->db->last_query();exit;
                  if(count($getComments) >0) {
                    foreach ($getComments as $key => $value) {
                      $id = $value->comment_id;
                      $getUsers = $this->master_db->sqlExecute('select u.uname as username from groupmsg g left join users u on u.u_id=g.sender_id where g.gid='.$id.'');
                      $getUserss = $this->master_db->sqlExecute('select u.uname as username from groupmsg g left join users u on u.u_id=g.sender_id where g.gid='.$id.' and g.sender_id='.$user_id.'');
                      //echo $this->db->last_query();
                      if(is_array($getUsers) && !empty($getUsers)) {
                      
                        $value->replay_to_username = $getUsers[0]->username;
                      }else {
                       $value->replay_to_username = "";
                      }
                      if(is_array($getUserss) && !empty($getUserss)) {
                            $value->type ="me";
                      }else {
                         $value->type ="other";
                      }
                      $value->posted_date = date('d-m-Y h:i A',strtotime($value->posted_date));
                      if(!empty($value->profile_pic)) {
                        $value->profile_pic = base_url().$value->profile_pic;
                      }else {
                        $value->profile_pic = "";
                      }
                    }
                    $result = ['status'=>'success','chat'=>$getComments];
                  } else {
                    $result = ['status'=>'success','chat'=>[]];
                  }
              }else {
                $result = ['status'=>'failure','msg'=>'People id not exists'];
              }
             
            }else {
              $result = ['status'=>'failure','msg'=>'User id not exists'];
            }
        }
        echo json_encode($result);
    }
    public function token() {
      $this->load->library('agora');
      $appid = "25d49efea7d940529324ad7ee265c632";
      $appcert = "7f0d7d280ea244d38d3db49698c9e185";
      $expireTimeInSeconds = 86400;
      $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
      $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $result = array('status'=>'failure','msg'=>'Required fields are missing.');
        $bodys = file_get_contents('php://input');
        $datas = json_decode($bodys, true);
        $user_id = trim(preg_replace('!\s+!', '',@$datas['user_id']));
        if(!empty($user_id)) {
           $uid = $user_id;
           $cname = "ChatVtalks";
           $role = 0;
            $getUser = $this->master_db->getRecords('users',['u_id'=>$user_id],'*');
            if(count($getUser) >0) {
              $gettoken = $this->master_db->sqlExecute('select token from tokens where uid='.$user_id.' order by id desc limit 1');
              $token = $this->agora->buildTokenWithUid($appid, $appcert, $cname, $uid, $role, $privilegeExpiredTs);
              if(count($gettoken) >0) {
                $update = $this->master_db->updateRecord('tokens',['token'=>$token,'cname'=>$cname],['uid'=>$user_id]);
                if($update >0) {
                    $getupdate = $this->master_db->getRecords('tokens',['uid'=>$user_id],'token');
                    $result = ['status'=>'success','token'=>$getupdate[0]->token,'appid'=>$appid,'cname'=>$cname];
                }
              }else {
                  $db['uid'] = $user_id;
                  $db['token'] = $token;
                  $db['cname'] = $cname;
                  $db['created_at'] = date('Y-m-d H:i:s');
                  $in = $this->master_db->insertRecord('tokens',$db);
                  if($in >0) {
                     $getupdate = $this->master_db->getRecords('tokens',['uid'=>$user_id],'token');
                     $result =['status'=>'success','msg'=>'Token generated successfully','token'=>$getupdate[0]->token,'appid'=>$appid,'cname'=>$cname];
                  }
              }
            }else {
              $result = ['status'=>'failure','msg'=>'User id not exists'];
            }
        }
        echo json_encode($result);
    }
}
?>