<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('labels.backend.product.all_product') }}</h3>

		<div class="box-tools pull-right">
			{{--@include('backend.products.includes.partials.page-header-buttons')--}}
		</div><!--box-tools pull-right-->

	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="table-responsive">
			<table id="article-table" class="table table-condensed table-hover">
				<thead>
				<tr>
					<th>{{ trans('labels.backend.product.table.title') }}</th>
					<th>{{ trans('labels.backend.product.table.slug') }}</th>
					<th>{{ trans('labels.backend.product.table.status') }}</th>
					<th>{{ trans('labels.backend.product.table.created') }}</th>
					<th>{{ trans('labels.backend.product.table.last_updated') }}</th>
					<th>{{ trans('labels.general.actions') }}</th>
				</tr>
				</thead>
				<tbody>
				@if(!empty($products))
					@forelse ($products as $product)
						<tr>
							<td> {!! $product->title !!} </td>
							<td>{!!$product->clean_url!!}</td>
							<td>
								@if ($product->status == 1)
									Publish
								@else
									Unpublish
								@endif
							</td>
							<td>{!!$product->created_at!!}</td>
							<td>{!!$product->updated_at!!}</td>
							<td>
								{{--<a href="{{ route('admin.page.page.show',$product->id) }}" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>--}}
								<a href="{{ route('admin.product.editProduct',$product->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
								<a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="btn btn-xs btn-danger" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
									<form action="{{ route('admin.product.destroyProduct',$product->id) }}" method="POST" name="delete_item" style="display:none">
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ Session::token() }}">
									</form>
								</a>
								{{--<a href="{{ route('admin.product.listStock',$product->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="View Stock"></i></a>--}}
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6">No products added</td>
						</tr>
					@endforelse
				@endif
				</tbody>


			</table>
		</div><!--table-responsive-->
	</div><!-- /.box-body -->
</div><!--box-->


{{--<div class="content-wrapper">
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
								--}}{{--@inject('post', 'App\Http\Controllers\Backend\Posts\PostsController')--}}{{--
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
									<a href="{{url('/admin/product/edit/'.$product->id)}}">Edit</a> |
									<a href="#" data-href="{{url('/admin/product/delete/'.$product->id)}}" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
		              --}}{{--{{ $products->links('admin.partials.paginators') }}--}}{{--
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
@endpush--}}
