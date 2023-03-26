<?= $header;?>

<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                        <div class="card-title">Area</div>
                        <?php 
                            if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                        ?>
                        <button class="btn btn-info" data-toggle="modal" data-target="#areaModal" style="float: right;margin-left: 10px;"><i class="fas fa-upload" style="margin-right: 5px"></i> Upload Area</button>
                        <a class="btn btn-success" href="<?= base_url().'areaadd';?>" style="float: right;margin-bottom: 20px;margin-right: 20px"><i class="fa fa-plus"></i> Add</a>
                        <br /><br /><br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>City Name</th>
                                        <th>Area Name</th>
                                        <th>Area ID</th>
                                    <!--     <th>Created Date</th> -->                                        
                                                                                
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
</div>

<?= $footer;?>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash()); ?>
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
<script type="text/javascript">
    var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({  
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'master/getarea'?>",  
                        type:"POST",
                        data: function(d){
                            //d.form = $("#searchForm").serializeArray();
                            <?php echo "d.".$csrf['name'];?> = $(".csrf_token").val();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },       columnDefs:[  
                  {  
                       "targets":[2,3],  
                       "orderable":true,  
                  },  
                  {  
                       "targets":[0,1],  
                       "orderable":false,  
                  },
            ], 
            "drawCallback": function (response) {               
                var res = response.json;
                $(".csrf_token").val(res.csrf_token);
                
            }
                }); 
            }
            initialiseData();
             
                function updateStatus(id,status){
                       var postdata = { id : id,status : status,"<?= $this->security->get_csrf_token_name();?>":$(".csrf_token").val() } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/setareaStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                //console.log(response);
                                if(response.status == '1'){
                                    $(".csrf_token").val(response.csrf_token);
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                }else{
                                    $(".csrf_token").val(response.csrf_token);
                                     dataTable.ajax.reload( null, false ); 
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                               console.log();
                            }
                        });
            }
             $(document).ready(function() {
            $("#areaForm").on("submit",function(e) {
            e.preventDefault();
              var formdata =new FormData(this);
              $.ajax({
                  url :"<?= base_url().'excelimport/saveArea';?>",
                  method :"post",
                  dataType:"json",
                  data :formdata,
                  contentType: false,
                    cache: false,
                    processData:false,
                    success:function(data) {
                    if(data.formerror ==false) {
                      $(".csrf_token").val(data.csrf_token);
                      if(data.type_error !='') {
                        $("#file_error").html(data.file_error);
                      }else {
                        $("#file_error").html('');
                      }
                      $("#brandSubmit").prop('disabled',false);
                    }
                    else if(data.status ==false) {
                      $(".csrf_token").val(data.csrf_token);
                      $("#processing").html('<div class="alert alert-danger alert-dismissible" style="font-size: 15px!important"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
                      $("#brandSubmit").prop('disabled',false);
                    }
                    else if(data.status ==true) {
                       $(".csrf_token").val(data.csrf_token);
                       $("#file_error").html('');
                       $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
                        setTimeout(function() {window.location.href="<?= base_url().'area';?>";}, 1000);
                    }
                  }
              });
          });
        });

</script>

<div class="modal fade" id="areaModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Area</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div id="processing"></div>
          <form id="areaForm" method="post" enctype="multipart/form-data">
            <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
              <div class="form-group">
                  <label>Select file <font style="color:red">* (Only .xlsx,.csv are allowed)</font></label>
                  <input type="file" name="area" id="area" class="form-control">
                  <span id="file_error" class="text-danger"></span>
              </div>
              <button type="submit" id="brandSubmit" class="btn btn-primary">Submit</button>
              <a href="<?= app_asset_url().'formats/area.xlsx';?>" class="btn btn-success" style="margin-left: 4px"><i class="fas fa-download" style="margin-right: 6px"></i> Download Area Format</a>
          </form>
        </div>
      </div>
    </div>
  </div>