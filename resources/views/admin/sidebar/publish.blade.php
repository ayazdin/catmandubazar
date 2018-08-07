<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Publish</h3>
    </div>
    <div class="box-body">
      <?php
        if(!empty($post->status))
            $status=$post->status;
        else
            $status='publish';
        //echo $status;
      ?>
      <div class="radio">
          <label>
            <input type="radio" name="rdoPublish" id="rdoPublish" value="publish"
            <?php echo ($status=='publish') ? 'checked="checked"' : ''; ?>>
            Publish
          </label>
      </div>
      <div class="radio">
          <label>
            <input type="radio" name="rdoPublish" id="rdoUnpublish" value="unpublish"
            <?php echo ($status=='unpublish') ? 'checked="checked"' : ''; ?>>
            Pending Review
          </label>
      </div>
      <div class="radio">
          <label>
            <input type="radio" name="rdoPublish" id="rdoDraft" value="draft"
            <?php echo ($status=='draft') ? 'checked="checked"' : ''; ?>>
            Draft
          </label>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>
