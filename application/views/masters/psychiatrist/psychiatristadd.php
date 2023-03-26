<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cname-error {
    color:red;
  }
  #processing {
    position: fixed;
    z-index:9999999;
    width: 24%;
    padding: 10px;
    right:20px;
    top:70px;
   
  }
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div id="processing"></div>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Add Psychiatrist</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                              <form id="coupons" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Cities<span style="color:red">*</span></label> 
                                             <select name="city" id="city" class="form-control">
                                               <option value="">Select City</option>
                                               <?php
                                                if(count($cities) >0) {
                                                  foreach ($cities as $key => $city) {
                                                    ?>
                                                    <option value="<?= $city->id; ?>"><?= $city->cname; ?></option>
                                                    <?php
                                                  }
                                                }
                                               ?>
                                             </select>
                                        <span id="city_error" class="text-danger"></span>
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                          <div class="form-group">
                                        <label>Doctor Name<span style="color:red">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"  placeholder="Enter Name">
                                        <span id="name_error" class="text-danger"></span>
                                      </div>
                                      </div>
                                 </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                     <div class="form-group">
                                       <label>Experience<span style="color:red">*</span></label> 
                                             <input type="text" name="experience" id="experience" class="form-control" placeholder="Enter Experience">
                                              <span id="experience_error" class="text-danger"></span>
                                     </div>
                                 </div>
                                 <div class="clearfix"></div>

                                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                         <div class="form-group">
                                       <label>Field of Study<span style="color:red">*</span></label> 
                                             <input type="text" name="fstudy" id="fstudy" class="form-control" placeholder="Enter Field of Study">
                                              <span id="fstudy_error" class="text-danger"></span>
                                     </div> 
                                    
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Mobile Number<span style="color:red">*</span></label>
                                        <input type="number" name="phone" id="phone" class="form-control"  placeholder="Enter Mobile Number" min="0" maxlength="10" minlength="10" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==10) return false;">
                                        <span id="phone_error" class="text-danger"></span>
                                      </div>
                                 </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                     
                                 </div>
                                 <div class="clearfix"></div>
                                 
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <center> <button class="btn btn-primary" type="submit" id="submit">Submit</button></center>
                                  </div>
                                <div class="clearfix"></div>
                          </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<script>



  $(document).ready(function() {
      $("#coupons").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'master/psychiatristsave';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.arttype_error !='') {
                $("#arttype_error").html(data.arttype_error);
              }else {
                $("#arttype_error").html('');
              }
              if(data.city_error !='') {
                $("#city_error").html(data.city_error);
              }else {
                $("#city_error").html('');
              }
              if(data.name_error !='') {
                $("#name_error").html(data.name_error);
              }else {
                $("#name_error").html('');
              }

              if(data.experience_error !='') {
                $("#experience_error").html(data.experience_error);
              }else {
                $("#experience_error").html('');
              }


              if(data.fstudy_error !='') {
                $("#fstudy_error").html(data.fstudy_error);
              }else {
                $("#fstudy_error").html('');
              }


              if(data.phone_error !='') {
                $("#phone_error").html(data.phone_error);
              }else {
                $("#phone_error").html('');
              }
             
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
              
               $("#city_error").html('');
               $("#name_error").html('');
               $("#experience_error").html('');
               $("#fstudy_error").html('');
               $("#phone_error").html('');

               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
                setTimeout(function() {window.location.href="<?= base_url().'psychiatrist';?>";}, 1000);
            }
          }
      });
  });
});
</script>