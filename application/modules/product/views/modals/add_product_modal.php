<style>
    .text-danger.fa.fa-asterisk.required{
        top: -5px;
        right:-23px;
        font-size: 8px;
    }
</style>
<?=form_open_multipart(base_url() . "product/addProduct", array('id' => 'addProductForm', 'autocomplete' => 'off'))?>	
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Add Product</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="product_type" class="label label-primary">Product type</label>
			<select id="product_type" class="form-control" name="item_type">
				<option value="Virtual">Virtual</option>
				<option value="Downloadable">Downloadable</option>
			</select>
		</div>
		<div class="form-group has-feedback">
                        <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
			<label for="product_name" class="label label-primary">Product name</label>
			<input id="product_name" type="text" name="item_name" class="form-control" required autofocus>
		</div>
		<div class="form-group has-feedback">
                        <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
			<label for="product_description" class="label label-primary">Product description</label>
			<textarea id="product_description" type="text" name="item_description" class="form-control" required></textarea>
		</div>
		<div class="form-group has-feedback">
                        <i class="text-danger fa fa-asterisk form-control-feedback required"></i>
			<label for="item_price" class="label label-primary">Price</label>
			<input id="item_price" type="text" name="item_price" class="form-control" required>
		</div>
<!--		<div class="form-group">
			<label for="stock" class="label label-primary">Stock</label>
			<input id="stock" type="text" name="stock" class="form-control" required>
		</div>-->
		<div id="downloadable_group" class="form-group" style="display:none;">
			<label for="downloadable_file" class="label label-primary">Downloadable file</label>
			<span class="btn btn-default btn-file">
			    Browse <input type="file" name="downloadable_file" id="downloadable_file" disabled>
			</span><br>
			<small id="downloadable_file_name" class="text-muted"></small>
			<br>
		</div>
		<div class="form-group">
			<label class="label label-primary">Product images*</label><br><br>
                        <div id="clone-div">
                            <span class="btn btn-primary btn-file input-file-span">
                                <span class="fa fa-plus fa-inverse"></span>&nbsp; Add images . . . <input type="file" name="image[]">
                            </span>
                        </div>
			<div id="multipleImages" class="row" style="margin-top:20px">
			</div>
			<br>
			<small class="text-muted">*Maximum upload size is 1025 kB per image(.gif, .jpg, .png)</small>
		</div>
	</div>
	<div class="modal-footer">
		<input id="submitAddDepartment" type="submit" class="btn btn-primary" value="Save">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
<?=form_close()?>


<script>
	$(function(){
		$("#product_type").change(function(){
			if($(this).val() == "Downloadable"){
				$("#downloadable_group").show();
				$("#downloadable_file").attr("disabled", false);
			}
			else{
				$("#downloadable_group").hide();
				$("#downloadable_file").attr("disabled", "disabled");
			}
		});
	});
</script>
<script>
$("#addProductForm").submit(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});
</script>
<script>
	function readImage(input, index){
            var reader = new FileReader();
            var count = $(".img-preview").length;
            $("#multipleImages").append('<div class="col-md-3"><a href="#" class="remove-image"><span class="badge" style="background-color:red; position:absolute; top:-7px; right:28px;"><b>-</b></span></a><img class="img-preview" width="100"></div>');
            
            reader.onload = function(e){
                    $("#multipleImages div:nth-child("+ index +") img").attr('src', e.target.result);
            }
            
            $.each($(".img-preview"),function(count){
               reader.readAsDataURL(input.files[count]); 
            });

	}
	
	$("#clone-div").on('change', "input[name='image[]']", function(){
            var clone = $(".input-file-span").last().clone();
            
            $(".input-file-span").hide();
            clone.appendTo("#clone-div");
            var index = $("#clone-div span:last-child").index();
            $(".input-file-span").last().find("input").val("");
		readImage(this, (index));
	});
        
        $("#multipleImages").on('click', '.remove-image', function(){
            var index = $(this).parent().index();
            $("#clone-div span:nth-child("+ (index + 1) +")").remove();
            $(this).parent().remove();
        });
        
	
	$("input[name='downloadable_file']").change(function(e){
		$("#downloadable_file_name").text(e.target.files[0].name);
	});

	$("input[name=item_price]").keydown(function(event) {
		  if (event.shiftKey == true) {
                        event.preventDefault();
                    }

                    if ((event.keyCode >= 48 && event.keyCode <= 57) || 
                        (event.keyCode >= 96 && event.keyCode <= 105) || 
                        event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                        event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                    } else {
                        event.preventDefault();
                    }

                    if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                        event.preventDefault(); 
	});

	 $("input[name=stock]").keydown(function (e) {
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
	            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                 return;
	        }
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
    });
</script>