<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('labels.backend.page.all_page') }}</h3>

		<div class="box-tools pull-right">
			{{--@include('backend.page.includes.partials.page-header-buttons')--}}
		</div><!--box-tools pull-right-->
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="table-responsive">
			<table id="article-table" class="table table-condensed table-hover">
				<thead>
				<tr>
					<th>{{ trans('labels.backend.page.table.title') }}</th>
					<th>{{ trans('labels.backend.page.table.excerpt') }}</th>
					<th>{{ trans('labels.backend.page.table.status') }}</th>
					<th>{{ trans('labels.backend.page.table.created') }}</th>
					<th>{{ trans('labels.backend.page.table.last_updated') }}</th>
					<th>{{ trans('labels.general.actions') }}</th>
				</tr>
				</thead>
				<tbody>
				@if(!empty($pages))
					@forelse ($pages as $page)
						<tr>
							<td> {!! $page->title !!} </td>
							<td>{!!$page->excerpt!!}</td>
							<td>
								@if ($page->status == 1)
									Publish
								@else
									Unpublish
								@endif
							</td>
							<td>{!!$page->created_at!!}</td>
							<td>{!!$page->updated_at!!}</td>
							<td>
								{{--<a href="{{ route('admin.page.page.show',$page->id) }}" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>--}}
								<a href="{{ route('admin.page.createPage',$page->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
								<a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="btn btn-xs btn-danger" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
									<form action="{{ route('admin.page.destroyPage',$page->id) }}" method="POST" name="delete_item" style="display:none">
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ Session::token() }}">
									</form>
								</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6">No Pages added</td>
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

		@if(!empty($pages))
		<div class="row">
	    	<div class="col-xs-12">
		      	<div class="box">
		      		<div class="box-header">
		      			<h3 class="box-title">Pages</h3>
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
		          					<th>Excerpt</th>
							    <th>Published</th>
							    <th></th>
						    </tr>
                <!--inject('post', 'App\Http\Controllers\Posts\PostsController')-->
							@foreach ($pages as $page)
							<tr>
              	<td>{{ $page->title }}</td>
                <td>{{ $page->excerpt }}</td>
                <td>{!! $page->created_at!!}</td>
              	<td>
									<a href="{{url('/admin/page/edit/'.$page->id)}}">Edit</a> |
									<a href="{{url('/admin/page/delete/'.$page->id)}}">Delete</a>
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
		              {{ $pages->links('admin.partials.paginators') }}
		            </div>
			    </div>
			</div>
		</div>
		@endif
	</section>
</div>--}}
@section('after-scripts')
	{{ Html::script("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}
	{{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}

	<script>
		$(function () {
			$('#article-table').DataTable({
				"lengthMenu": [[ 25, 50, -1], [ 25, 50, "All"]],
				dom: 'lfrtip',
				processing: false,
				autoWidth: false,
				ordering: false,
			});
		});
	</script>
@endsection