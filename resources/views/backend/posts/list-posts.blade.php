<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">{{ trans('labels.backend.post.all_post') }}</h3>

		<div class="box-tools pull-right">
			{{--@include('backend.products.includes.partials.page-header-buttons')--}}
		</div><!--box-tools pull-right-->

	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="table-responsive">
			<table id="article-table" class="table table-condensed table-hover">
				<thead>
				<tr>
					<th>{{ trans('labels.backend.post.table.title') }}</th>
					<th>{{ trans('labels.backend.post.table.slug') }}</th>
					<th>{{ trans('labels.backend.post.table.status') }}</th>
					<th>{{ trans('labels.backend.post.table.created') }}</th>
					<th>{{ trans('labels.backend.post.table.last_updated') }}</th>
					<th>{{ trans('labels.general.actions') }}</th>
				</tr>
				</thead>
				<tbody>
				@if(!empty($posts))
					@forelse ($posts as $post)
						<tr>
							<td> {!! $post->title !!} </td>
							<td>{!!$post->clean_url!!}</td>
							<td>
								@if ($post->status == 1)
									Publish
								@else
									Unpublish
								@endif
							</td>
							<td>{!!$post->created_at!!}</td>
							<td>{!!$post->updated_at!!}</td>
							<td>
								{{--<a href="{{ route('admin.page.page.show',$product->id) }}" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>--}}
								<a href="{{ route('admin.post.editPost',$post->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
								<a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="btn btn-xs btn-danger" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
									<form action="{{ route('admin.post.destroyPost',$post->id) }}" method="POST" name="delete_item" style="display:none">
										<input type="hidden" name="_method" value="delete">
										<input type="hidden" name="_token" value="{{ Session::token() }}">
									</form>
								</a>
								{{--<a href="{{ route('admin.product.listStock',$product->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="View Stock"></i></a>--}}
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6">No Posts added</td>
						</tr>
					@endforelse
				@endif
				</tbody>


			</table>
		</div><!--table-responsive-->
	</div><!-- /.box-body -->
</div><!--box-->