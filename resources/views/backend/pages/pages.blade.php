@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.page.management'))

@section('after-styles')
	{{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
	<h1>
		{{ trans('labels.backend.page.management') }}
		<small>{{ trans('labels.backend.page.all_page') }}</small>
	</h1>
@endsection


@section('content')
	@include('backend.pages.list-pages')

@endsection

@section('after-script')
	@include('backend.partials.footer-script')
@endsection
