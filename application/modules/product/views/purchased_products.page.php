<div class="container">
    <div class="row">
        <fieldset>
            <legend>Downloadables</legend>
            <?php if(isset($purchasedItems)){ ?>
            <?php foreach($purchasedItems as $purchasedItem){ ?>
            <?php if($purchasedItem->item_type == "Downloadable"){ ?>
                    <div class="col-md-2" style="margin-bottom:50px;">
                        <div class="hovereffect">
                            <a href="<?=base_url()?>uploads/downloadables/<?=$purchasedItem->downloadable_file?>" download>
                                    <img class="img-responsive" src="<?=uploaded_images_url() . "thumbnails/" . $purchasedItem->image?>" width="100%">
                            </a>
                        <div class="overlay">
                            <br>
                            <h4><?=$purchasedItem->item_name?></h4>
                            <label class="label label-primary">Purchased</label>
                        </div>
                        </div>
                    </div>
            <?php }}}?>
        </fieldset>
    </div>
    <div class="row">
        <fieldset>
            <legend>Virtual</legend>
            <?php if(isset($purchasedItems)){ ?>
            <?php foreach($purchasedItems as $purchasedItem){ ?>
            <?php if($purchasedItem->item_type == "Virtual"){ ?>
                    <div class="col-md-2" style="margin-bottom:50px;">
                        <div class="hovereffect">
<!--                            <a href="<?=base_url()?>uploads/downloadables/<?=$purchasedItem->downloadable_file?>" download>-->
                                    <img class="img-responsive" src="<?=uploaded_images_url() . "thumbnails/" . $purchasedItem->image?>" width="100%">
                            <!--</a>-->
                        <div class="overlay">
                            <br>
                            <h4><?=$purchasedItem->item_name?></h4>
                            <label class="label label-primary">Purchased</label>
                        </div>
                        </div>
                    </div>
            <?php }}}?>
        </fieldset>
    </div>
</div>