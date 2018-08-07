<div class="content-wrapper">
	<!-- Content Header -->
	<section class="content-header">
		<div class="row">
      <div class="col-sm-8 col-xs-12">
				<div class="box box-primary">
        		<div class="box-header with-border">
        			<h3 class="box-title">Ads Position</h3>
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
              <tbody>
								<tr>
	                <th>Name</th>
	                <th>Slug</th>
	                <th></th>
	              </tr>
              @if(!empty($postcat) and $postcat->count()>0)
              @foreach ($postcat as $cat)
              <tr>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->slug }}</td>
                <td>
                  <a href="/admin/ads/edit-position/{{ $cat->id }}">Edit</a> |
                  <a href="/admin/ads/delete-position/{{ $cat->id }}">Delete</a>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody></table>
            </div>
		      	<div class="box-footer">
		              {{ $postcat->links('admin.partials.paginators') }}
			    	</div>

        </div>
      </div>
			<div class="col-sm-4 col-xs-12">
				<div class="box box-primary">
		      		<div class="box-header with-border">
		      			<h3 class="box-title">Add Position</h3>
		      		</div>

		      		<form class="form-horizontal" name="frmAddCategory" action="/admin/ads/position" method="post">
                @if(!empty($position))
                  <input type="hidden" name="catid" value="{{ $position->id }}">
                @endif
								<input type="hidden" name="categoryType" value="ads">
  		      		<div class="box-body">
		                <div class="form-group">
		                  <label for="catName" class="col-sm-12 control-label lft-align">Position Name</label>
		                  <div class="col-sm-12">
		                    <input type="text" class="form-control" name="catName" id="catName" placeholder="Category name"
		                    			value="{{!empty($position) ? $position->name : '' }}">
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
