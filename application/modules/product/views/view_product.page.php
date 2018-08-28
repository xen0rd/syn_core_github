<?=link_tag(css_url() . "custom_product_list.css")?>
<script src="<?=js_url()?>jquery.elevatezoom.js" type="text/javascript"></script>        
<script src="<?=js_url()?>cart.js" type="text/javascript"></script>        
<div class="site">
	
	<?=$shopping_cart?>
	
	<div class="container">
		<div class="row">
			<div class="btn-group btn-breadcrumb">
				<a href="<?=base_url()?>" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
				<a href="<?=base_url()?>" class="btn btn-default">Products</a>
                                <a href="<?=base_url() . lcfirst($details->item_type)?>" class="btn btn-default"><?=$details->item_type?></a>
				<a href="#" class="btn btn-primary"><?=$details->item_name?></a>
			</div>
		</div>
		<br> 
		<fieldset>
			<legend><?=$details->item_name?></legend>
			<div class="row">
				<div class="col-md-4">
					<img class="img-responsive" id="img_01" src="<?=base_url();?>uploads/thumbnails/<?=$images[0]->image?>" data-zoom-image="<?=base_url();?>uploads/thumbnails/<?=$images[0]->image?>"/>
					<div class="carousel slide multi-item-carousel" id="theCarousel">
						<div class="carousel-inner" id="gal1">
                                                    <?php 
                                                        $groupCount = ceil(sizeof($images)  / 3);
                                                        for($a = 0; $a < $groupCount; $a ++){
                                                            $offset = $a * 3;
                                                    ?>
							<div class="item">
                                                            <?php for($b = $offset; $b < (($a + 1) * 3); $b ++){
                                                                if(isset($images[$b])){
                                                            ?>
                                                                <div class="col-xs-4">
                                                                        <a data-zoom-image="<?=base_url();?>uploads/thumbnails/<?=$images[$b]->image?>" data-image="<?=base_url();?>uploads/thumbnails/<?=$images[$b]->image?>" href="#">
                                                                                <img src="<?=base_url();?>uploads/thumbnails/<?=$images[$b]->image?>" class="img-responsive">
                                                                        </a>
                                                                </div>
                                                            <?php } }?>
							</div>
                                                    <?php } ?>
						</div>
						<a class="left carousel-control" href="#theCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
						<a class="right carousel-control" href="#theCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
					</div>
					<br>
					<div class="form-group">
<!--						<h4>Stock: <?=$details->stock?></h4>-->
						<h4>Unit Price: $<?=$details->item_price?></h4>
					</div>				

					<a <?=$details->status == 1 ? 'href="' . base_url() . 'product/addToCart/' . $details->id .'"' : 'disabled' ?> class="addToCartBtn btn btn-success" ><span class="fa fa-shopping-cart"></span>&nbsp; Add to Cart</a>
				</div>
				<div class="col-md-6">
					<p class="text-justify"><?=$details->item_description?></p>
				</div>
			</div>
		</fieldset>
                
	</div>

		<style type="text/css">
		#img_01{width: 360px; padding-bottom:10px;clear:both;}
		.multi-item-carousel{margin-top: 20px;}
		</style>
		<script type="text/javascript">
                    
                    $("#gal1").children().eq(0).addClass("active");
		// Instantiate the Bootstrap carousel
		$('.multi-item-carousel').carousel({
			interval: false
		});

//		$('.multi-item-carousel .item').each(function () {
//			var next = $(this).next();
//			if (!next.length) {
//				next = $(this).siblings(':first');
//			}
//                        else{
//                            next.children(':first-child').clone().appendTo($(this));
//                        }
//
//			if (next.next().length > 0) {
//				next.next().children(':first-child').clone().appendTo($(this));
//			} else {
//				$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
//			}
//		});
		$("#img_01").elevateZoom({gallery: 'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: false, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});

		//pass the images to Fancybox
		
		</script>
                
                
	</div>
</div>
