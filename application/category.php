<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- BEGIN HEAD-->

<head>

    <meta charset="UTF-8" />
    <title><?php echo title; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/style.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/main.css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/theme.css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>css/MoneAdmin.css" />
    <link rel="stylesheet" href="<?php echo asset_url(); ?>plugins/Font-Awesome/css/font-awesome.css" /> -->
    <?php echo $updatelogin; ?>
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo asset_url(); ?>css/flexigrid.css" />-->
    <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
	<link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=asset_url()?>/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo asset_url()?>css/jquery-ui.css">
</head>
<!-- END  HEAD-->
<!-- BEGIN BODY-->

<body class="padTop53 ">

    <!-- MAIN WRAPPER -->
    <div id="wrap">
        <div id="main-wrapper">

            <!-- HEADER SECTION -->
            <?php echo $header; ?>
            <!-- END HEADER SECTION -->



            <!-- MENU SECTION -->
            <?php echo $left; ?>
            <!--END MENU SECTION -->


            <!--PAGE CONTENT -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Categories</h3>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Masters</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
						<div class="d-flex mt-2 justify-content-end">
							<a href="<?= base_url() ?>master/category_add" class="btn btn-info"><i class="mdi mdi-plus"></i> ADD Category</a>
						 </div>
                    </div>
                </div>
                <div class="container-fluid" id="content">

                 <div class="row">
                                                   
<div class="col-xs-12 col-sm-3 col-lg-3">
						
                                </div>

                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                      <table id="example2" class="table table-bordered table-hover data-tables"
                               data-options='{ "paging": false; "searching":false}'>
                            <thead>
                            <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                            </tr>
                            </thead>
                            <tbody>
                          
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                            </tr>
                            </tfoot>
                        </table>
                </div>
                            
</div>

                


                </div>
                <!--END PAGE CONTENT -->


            </div>
        </div>
    </div>
    <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <div id="footer">
        <p>&copy; <?php echo fottertitle; ?></p>
    </div>
    <!--END FOOTER -->
    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo asset_url(); ?>plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

    <script src="<?php echo asset_url(); ?>libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo asset_url(); ?>libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo asset_url(); ?>libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?php echo asset_url(); ?>dist/js/app.min.js"></script>
    <script src="<?php echo asset_url(); ?>dist/js/app.init.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo asset_url(); ?>libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo asset_url(); ?>dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo asset_url(); ?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo asset_url(); ?>dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- Chart JS -->
    <script src="<?php echo asset_url(); ?>dist/js/pages/dashboards/dashboard1.js"></script>

    <script src="<?php echo asset_url(); ?>libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo asset_url(); ?>dist/js/pages/datatable/custom-datatable.js"></script>
    <script src="<?php echo asset_url(); ?>dist/js/pages/datatable/datatable-basic.init.js"></script>


    <script type="text/javascript" src="<?php echo asset_url(); ?>flexigrid.js"></script>
    <script type="text/javascript">
    

		$(function () {
              $('#example1').DataTable();
          });

            $(document).ready(function() {
        $('#example-with-json-button').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'JSON',
                    action: function ( e, dt, button, config ) {
                        var data = dt.buttons.exportData();

                        $.fn.dataTable.fileSave(
                            new Blob( [ JSON.stringify( data ) ] ),
                            'Export.json'
                        );
                    }
                }
            ]
        } );
    } );

			function changestatus(st, id) {
				var base_url = '<?php echo base_url(); ?>';
				// alert(st);
				switch (st) {
					case 0:
						var msg = "Are you sure,you want to activate ?";
						break;
					case 1:
						var msg = "Are you sure,you want to deactivate ?";
						break;
					case 2:
						var msg = "Are you sure,you want to delete ?";
						break;
				}
				if (confirm(msg)) {
					$.ajax({
						type: "POST",
						url: base_url + "master/category_status",
						data: {
							items: id,
							status: st
						},
						success: function(data) {
							$('#DataTableValue').html(data);
							$('#example1').DataTable();
						}
					});
				}
			}	
			function new_collectionstatus(st, id) {
				var base_url = '<?php echo base_url(); ?>';
				// alert(st);
				switch (st) {
					case 0:
						var msg = "Are you sure,you want to Add in new colection ?";
						break;
					case 1:
						var msg = "Are you sure,you want to New Collection ?";
						break;
					
				}
				if (confirm(msg)) {
					$.ajax({
						type: "POST",
						url: base_url + "master/new_collection_status",
						data: {
							items: id,
							status: st
						},
						success: function(data) {
							$('#DataTableValue').html(data);
							$('#example1').DataTable();
						}
					});
				}
			}

        function edit(id) {
            var base_url = '<?php echo base_url(); ?>';
            document.location.href = base_url + "master/category_edit?id=" + id;
        }
    </script>
</body>
<!-- END BODY-->

</html>