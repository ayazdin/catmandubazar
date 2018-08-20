@extends('backend.layouts.app')

@section ('title', trans('labels.backend.product.management'))

@section('after-styles')
	{{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection


@section('page-header')
	<h1>
		{{ trans('labels.backend.product.management') }}
		<small>{{ trans('labels.backend.product.all_product') }}</small>
	</h1>
@endsection

@section('content')
	@include('backend.posts.list-products')

@endsection

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


