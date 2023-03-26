<?= $header;?>
<style type="text/css">
	#toporders {
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-webkit-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-moz-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-ms-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-o-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		background: #fff;
	}
	.topor {
		background: #f56954!important
	}
	.products {
		background: #00a65a!important
	}
	.reviews {
		background: #00c0ef!important
	}
	.reguser {
		background: #0073b7!important
	}
	#toporders h1 {
		font-weight: bold;
		font-size: 35px;
		color:#fff;
	}
	#toporders h3 {
		font-size: 20px;
		color:#fff;
	}
</style>
<div class="page has-sidebar-left bg-light height-full">
<div class="container-fluid">
        <div class="row my-3">
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="topor">
        			<h1><?= count($category);?></h1>
        			<h3>Categories</h3>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="products">
        			<h1><?= count($psychiatrist);?></h1>
        			<h3>Psychiatrist</h3>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="reviews">
        			<h1><?= count($celebrities);?></h1>
        			<h3>Celebrities</h3>
        		</div>
        	</div>
        		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="reguser">
        			<h1><?= count($states);?></h1>
        			<h3>State</h3>
        		</div>
        	</div>
        	<div class="clearfix"></div>
        	
        </div>
        
        
    </div>
</div>
<?= $footer;?>
