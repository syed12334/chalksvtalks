<?php //echo "<pre>";print_r($cities);exit;?>
<?= $header;?>
<style type="text/css">
  #state-error {
    color:red;
  }
   #city-error {
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
                        if(!empty($cities) && is_array($cities)) {
                            ?>
                            <div class="card-title">Edit Area</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add Area</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if($type =="edit") {
                            ?>
                                             <form action="" id="category" method="post" style="margin-top:40px">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="<?= $area[0]->id;?>">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Select City<span style="color:red">*</span></label>
                               <select name="city" id="city" class="form-control">
                                 <option value="">Select City</option>
                                 <?php
                                  if(count($cities) >0) {
                                    foreach ($cities as $value) {
                                      $id = $value->id;
                                        ?>
                                        <option value="<?= $value->id;?>" <?php if($id == $area[0]->cid) {echo "selected";}?>><?= $value->cname;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
                         </div>
                           

                              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                               <div class="form-group">
                                 <label>Area Name</label>
                                 <input type="text" name="area" id="area" placeholder="Eg: HSR Layout" class="form-control" value="<?=  $area[0]->areaname;?>">
                               </div>
                             </div>


                               <div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                         
                         </div>
                         <div class="clearfix"></div>
                           </div>
                       </form>
                            <?php
                          }else if($type =="add") {
                            ?>
                               <form action="" id="category" method="post" style="margin-top:40px">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Select City<span style="color:red">*</span></label>
                               <select name="city" id="city" class="form-control">
                                 <option value="">Select City</option>
                                 <?php
                                  if(count($cities) >0) {
                                    foreach ($cities as $value) {
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
                                 <label>Area Name</label>
                                 <input type="text" name="area" id="area" placeholder="Eg: HSR Layout" class="form-control">
                               </div>
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
                area: {
                    required: true,
                    minlength:3,
                    maxlength:30
                   
                },
                city :{
                  required:true,
                
                }
            },
            messages: {
                area: "Please enter area name",
                city: "Please select city",
            },
              submitHandler: function (form) {
                  var city = $("#city").val();
                  var area = $("#area").val();
                  var id = $("#pid").val();
                  //console.log(form);
                    $.ajax({
                        url :"<?= base_url().'master/savearea';?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          id:id,
                          city :city,
                          area :area,
                          "<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
                        },
                        beforeSend:function() {
                          $("#submit").prop('disabled',true);
                          $("#submit").text('Submitting please wait');
                        },
                        success:function(data) {
                            if(data.status ==true) {
                              $(".csrf_token").val(data.csrf_token);
                               window.location.href="<?= base_url().'area';?>";
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