<div class="box">
    <div class="box-body">
        <table id="ordersTable" class="table table-hover">
            <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th>Transaction No.</th>
                    <th>Guest Email</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Date Purchased</th>
                    <th>Action</th>
                </tr>
            </thead>
           <tbody>
                <?php foreach($orders as $order){?>
                    <tr>
                        <td style="display:none;"><?=$order->id?></td>
                        <td class="ordersRow" style="cursor:pointer;"><?=$order->transaction_id?></td>
                        <th class="ordersRow" style="cursor:pointer;"><?=$order->guest_email != NULL ? $order->guest_email : "N/A"?></th>
                        <th class="ordersRow" style="cursor:pointer;"><?=$order->first_name != NULL ? $order->first_name . " " . $order->last_name : "N/A"?></th>
                        <td class="ordersRow" style="cursor:pointer;"><?="$" . $order->total?></td>
                        <td class="ordersRow" style="cursor:pointer;"><?=$order->transaction_date?></td>
                        <td>
                            <?php if($order->guest_email != NULL){ ?>
                                <a title="View customer's profile" disabled><span class="fa fa-user text-muted"></span></a>
                            <?php } else { ?>
                                <a href="<?= base_url()?>client/clientDetails/<?=$order->user_id?>/<?=$order->username?>" title="View customer's profile"><span class="fa fa-user text-primary"></span></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="display:none;"></td>
                    <th>Transaction No.</th>
                    <th>Guest Email</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Date Purchased</th>
                    <th>Date Purchased</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<script>
    $(function () {

         $('#ordersTable').DataTable();
        
        $(".ordersRow").click(function(){
		var id = $(this).siblings("td:first").text();
		var transactionId = $(this).siblings("td:nth(1)").text();
                window.location.href = "<?=base_url()?>admin/orders/order_details" + "/" + transactionId;

	});
        
    });
</script>