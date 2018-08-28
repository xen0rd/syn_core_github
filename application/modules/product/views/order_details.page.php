<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <table id="order_details_table" class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Sub total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order)
                    { ?>
                        <tr>
                            <td>
                                <?php if ($this->uri->segment(1) == 'admin')
                                { ?>
                                    <a href="<?= base_url() ?>product/productDetails/<?= $order->item_id ?>"><img src="<?= uploaded_images_url() ?>thumbnails/<?= $order->image ?>" width="100px"></a>    
                                <?php }
                                else
                                { ?>
                                    <a href="<?= base_url() ?>product/viewProduct/<?= $order->item_id ?>"><img src="<?= uploaded_images_url() ?>thumbnails/<?= $order->image ?>" width="100px"></a>    
    <?php } ?>

                            </td>
                            <td><?= $order->item_name ?></td>
                            <td><?= "$" . $order->item_price ?></td>
                            <td><?= $order->quantity ?></td>
                            <td><?= "$" . $order->sub_total ?></td>
                        </tr>
<?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total : </b></td>
                        <td><?= "$" . $orders[0]->total ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#order_details_table').DataTable({
            "pageLength": 50,
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": false,
            "ordering": false,
            "searching": false
        });


    });
</script>