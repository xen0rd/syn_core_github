<div class="box">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<fieldset>
					<legend>Product Details</legend>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>Item Name:</td>
								<td><?=$product_details->item_name?></td>
							</tr>
							<tr>
								<td>Item Type:</td>
								<td><?=$product_details->item_type?></td>
							</tr>
							<tr>
								<td>Downloadable file:</td>
								<td>
									<?php if(isset($product_details->downloadable_file)){?>
										 <a href="<?=base_url() . 'uploads/downloadables/' . $product_details->downloadable_file ?>" download> <?=$product_details->downloadable_file?></a>
									<?php } else {?>
										N/A
									<?php }?>
								</td>
							</tr>
							<tr>
								<td>Description:</td>
								<td><?=$product_details->item_description?></td>
							</tr>
<!--							<tr>
								<td>Stock:</td>
								<td><?=$product_details->stock?></td>
							</tr>-->
							<tr>
								<td>Price:</td>
								<td><?="$" . $product_details->item_price?></td>
							</tr>
							<tr>
								<td>Status:</td>
								<td><?=$product_details->status == 1 ? '<span class="label label-success">Available</span>' : '<span class="label label-danger">Unavailable</span>'?></td>
							</tr>
							<tr>
								<td>Embed Code:</td>
								<td>
									<input id="embedField" type="text" class="form-control" value='<iframe width="380" height="430" src="<?="//".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . 'product/embed/' . $product_details->id?>" frameborder="0"></iframe>' readonly>
                                                                        <button id="copyEmbed" class="btn btn-primary" title="Copy to clipboard"><span class="fa fa-clipboard"></span></button>
								</td>
							</tr>
							<tr>
								<td>Created:</td>
								<td><?=$product_details->date_created?></td>
							</tr>
						</table>
					</div>
				</fieldset>
			</div>
			<div class="col-md-5">
				<fieldset>
					<legend>Thumbnails</legend>
					<div class="row">
                                        <?php if($product_images !== FALSE){
                                                foreach($product_images as $key => $val){ ?>
						<div class="col-md-4">
                                                    <div class="form-group">
                                                        <img width="100%" style="height:150px; box-shadow: 2px 2px 5px;" src="<?=uploaded_images_url() . "thumbnails/" . $val->image;?>">
                                                    </div>
						</div>
                                            <?php }
							}?>
					</div>
				</fieldset>
			</div>
		</div>
<!--		<div class="row">
			<div class="col-md-7">
					<fieldset>
						<legend>Order History</legend>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td>Order No</td>
									<td>Ordered By</td>
									<td>Quantity</td>
									<td>Unit Price</td>
									<td>Total Price</td>
									<td>Date Purchased</td>
								</tr>
								<tr>
								</tr>
							</table>
						</div>
					</fieldset>
				</div>
		</div>-->
	</div>
</div>
<script>
    $(function(){
        $("#copyEmbed").click(function(){
            $("#embedField").select();
            document.execCommand("Copy"); 
        });
    });
</script>