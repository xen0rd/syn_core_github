<div class="form-group">
	<a href="<?=base_url() . 'product/addProduct'?>" class="btn btn-primary" data-toggle="modal" data-target="#add_product">Add Product &nbsp; <span class="fa fa-plus"></span></a>
</div>
<div class="box">
	<div class="box-body">
		<table id="productsTable" class="table table-hover">
			<thead>
				<tr>
					<th>Item Name</th>
<!--					<th>In Stock</th>-->
                                        <th>Type</th>
					<th>Price</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Item Name</th>
<!--					<th>In Stock</th>-->
					<th>Type</th>
					<th>Price</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="add_product">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="delete_product">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="edit_product">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="change_product_status">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<script>
$(function(){
	$("#add_product").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#delete_product").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#edit_product").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#change_product_status").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
        table = $('#productsTable').DataTable({
            "ajax": '<?php echo site_url('product/getProducts'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "columns": [
				{"data": "item_name"},
//                {"data": "stock"},
                {"data": "item_type"},
                {"data": "item_price"},
                {"data": "date_created"},
                {"data": null, 
					render: function (row) {
						var status = row.status == 1 ? "checked" : "";
						var details = '<a href="<?=base_url()?>product/changeProductStatus/' + row.id + '"  data-toggle="modal" data-target="#change_product_status"><input id="toggle_product_' + row.id + '"class="toggle-status" ' + status + ' type="text" data-size="mini"  data-on="Available" data-off="Unavailable"></a>';

						$('.toggle-status').bootstrapToggle({
							width: "77"
						});
						
						return details;
					}
                },
                {
                    "data": null, 
                    render: function (row) {
                                var actions = '<a href="<?=base_url()?>product/productDetails/' + row.id + '" title="Product details"><span class="fa fa-eye"></a> &nbsp;&nbsp;'
           						+ '<a href="<?=base_url()?>product/editProduct/' + row.id + '/" title="Edit product" data-toggle="modal" data-target="#edit_product"><span class="fa fa-pencil-square-o"></a>  &nbsp;&nbsp;'
           						+ '<a href="<?=base_url()?>product/deleteProduct/' + row.id + '/" title="Delete product" data-toggle="modal" data-target="#delete_product"><span class="text-danger fa fa-trash"></a> ';
           								
                                return actions;
                            }
                }
            ],
            "fnInitComplete": function () {
                
            }
        });
});
</script>