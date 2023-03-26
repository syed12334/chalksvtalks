<?php //echo "<pre>";print_r($images);exit; ?>
<?= $header;?>

<div class="page has-sidebar-left bg-light height-full">
  <br /><br />

 <div class="container-fluid my-3" style="margin-top:80px">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <a href='<?= base_url()."master/productsedit/".icchaEncrypt($products[0]->pid).""; ?>'  class="btn btn-primary" title="Edit Details" style="float: right;margin-bottom: 25px"><i class="fas fa-pencil-alt"></i> Edit Product</a>
          </div>
          <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                  <div class="table-responsive">
                      <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th>Category Name</th>
                          <th><?= $products[0]->catname;?></th>
                        </tr>
                        <tr>
                          <th>Subcategory Name</th>
                          <th><?= $products[0]->sname;?></th>
                        </tr>
                        <tr>
                          <th>Subsubcategory Name</th>
                          <th><?= $products[0]->ssname;?></th>
                        </tr>
                        <tr>
                          <th>Brand Name</th>
                          <th><?= $products[0]->bname;?></th>
                        </tr>
                        <tr>
                          <th>Product Title</th>
                          <th><?= $products[0]->ptitle;?></th>
                        </tr>
                        <tr>
                          <th>Product Code</th>
                          <th><?= $products[0]->pcode;?></th>
                        </tr>
                        <tr>
                          <th>Product Description</th>
                          <th><?= $products[0]->overview;?></th>
                        </tr>
                        <tr>
                          <th>Product Specification</th>
                          <th><?= $products[0]->pspec;?></th>
                        </tr>
                        <?php
                          if(!empty($products[0]->featuredimg)) {
                            ?>
                              <tr>
                          <th>Featured Image</th>
                          <th><img src="<?= app_url().$products[0]->featuredimg;?>" style="width:130px"></th>
                        </tr>
                            <?php
                          }
                        ?>
                         <?php
                          if(!empty($products[0]->pbrochure)) {
                            ?>
                              <tr>
                          <th>Featured Image</th>
                          <th><img src="<?= app_url().$products[0]->pbrochure;?>" style="width:130px"></th>
                        </tr>
                            <?php
                          }
                        ?>
                      
                         
                      </tbody>
                    </table>
                  </div>  
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
              <div class="table-responsive">
                      <table class="table table-bordered">
                      <tbody>
                          <th>Modal Number</th>
                          <th><?= $products[0]->modalno;?></th>
                        </tr>
                        <tr>
                          <th>Tax</th>
                          <th><?= $products[0]->tax;?></th>
                        </tr>
                        <tr>
                          <th>Discount</th>
                          <th><?= $products[0]->discount;?></th>
                        </tr>
                        <tr>
                          <th>Length</th>
                          <th><?= $products[0]->length;?></th>
                        </tr>

                        <tr>
                          <th>Breadth</th>
                          <th><?= $products[0]->breadth;?></th>
                        </tr>
                        <tr>
                          <th>Weight</th>
                          <th><?= $products[0]->weight;?></th>
                        </tr>
                        <tr>
                          <th>Youtube Link</th>
                          <th><?= "https://www.youtube.com/watch?v=".$products[0]->youtubelink;?></th>
                        </tr>
                        <tr>
                          <th>Meta Title</th>
                          <th><?= $products[0]->meta_title;?></th>
                        </tr>
                        <tr>
                          <th>Meta Description</th>
                          <th><?= $products[0]->meta_description;?></th>
                        </tr>
                        <tr>
                          <th>Meta Keywords</th>
                          <th><?= $products[0]->meta_keywords;?></th>
                        </tr>
                        <tr>
                          <th>Customer Q&A</th>
                          <th><?= $products[0]->cqa;?></th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <h4 style="font-weight: bold!important;color:#000!important">Product Sizes</h4>
                  <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                    <tr>
                      <th>Size Name</th>
                      <th>Color Name</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Color Image</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                          if(count($sizes) >0) {
                            foreach ($sizes as $size) {
                             ?>
                             <tr>
                               <td><?= $size->sname;?></td>
                               <td><?= $size->coname;?></td>
                               <td><?= $size->price;?></td>
                               <td><?= $size->stock;?></td>
                               <td>
                                 <?php
                                  if(!empty($size->coimg)) {
                                    ?>
                                    <img src="<?= app_url().$size->coimg;?>" style="width:80px">
                                    <?php
                                  }
                                 ?>
                               </td>
                             </tr>
                             <?php
                            }
                          }
                        ?>
                    </tbody>
                  </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <h4 style="font-weight: bold!important;color:#000!important">Product Images</h4>
            </div>
            <div class="clearfix"></div>
           <?php
            if(count($images) >0) {
              ?>
             
              <?php
              foreach ($images as $img) {
                ?>
                  <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <img src="<?= app_url().$img->p_image;?>" class="img-responsive" style="width:100%">
                  </div>
                <?php
              }
            }
           ?>
        </div>
    </div>
</div>
<?= $footer;?>
