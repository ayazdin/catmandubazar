@extends('admin.layouts.admin-app')
@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <div class="box box-primary">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($postcat))
                                    @forelse($postcat as $brand)
                                        <tr>
                                            <td>{!!  $brand['name'] !!}</td>
                                            <td>
                                            <td>
                                                <a href="/admin/price/category/{{$brand['id']}}">Edit</a> |
                                                <a href="/admin/price/category/delete/{{$brand['id']}}">Delete</a>
                                            </td>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No Brands added</td>
                                        </tr>
                                    @endforelse
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>




                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Category</h3>
                        </div>

                        <form class="form-horizontal" name="frmAddCategory" id="frmAddCategory" action="/admin/price/store" method="post">
                            @if(!empty($editcat))
                                <input type="hidden" name="catid" value="{{ $editcat->id }}">
                            @endif
                            <input type="hidden" name="categoryType" value="price">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="catName" class="col-sm-12 control-label lft-align">Category</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="catName" id="catName" placeholder="Category name"
                                               value="{{!empty($editcat) ? $editcat->name : '' }}">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="slug" class="col-sm-12 control-label lft-align">Slug</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
                                               value="{{!empty($editcat) ? $editcat->slug : '' }}">
                                    </div>
                                </div>
                                <div class="non-pad col-sm-12">
                                    <div class="input-group">
                 <span class="input-group-btn">
                   <a data-input="cthumbnail" data-preview="cholder" class="btn btn-primary uploadImage">
                       <i class="fa fa-picture-o"></i> Choose
                   </a>
                 </span>
                                        <input id="cthumbnail" class="form-control" type="text" name="filepath" value="{{!empty($editcat) ? $editcat->image : '' }}">
                                    </div>
                                    <div>
                                        <img id="cholder" style="margin-top:15px;max-height:100px;" src="{{!empty($editcat) ? $editcat->image : '' }}">
                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Save</button>
                            </div>
                            {!! csrf_field() !!}
                        </form>
                    </div>

                </div>
            </div>

        </section>
    </div>


    @include('admin.partials.footer')
@endsection

@section('footer-script')
    @include('admin.partials.footer-script')
@endsection
