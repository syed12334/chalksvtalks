<?php //echo "<pre>";print_r($category);exit;?>
<?= $header;?>
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cname-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Edit Category</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>

                          <?php
                            if(count($category)>0) {
                              ?>
                              <form action="<?= base_url().'master/categorysave';?>" id="category" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="<?= $category[0]->id;?>">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Category Name<span style="color:red">*</span></label>
                                              <input type="text" name="cname" id="cname" class="form-control" placeholder="Enter Category Name" required value="<?= $category[0]->cname;?>">
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-8 col-lg-8 col-md-8">
                                   
                                 </div>
                                  
                                 <div class="clearfix"></div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <center> <button class="btn btn-primary" type="submit" id="submit">Submit</button></center>
                                  </div>
                                <div class="clearfix"></div>
                          </div>
                       </form>
                              <?php
                            }else {
                              redirect(base_url().'category');
                            }
                          ?>
                              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


<script>
$(document).ready(function(){


  $(document).ready(function() {
     
      $("#category").validate({
            rules: {
                cname: {
                     required: true,
                     minlength:3,
                  maxlength:30,

                  
                },
  
            },
            messages: {
                cname: "Please enter category name",
                
            },
              
        });
              
            });


});
</script>