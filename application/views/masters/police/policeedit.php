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
                    <?php
                      if(count($police) >0) {
                        ?>
                          <div class="card-body">
                            <div class="card-title">Edit Police Station</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                              <form id="coupons" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="<?= $police[0]->po_id;?>">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Station Name<span style="color:red">*</span></label> 
                                             <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter Station Name" value="<?= $police[0]->station_name;?>">
                                              <span id="sname_error" class="text-danger"></span>
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Station Incharge Ofiicer<span style="color:red">*</span></label>
                                        <input type="text" name="siofficer" id="siofficer" class="form-control"  placeholder="Enter Station Incharge Officer Name" value="<?= $police[0]->incharge_officer;?>">
                                        <span id="siofficer_error" class="text-danger"></span>
                                      </div>
                                 </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Mobile Number<span style="color:red">*</span></label>
                                        <input type="number" name="phone" id="phone" class="form-control"  placeholder="Enter Mobile Number" value="<?= $police[0]->phoneno;?>" min="0" maxlength="10" minlength="10" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==10) return false;">
                                        <span id="phone_error" class="text-danger"></span>
                                      </div>
                                 </div>
                                 <div class="clearfix"></div>
                                 
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <center> <button class="btn btn-primary" type="submit" id="submit">Submit</button></center>
                                  </div>
                                <div class="clearfix"></div>
                          </div>
                       </form>
                    </div>
                        <?php
                      }else {
                        redirect(base_url().'police');
                      }
                    ?>
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
          url :"<?= base_url().'master/policesave';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
           if(data.sname_error !='') {
                $("#sname_error").html(data.sname_error);
              }else {
                $("#sname_error").html('');
              }
              if(data.siofficer_error !='') {
                $("#siofficer_error").html(data.siofficer_error);
              }else {
                $("#siofficer_error").html('');
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
                $("#siofficer_error").html('');
               $("#sname_error").html('');
               $("#phone_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
               
               
                setTimeout(function() {window.location.href="<?= base_url().'police';?>";}, 1000);
            }
          }
      });
  });


});
</script>