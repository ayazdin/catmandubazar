@extends('admin.layouts.admin-app')
@section('sidebar')
	@include('admin.partials.sidebar')
@endsection

@section('content')
	@include('admin.category.add-category-new')
	@include('admin.partials.footer')
@endsection

@section('footer-script')
	@include('admin.partials.footer-script')
@endsection
