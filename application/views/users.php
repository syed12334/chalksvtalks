<?= $header;?>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">

                        <div class="card-title">Registered Users</div>
                        
                      
                        <br /><br /><br />
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                    <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>                                        
                                        <th>Address</th>                                        
                                        <th>Terms & Condition</th>  
                                        <th>Payment ID</th>                                      
                                        <th>Created Date</th>                                        
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
                        url:"<?=base_url().'master/getuserlist'?>",  
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
                    },
                columnDefs:[  
                  {  
                       "targets":[2,3,4,5],  
                       "orderable":true,  
                  },  
                  {  
                       "targets":[0,1,6],  
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
                       var postdata = { id : id,status : status,"<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()  } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/setusersStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                //console.log(response);
                                if(response.status == '1'){
                                    //reinitialsedata();
                                    $(".csrf_token").val(response.csrf_token);
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
</script>