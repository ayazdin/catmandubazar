<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Product Options</h3>
    </div>
    <div class="box-body" id="option-list">
      <?php
      if(!empty($options))
      {
          $optionCount=1;
          $optionNumber='1';
          $valueCount=1;
          $optionNum=count($options);

          foreach($options as $opt)
          {
            $valOption = $opt['options'];
            $priceOption = $opt['prices'];
            $valCount = count($valOption);
            if($valCount==0)
              $valCount=1;
            if($optionCount==$optionNum)
              $optionNumber .= $optionCount;
            elseif($optionCount==1)
              $optionNumber = $optionNumber.",";
            else
              $optionNumber .= $optionCount.",";
      ?>
      <div class="option-box optList<?php echo $optionCount;?>">
        <input type="hidden" name="valueCount<?php echo $optionCount;?>"
                            id="valueCount<?php echo $optionCount;?>"
                            value="<?php echo $valCount+1;?>">
        <div class="form-group">
          <label for="option1name" class="col-sm-12 control-label lft-align">Name</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="optName[]" placeholder="Option Name" value="<?php echo $opt['name'];?>">
          </div>
        </div>
        <?php
          for($i=0; $i<$valCount;$i++)
          {
        ?>
        <div class="form-group option<?php echo $optionCount;?>value<?php echo $i+1;?>">
          <label class="col-sm-12 control-label lft-align">Value</label>
          <div class="col-sm-12">
            <input type="text" class="form-control opt-val mar-rht-10"
                                                            name="optValue<?php echo $optionCount;?>[]"
                                                            placeholder="value"
                                                            value="<?php echo $valOption[$i];?>">
            <input type="text" class="form-control opt-val"
                                                            name="optPrice<?php echo $optionCount;?>[]"
                                                            placeholder="price"
                                                            value="<?php echo $priceOption[$i];?>">
            <div class="fa-add-but">
              <a data-optioncount="<?php echo $optionCount;?>" data-valuecount="<?php echo $i+1;?>" class="btn btn-primary addOptValue">
                <i class="fa fa-fw fa-plus-circle"></i>
              </a>
            </div>
            <?php if($i>0) {?>
            <div class="fa-add-but">
              <a data-optioncount="<?php echo $optionCount;?>" data-valuecount="<?php echo $i+1;?>" class="btn btn-primary delOptValue">
                <i class="fa fa-fw fa-minus-circle"></i>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
        <!-- END of form-group-->
      <?php } ?>
      </div>
      <hr>
      <?php
          $optionCount++;}
      echo '<input type="hidden" name="optionNumber" id="optionNumber" value="'.$optionNumber.'">';
      }else {
        $optionCount=2;
      ?>
      <div class="option-box optList1">
        <input type="hidden" name="optionNumber" id="optionNumber" value="1">
        <input type="hidden" name="valueCount1" id="valueCount1" value="2">
        <div class="form-group">
          <label for="option1name" class="col-sm-12 control-label lft-align">Name</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="optName[]" placeholder="Option Name">
          </div>
        </div>
        <div class="form-group option1value1">
          <label class="col-sm-12 control-label lft-align">Value</label>
          <div class="col-sm-12">
            <input type="text" class="form-control opt-val mar-rht-10" name="optValue1[]" placeholder="value">
            <input type="text" class="form-control opt-val" name="optPrice1[]" placeholder="price">
            <div class="fa-add-but">
              <a data-optioncount="1" data-valuecount="1" class="btn btn-primary addOptValue">
                <i class="fa fa-fw fa-plus-circle"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- END of form-group-->
      </div>
      <hr>
      <!-- END of option-box-->
    <?php }?>
    </div>
    <!-- END of box-body-->
    <div class="box-footer">
      <button class="btn btn-success btnAddOption" id="optCount" data-optioncount=<?php echo $optionCount;?>>Add Option</button>
    </div>
    <!-- END of box-footer-->
</div>
