<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Product Options</h3>
    </div>
    <div class="box-body" id="option-list">
      <?php //print_r($options);
      if(!empty($options))
      {
          $optionCount=1;
          $optionNumber='1';
          $valueCount=1;
          $optionNum=count($options);
          $opCols=[];
          foreach($options as $opt)
          {
            $valOption = $opt['options'];
            //$priceOption = $opt['prices'];
            $valCount = count($valOption);
            if($valCount==0)
              $valCount=1;
            if($optionCount==$optionNum)
              $optionNumber .= $optionCount;
            elseif($optionCount==1)
              $optionNumber = $optionNumber.",";
            else
              $optionNumber .= $optionCount.",";
            //for the option price section
            $fld = preg_replace('/[^A-Z0-9]+/i', '', strtolower($opt['name']));
            $optemp = array($opt['name'], $fld);
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
      <button class="btn btn-success" id="addPrice">Add Price</button>
    </div>
    <!-- END of box-footer-->
</div>

<?php
  if(!empty($priceOptions))
    $priceSelCount = count($priceOptions);
  else
    $priceSelCount=0;
?>
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Price Option</h3>
      <input type="hidden" name="priceSelCount" id="priceSelCount" value="{{$priceSelCount}}">
    </div>
    <div class="box-body price-list">
        <?php //print_r($options);echo "<br><br><br>";print_r($priceOptions);
          for($op=1; $op<=$priceSelCount; $op++)
          {
            $optBlock = $priceOptions[$op-1];
            echo '<div class="row form-group priceField'.$op.'">';
            $optCount = 0;
            if(!empty($options))
            {
              foreach($options as $opt)
              {
                $fld = preg_replace('/[^A-Z0-9]+/i', '_', strtolower($opt['name']));
                echo '<div class="col-sm-4">
                  <label class="control-label lft-align">'.$opt['name'].'</label>
                  <select class="form-control" name="'.$fld.'_sel[]">';
                    echo '<option value="">Select</option>';
                if(!empty($opt['options']))
                {
                  foreach($opt['options'] as $opV)
                  {
                    if($optBlock[$optCount]==$opV)
                      echo '<option value="'.$opV.'" selected>'.$opV.'</option>';
                    else
                      echo '<option value="'.$opV.'">'.$opV.'</option>';
                  }
                }
                echo '</select>
                </div>';
                $optCount++;
              }
            }
            echo '<div class="col-sm-4">
              <label class="control-label lft-align">Price</label><br>
              <input type="text" class="form-control pfld" name="selPrice[]" value="'.end($optBlock).'">
              <a data-price-field="'.$op.'" class="btn btn-primary delPriceField">
                <i class="fa fa-fw fa-minus-circle"></i>
              </a>
            </div>';
            echo '</div><div class="sep'.$op.'"><hr></div>';
          }
        ?>
    </div>
    <div class="box-footer">
      <button class="btn btn-success" id="addPriceSelection" data-nextsel="<?php echo $priceSelCount+1;?>">Add price option</button>
    </div>
</div>
