<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Attributes</h3>
    </div>
    <div class="box-body">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="isfeatured" value="1" <?php if($isFeatured==1) echo "checked";?>>Featured Product
          </label>
        </div>

        <div class="form-group">
          <label for="prodTags" class="col-sm-12 control-label lft-align">Hash Tags</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="prodTags" id="prodTags" placeholder="#Hash,#Tags"
                  value="<?php echo $tags;?>">
          </div>
        </div>

        <div class="form-group">
          <label for="prodPrice" class="col-sm-12 control-label lft-align">
            <input type="checkbox" name="showPrice" id="showPrice" value="1"  <?php if($showPrice=='1') echo 'checked="checked"'; ?>> Price
          </label>
          <div class="col-sm-12">
            <input type="radio" name="currency" id="priceUSD" value="USD" <?php if($currency=='USD') echo 'checked="checked"'; ?>> USD
            <input type="radio" name="currency" id="priceNPR" value="NPR" <?php if($currency=='' or $currency=='NPR') echo 'checked="checked"'; ?>> NPR
          </div>
          <div class="col-sm-12">
            <input type="number" step="any" class="form-control" name="prodPrice" id="prodPrice" placeholder="Price"
                  value="<?php echo $price;?>">
          </div>
        </div>

        <div class="form-group">
          <label for="prodqty" class="col-sm-12 control-label lft-align">
            <input type="checkbox" name="showQty" id="showQty" value="1"  <?php if($showQty=='1') echo 'checked="checked"'; ?>> Quantity
          </label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="prodqty" id="prodqty" placeholder="Quantity"
                  value="<?php echo $quantity;?>">
          </div>
        </div>

        <div class="form-group">
          <label for="stock" class="col-sm-12 control-label lft-align">
            <input type="checkbox" name="showStock" id="showStock" value="1"  <?php if($showStock=='1') echo 'checked="checked"'; ?>> Stock
          </label>
          <div class="col-sm-12">
            <input type="radio" name="stock" id="instock" value="in" <?php if($stock=='in' or $stock=='') echo 'checked="checked"'; ?>> In Stock
            <input type="radio" name="stock" id="outstock" value="out" <?php if($stock=='out') echo 'checked="checked"'; ?>> Out of Stock
          </div>
          
        </div>

    </div>
</div>
