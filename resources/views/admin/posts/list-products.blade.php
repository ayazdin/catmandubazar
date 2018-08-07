<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">

		@if(!empty($products))
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box">
		      		<div class="box-header">
		      			<h3 class="box-title">Products</h3>
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
						    <tr>
							    <th>Title</th>
							    <th>Tags</th>
							    <th><i class="fa fa-fw fa-comments"></i></th>
							    <th>Published</th>
							    <th></th>
						    </tr>
								@inject('post', 'App\Http\Controllers\Posts\PostsController')
							@foreach ($products as $product)
							<tr>
              	<td>{{ $product->title }}</td>
              	<td>{!! $post->getMetaValue('hashtags', $product->id)!!}</td>
              	<td>{{ $product->cmt_count }}</td>
              	<td>
										@if($product->status=='publish')
											Published<br>
											{{Carbon\Carbon::parse($product->created_at)->format('d M, Y')}}
										@else
											Draft
										@endif
								</td>
              	<td>
									<a href="/admin/product/edit/{{$product->id}}">Edit</a> |
									<a href="#" data-href="/admin/post/delete/{{$product->id}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
								</td>
              </tr>
							@endforeach
						</table>
			        </div>
				</div>
			</div>
		</div>
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box box-default box-solid">
		      		<div class="box-body">
		              {{ $products->links('admin.partials.paginators') }}
		            </div>
			    </div>
			</div>
		</div>
		@endif
	</section>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
						Confirm Delete
				</div>
				<div class="modal-body">
						Are you sure to delete this product???
				</div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a class="btn btn-danger btn-ok">Delete</a>
				</div>
		</div>
	</div>
</div>
@push('adminjs')
<script>
$('#confirm-delete').on('show.bs.modal', function(e) {
	$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
</script>
@endpush
