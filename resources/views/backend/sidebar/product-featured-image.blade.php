<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Featured Image</h3>
    </div>
    <div class="box-body">
        <div class="input-group">
         <span class="input-group-btn">
           <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
             <i class="fa fa-picture-o"></i> Choose
           </a>
         </span>
         <input id="thumbnail" class="form-control" type="text" name="featuredimage" value="<?php  echo (!empty($post->image ))? $post->image : ''; ?>">
       </div>
       <img <?php  echo (!empty($post->image ))? 'src="'.$post->image.'"' : ''; ?> id="holder" style="margin-top:15px;max-height:100px;">
    </div>
</div>
