<?php //echo "<pre>";print_r($city);exit;?>
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
                        if(!empty($city) && is_array($city)) {
                            ?>
                            <div class="card-title">Edit City</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add City</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if(!empty($city)) {
                            ?>
                                             <form id="category" method="post" style="margin-top:40px">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="<?= $city[0]->id;?>">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Select State<span style="color:red">*</span></label>
                               <select name="state" id="state" class="form-control">
                                 <option value="">Select State</option>
                                 <?php
                                  if(count($states) >0) {
                                    foreach ($states as $value) {
                                      $id = $value->id;
                                        ?>
                                        <option value="<?= $value->id;?>" <?php if($city[0]->sid == $id) {echo "selected";}?>><?= $value->name;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
                         </div>
                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                               <div class="form-group">
                                 <label>City Name</label>
                                 <input type="text" name="city" id="city" placeholder="Eg: Bengaluru" class="form-control" value="<?= $city[0]->cname;?>">
                               </div>
                             </div>

                               <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                 <label>No of Days to deliver</label>
                                 <input type="text" name="noofdays" id="noofdays" placeholder="Enter 10 days" class="form-control" value="<?php echo $city[0]->noofdays;?>">
                               </div>
                             </div>

                             <div class="clearfix"></div>

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
                               <form id="category" method="post" style="margin-top:40px">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Select State<span style="color:red">*</span></label>
                               <select name="state" id="state" class="form-control">
                                 <option value="">Select State</option>
                                 <?php
                                  if(count($states) >0) {
                                    foreach ($states as $value) {
                                        ?>
                                        <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
                         </div>
                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                               <div class="form-group">
                                 <label>City Name</label>
                                 <input type="text" name="city" id="city" placeholder="Eg: Bengaluru" class="form-control">
                               </div>
                             </div>

                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                 <label>No of Days to deliver</label>
                                 <input type="text" name="noofdays" id="noofdays" placeholder="Eg: 2 Days" class="form-control">
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
                state: {
                    required: true,
                   
                },
                city :{
                  required:true,
                  minlength:3,
                  maxlength:30
                }
            },
            messages: {
                state: "Please select state",
                city: "City must be 3 to 30 characters long",
            },
              submitHandler: function (form) {
                  var state = $("#state").val();
                  var city = $("#city").val();
                  var id = $("#pid").val();
                  var noofdays = $("#noofdays").val();
                  //console.log(form);
                    $.ajax({
                        url :"<?= base_url().'master/savecity';?>",
                        method:"post",
                        dataType:"json",
                        data :{
                          id:id,
                          state :state,
                          city :city,
                          noofdays:noofdays,
                          "<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
                        },
                        beforeSend:function() {
                          $("#submit").prop('disabled',true);
                          $("#submit").text('Submitting please wait');
                        },
                        success:function(data) {
                            if(data.status ==true) {
                              $(".csrf_token").val(data.csrf_token);
                               window.location.href="<?= base_url().'cities';?>";
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