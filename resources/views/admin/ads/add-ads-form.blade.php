@push('admincss')
<link rel="stylesheet" href="{{url('/plugins/datepicker/bootstrap-datepicker.min.css')}}">
@endpush

<?php
$startdate="";$enddate="";
if(!empty($post))
{
  $postmeta = $post->postmeta;
  //print_r($postmeta);
  foreach($postmeta as $pm)
  {
    if($pm->meta_key=='startdate')
      $startdate = $pm->meta_value;
    if($pm->meta_key=='enddate')
      $enddate = $pm->meta_value;
  }
}
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
  <form class="form-horizontal" name="frmAddPost" action="/admin/ads/store" method="post">
	<section class="content-header">
		<div class="row">
			<div class="col-xs-8">
				<div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add Advertisement</h3>
          </div>

            <input type="hidden" name="ctype" value="ads">
            <input type="hidden" name="postid" value="<?php  echo (!empty($post->id ))? $post->id : '' ?>">
    		    <div class="box-body">
              @if(!empty($succ))
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ $succ }}
              </div>
              @endif
              @if(!empty(session('succ')))
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> {{ session('succ') }}
              </div>
              @endif
                <div class="form-group">
                  <label for="prodTitle" class="col-sm-12 control-label lft-align">Ads Title</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" name="prodTitle" id="prodTitle" placeholder="Ads Title"
                    			value="<?php  echo (!empty($post->title ))? $post->title : ''; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="startDate" class="col-sm-12 control-label lft-align">Start Date:</label>
                  <div class="col-sm-12">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php //echo $startdate;?>
                      <input type="text" class="form-control pull-right datepicker" name="startDate" id="startDate">
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label for="endDate" class="col-sm-12 control-label lft-align">End Date:</label>
                  <div class="col-sm-12">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" name="endDate" id="endDate">
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label for="description" class="col-sm-12 control-label lft-align">Define Ads</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" rows="3" name="description" id="description"><?php //echo (!empty($post->excerpt))? $post->excerpt : ''; ?></textarea>
                  </div>
                </div>

            </div>
        </div>
			</div>





      <div class="col-xs-4">
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
                    Unpublish
                  </label>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Position</h3>
            </div>
            <div class="box-body">
                <div class="form-group no-mar">
                  <div class="col-sm-12">
                    <div class="category-list">
                      {!! $ddlCat !!}
                    </div>
                  </div>
                </div>
            </div>
        </div>

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

      </div>

		</div>
    {!! csrf_field() !!}
    </form>
	</section>
</div>

@push('adminjs')
<script src="{{url('/plugins/datepicker/bootstrap-datepicker.min.js')}}"></script>
<script>
$(function () {
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
  });
  <?php if($startdate!="") { ?> $("#startDate").datepicker("setDate", '<?php echo $startdate;?>');<?php } ?>
  <?php if($enddate!="") { ?> $("#endDate").datepicker("setDate", '<?php echo $enddate;?>');<?php } ?>
});
</script>
@endpush
