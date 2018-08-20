<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Add Product Images</h3>
  </div>

  <div class="box-body">
    <div class="row" id="imageList">

      <?php if($images!="")
      { $imgArr = unserialize($images);
        $imgCount = 1;
        echo '<input type="hidden" name="imgCount" id="imgCount" value="'.count($imgArr).'">';
        //print_r($imgArr);
        foreach($imgArr as $img)
        {
      ?>
      <div class="form-group img<?php echo $imgCount;?>">
        <div class="col-xs-8">
          <div class="input-group">
            <?php if($imgCount>1){?>
            <span>
              <div class="delImage" data-action="<?php echo $imgCount;?>">
                  <i class="fa fa-fw fa-minus-circle"></i>
              </div>
            </span>
          <?php } ?>
             <span class="input-group-btn">
               <a data-input="thumbinput<?php echo $imgCount;?>" data-preview="thumholder<?php echo $imgCount;?>" class="btn btn-primary uploadImage">
                 <i class="fa fa-picture-o"></i> Choose
               </a>
             </span>
             <input id="thumbinput<?php echo $imgCount;?>" class="form-control" type="text" name="imagespath[]" value="<?php  echo $img; ?>">
          </div>
        </div>
        <div class="col-xs-4">
          <img src="<?php  echo $img; ?>" id="thumholder<?php echo $imgCount;?>" style="max-height:40px;">
        </div>
      </div>
      <!-- END of form-group-->
      <?php
        $imgCount++;
        }
      }
      else {
      ?>
      <input type="hidden" name="imgCount" id="imgCount" value="1">
      <div class="form-group img1">
        <div class="col-xs-8">
          <div class="input-group">
             <span class="input-group-btn">
               <a data-input="thumbinput1" data-preview="thumholder1" class="btn btn-primary uploadImage">
                 <i class="fa fa-picture-o"></i> Choose
               </a>
             </span>
             <input id="thumbinput1" class="form-control" type="text" name="imagespath[]" value="">
          </div>
        </div>
        <div class="col-xs-4">
          <img id="thumholder1" style="max-height:40px;">
        </div>
      </div>
      <!-- END of form-group-->
  <?php } ?>
    </div>
    <!-- END of row-->
  </div>
  <!-- END of box-body-->
  <div class="box-footer">
    <button class="btn btn-success btnAddImage">Add Image</button>
  </div>
</div>
