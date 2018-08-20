@extends('backend.layouts.app')

@section ('title', trans('labels.backend.post.management'))

@section('after-styles')
	{{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
	<h1>
		{{ trans('labels.backend.post.management') }}
		<small>{{ trans('labels.backend.post.category') }}</small>
	</h1>
@endsection

@section('content')
	@include('backend.posts.add-post-category-form')
@endsection

