@extends('backend.layouts.app')

@section ('title', trans('labels.backend.post.management'))

@section('page-header')
	<h1>
		{{ trans('labels.backend.post.management') }}
		<small>{{ trans('labels.backend.product.add_post') }}</small>
	</h1>
@endsection

@section('content')
	@include('backend.posts.add-posts-form')
@endsection
