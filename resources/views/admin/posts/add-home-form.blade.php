<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="row">
      <div class="col-sm-8 col-xs-12">
				<div class="box box-primary">
        		<div class="box-header with-border">
        			<h3 class="box-title">Home Sliders</h3>
        		</div>
            <div class="box-body table-responsive no-padding">
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
              <table class="table table-hover">
              <tbody><tr>
                <th>Name</th>
                <th>Slug</th>
                <th></th>
              </tr
              @if(!empty($slider) and $slider->count()>0)
              @foreach ($slider as $cat)
              <tr>
                <td>{{ $cat->title }}</td>
                <td>{{ $cat->clean_url }}</td>
                <!-- <td></td> -->
                <td>
                  <a href="/admin/home/slider/edit/{{ $cat->id }}">Edit</a> |
                  <a href="/admin/home/slider/delete/{{ $cat->id }}">Delete</a>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody></table>
            </div>
		      	<div class="box-footer">
		              {{ $slider->links('admin.partials.paginators') }}
			    	</div>

        </div>
      </div>
			<div class="col-sm-4 col-xs-12">
				<div class="box box-primary">
		      		<div class="box-header with-border">
		      			<h3 class="box-title">Add Category</h3>
		      		</div>
							<?php //print_r($editslider);?>
		      		<form class="form-horizontal" name="frmAddCategory" action="/admin/home/slider/store" method="post">
                @if(!empty($editslider))
                  <input type="hidden" name="postid" value="{{ $editslider->id }}">
                @endif
								<input type="hidden" name="ctype" value="home">
		      		<div class="box-body">
		                <div class="form-group">
		                  <label for="prodTitle" class="col-sm-12 control-label lft-align">Slider Title</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="prodTitle" id="prodTitle" placeholder="Slider Title"
		                    			value="{{!empty($editslider) ? $editslider->title : '' }}">
		                  </div>
		                </div>
										<div class="form-group">
		                  <label for="prodSlug" class="col-sm-12 control-label lft-align">Slug</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="prodSlug" id="prodSlug" placeholder="Slug"
		                    			value="{{!empty($editslider) ? $editslider->clean_url : '' }}">
		                  </div>
		                </div>
                    <div class="form-group">
		                  <label for="rdoPublish" class="col-sm-12 control-label lft-align">Status</label>
		                  <div class="col-sm-12">
		                    <select name="rdoPublish" id="rdoPublish" class="form-control ">
													<option value="0">Please Select</option>
													@if(!empty($editslider))
							              {{$status = $editslider->status}}
                          @else
                            <?php $status = "";?>
                          @endif
														<option value="publish" @if($status=='publish') selected  @endif>Publish</option>
                            <option value="unpublish" @if($status=='unpublish') selected  @endif>Unpublish</option>
												</select>
		                  </div>
		                </div>
                    <div class="form-group">
		                  <label for="menuorder" class="col-sm-12 control-label lft-align">Order</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="menuorder" id="menuorder" placeholder="Order"
		                    			value="{{!empty($editslider) ? $editslider->menu_order : '' }}">
		                  </div>
		                </div>
										<div class="form-group">
		                  <label for="excerpt" class="col-sm-12 control-label lft-align">Sell All Link</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="excerpt" id="excerpt" placeholder="See All Link"
		                    			value="{{!empty($editslider) ? $editslider->excerpt : '' }}">
		                  </div>
		                </div>
			        </div>

			        <div class="box-footer">
			            <button type="submit" class="btn btn-default">Save</button>
		            </div>
		            {!! csrf_field() !!}
		            </form>

		      	</div>
			</div>
		</div>

	</section>
</div>
