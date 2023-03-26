<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cid-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                        <div id="message"></div>
                           <?php 
                        if(!empty($pincodes) && is_array($pincodes)) {
                            ?>
                            <div class="card-title">Edit Pincode</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add Pincode</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if(!empty($pincodes)) {
                            ?>
                                 <form action="" id="category" method="post" style="margin-top:40px">
                                  <input type="hidden" name="id" id="pid" value="<?= $pincodes[0]->id;?>">
                     <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<div class="row">
     <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                            <label>Select City<span style="color:red">*</span></label>
                               <select name="cid" id="cid" class="form-control">
                                 <option value="">Select City</option>
                                 <?php
                                  if(count($city) >0) {
                                    foreach ($city as $value) {
                                        ?>
                                        <option value="<?= $value->id;?>" <?php if($pincodes[0]->cid == $value->id) {echo "selected";}?>><?= $value->cname;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
</div>
  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                           <div class="form-group">
                            <label>Pincode <span style="color:red">*</span></label>
                               <input type="number" name="pincode" id="pincode" class="form-control" placeholder="Eg: 560064" value="<?= $pincodes[0]->pincode?>">
                               <span id="titleerror" style="color:red"></span>
                           </div>
</div>
                            
                         <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                           
                         </div>
                         <div class="clearfix"></div>
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                             </div>
                             <div class="clearfix"></div>
                          </div> 
                       </form>
                            <?php
                          }else {
                            ?>
                               <form action="" id="category" method="post" style="margin-top:40px">
                                                                  <input type="hidden" name="id" id="pid" value="">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         
<div class="row">
   <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                            <label>Select City<span style="color:red">*</span></label>
                               <select name="cid" id="cid" class="form-control">
                                 <option value="">Select City</option>
                                 <?php
                                  if(count($city) >0) {
                                    foreach ($city as $value) {
                                        ?>
                                        <option value="<?= $value->id;?>"><?= $value->cname;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
</div>
  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                           <div class="form-group">
                            <label>Pincode<span style="color:red">*</span></label>
                               <input type="number" name="pincode" id="pincode" class="form-control" placeholder="Eg: 560064" >
                           </div>
</div>
 
<div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                          
                         </div>
                         <div class="clearfix"></div>
                            
                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                         </div>
                         <div class="clearfix"></div>
                          
                           </div>
                       </form>
                            <?php
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


<script type="text/javascript">
  $(document).ready(function() {
     
      $("#category").validate({
            rules: {
                pincode: {
                    required: true,
                    number:true,
                    minlength: 6,
                     maxlength:6,
                     
                },
                 
                cid : {
                  required:true,
            
                }
            },
            messages: {
                pincode: "The pincode must be 6 digits",
                cid: "City is required",
            },
              submitHandler: function (form) {
                  var pincode = $("#pincode").val();
                  var amount = $("#amount").val();
                  var id = $("#pid").val();
                  var cid = $("#cid").val();
                  //console.log(form);
                    $.ajax({
                        url :"<?= base_url().'master/pincodesave';?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          id:id,
                          pincode :pincode,
                          cid:cid,
                          "<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
                        },
                        beforeSend:function() {
                          $("#submit").prop('disabled',true);
                          $("#submit").text('Submitting please wait');
                        },
                        success:function(data) {
                            if(data.status ==true) {
                              $(".csrf_token").val(data.csrf_token);
                               window.location.href="<?= base_url().'pincodes';?>";
                            }else if(data.status ==false) {
                               $(".csrf_token").val(data.csrf_token);
                               $("#message").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.msg+'</div>');
                                
                            }
                        }   
                    });
         }
        });
              
            });
</script>