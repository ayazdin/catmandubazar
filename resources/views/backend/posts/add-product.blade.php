@extends('backend.layouts.app')

@section ('title', trans('labels.backend.product.management'))

@section('page-header')
	<h1>
		{{ trans('labels.backend.product.management') }}
		<small>{{ trans('labels.backend.product.add_product') }}</small>
	</h1>
@endsection

@section('content')
	@include('backend.posts.add-product-form')

@endsection

