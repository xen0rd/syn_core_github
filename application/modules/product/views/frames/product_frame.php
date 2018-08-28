<?=link_tag(css_url() . "bootstrap.css")?>
<?=link_tag(css_url() . "custom_product_list.css")?>
<link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">        
<script src="<?=js_url()?>jquery.elevatezoom.min.js" type="text/javascript"></script>        
<div class="container">
	<br>
	<div class="row text-center">
		<div class="col-md-2">
		    <div class="hovereffect">
		        <a href="<?="//".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);?>product/viewProduct/<?=$product->id?>" target="_blank">
		        	<img class="img-responsive" src="<?="//".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']) . "uploads/thumbnails/" . $product->image?>">
	        	</a>
	            <div class="overlay">
	            	<h4><?=$product->item_name?></h4>
                        <?php if($product->status == 1){ ?>
                            <a href="<?="//".$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);?>product/addToCart/<?=$product->id?>" target="_blank" class="btn btn-success">Add to Cart</a>
                        <?php }else{ ?>
                            <a href="" class="btn btn-success" disabled>Add to Cart</a>
                        <?php } ?>
	            </div>
		    </div>
		</div>
	</div>
</div>