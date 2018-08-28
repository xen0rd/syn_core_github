<?=$shopping_cart?>

<div class="container">
	<div class="row">
		<div class="btn-group btn-breadcrumb">
			<a href="<?=base_url()?>" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
			<a href="<?=base_url()?>" class="btn btn-default">Products</a>
                        <?php if(isset($products)){ ?>
                            <a href="#" class="btn btn-primary"><?=ucfirst($this->uri->segment(1))?></a>
                        <?php }?>
		</div>
	</div>
	<br>
        
	<div class="row text-center">
		<?php if(isset($products)){
                    foreach($products as $product){?>
			<div class="col-md-2" style="margin-bottom:50px;">
			    <div class="hovereffect">
			        <a href="<?=base_url()?>product/viewProduct/<?=$product->id?>" class="">
			        	<img class="img-responsive" src="<?=uploaded_images_url() . "thumbnails/" . $product->image?>" width="100%" style="height:150px; box-shadow: 5px 5px 15px;">
		        	</a>
		            <div class="overlay">
                                <br>
                                <label class="label label-<?=$product->status == '1' ? 'success' : 'danger'?>"><?=$product->status == '1' ? "Available" : "Unavailable"?></label>
		            	<h4><?=$product->item_name?></h4>
<!--		                <label class="label label-<?=$product->stock > 0 ? "success" : "danger"?>">In Stock: <?=$product->stock?></label>-->
		            </div>
			    </div>
			</div>
                <?php }}?>
            <?php if($this->uri->segment(1) == "" || $this->uri->segment(1) == "client"){ ?>
                <div class="col-md-6">
                    <h2>Downloadable Products</h2>
                    <a href="<?=base_url()?>downloadable"><img id="downloadableThumbnail" src="<?= images_url()?>downloadable.png" width="80%"></a>
                </div>
                <div class="col-md-6">
                    <h2>Virtual Products</h2>
                    <a href="<?=base_url()?>virtual"><img id="virtualThumbnail" src="<?= images_url()?>virtual.png" width=80%"></a>
                </div>
            <?php } ?>
	</div>
</div>
<script src="<?=js_url()?>cart.js" type="text/javascript"></script>
<script>
    $(function(){
//        $.ajax({
//            url: "<?= site_url()?>product/getDownloadableImages",
//            success: function(data){
//                var obj = $.parseJSON(data);
//                var randomNum = Math.floor(Math.random() * obj.length);
//                $("#downloadableThumbnail").attr("src", $("#downloadableThumbnail").attr("src") + obj[randomNum].image);
//            }
//        });
//        $.ajax({
//            url: "<?= site_url()?>product/getVirtualImages",
//            success: function(data){
//                var obj = $.parseJSON(data);
//                var randomNum = Math.floor(Math.random() * obj.length);
//                $("#virtualThumbnail").attr("src", $("#virtualThumbnail").attr("src") + obj[randomNum].image);
//            }
//        });
//
//    });
</script>