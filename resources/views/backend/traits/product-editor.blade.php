<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"> Add Product</h3>
  </div>

    <input type="hidden" name="ctype" value="product">
    <input type="hidden" name="postid" value="<?php  echo (!empty($post->id ))? $post->id : '' ?>">
    <div class="box-body">
        <div class="form-group">
          <label for="prodTitle" class="col-sm-12 control-label lft-align">Title</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="prodTitle" id="title" placeholder="Product Title"
                  value="<?php  echo (!empty($post->title ))? $post->title : ''; ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="prodSlug" class="col-sm-12 control-label lft-align">Url</label>
          <div class="col-sm-12">
            <input type="text" class="form-control" name="prodSlug" id="slug" placeholder="Product Url"
                  value="<?php  echo (!empty($post->clean_url ))? $post->clean_url : ''; ?>">
          </div>
        </div>

        <div class="form-group">
          <label for="description" class="col-sm-12 control-label lft-align">
            <input type="checkbox" name="showDesc" id="showDesc" value="1"  <?php if($showDesc=='1') echo 'checked="checked"'; ?>> Description
          </label>
          <div class="col-sm-12">
            <textarea class="form-control tinymce" rows="3" name="description" id="description"><?php echo (!empty($post->content))? $post->content : ''; ?></textarea>
          </div>
        </div>

        <div class="form-group">
          <label for="excerpt" class="col-sm-12 control-label lft-align">Excerpt</label>
          <div class="col-sm-12">
            <textarea class="form-control" rows="3" name="excerpt" id="excerpt"><?php echo (!empty($post->excerpt))? $post->excerpt : ''; ?></textarea>
          </div>
        </div>
    </div>
</div>
