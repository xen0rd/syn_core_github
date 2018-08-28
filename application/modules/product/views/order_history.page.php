<div class="container">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <table id="ticketsTable" class="table table-hover">
                        <thead>
                                <tr>
                                    <th style="display:none;"></th>
                                    <th>Transaction No.</th>
                                    <th>Total</th>
                                    <th>Date Purchased</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $transaction){?>
                                <tr class="ordersRow" style="cursor:pointer;">
                                    <td style="display:none;"><?=$transaction->id?></td>
                                    <td><?=$transaction->transaction_id?></td>
                                    <td><?="$" . $transaction->total?></td>
                                    <td><?=$transaction->transaction_date?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
	$(".ordersRow").click(function(){
		var id = $(this).children("td:first").text();
		var transactionId = $(this).children("td:nth(1)").text();
                <?php if($this->uri->segment(1) == 'admin'){?>
                    window.location.href = "<?=base_url()?>admin/product/order_details/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?>/" + id + "/" + transactionId;
                <?php } else {?>
                    window.location.href = "<?=base_url()?>product/order_details/<?=$this->session->userdata('c_id')?>/" + transactionId;
                <?php } ?>
	});
});
</script>

