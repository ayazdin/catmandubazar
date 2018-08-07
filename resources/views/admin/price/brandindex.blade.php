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
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($brands))
                                    @forelse($brands as $brand)
                                        <tr>
                                            <td>{!!  $brand->title !!}</td>
                                            <td>{!!  $brand->content !!}</td>
                                            <td>{!!  $brand->status !!}</td>
                                            <td>
                                            <td>
                                                <a href="/admin/price/brand/{{$brand['id']}}">Edit</a> |
                                                <a href="/admin/price/brand/delete/{{$brand['id']}}">Delete</a>
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
                            <h3 class="box-title">Add Brands</h3>
                        </div>

                        <form class="form-horizontal" name="frmAddCategory" id="frmAddCategory"
                              action="/admin/price/brand-store" method="post">
                            @if(!empty($editcat))
                                <input type="hidden" name="catid" value="{{ $editcat->id }}">
                            @endif

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="catName" class="col-sm-12 control-label lft-align">Brand</label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="brandName" id="brandName"
                                               placeholder="Brand name"
                                               value="{{!empty($editcat) ? $editcat->title : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="slug" class="col-sm-12 control-label lft-align">Slug</label>

                                    <div class="col-sm-12">

                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
                                               value="{{!empty($editcat) ? $editcat->slug : '' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catName" class="col-sm-12 control-label lft-align">Description</label>

                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="description" id="description">{{!empty($editcat) ? $editcat->content : '' }}</textarea>

                                    </div>
                                </div>


                                <div class="non-pad col-sm-12">
                                    <div class="input-group">
                                         <span class="input-group-btn">
                                           <a data-input="cthumbnail" data-preview="cholder"
                                              class="btn btn-primary uploadImage">
                                               <i class="fa fa-picture-o"></i> Choose
                                           </a>
                                         </span>
                                        <input id="cthumbnail" class="form-control" type="text" name="filepath"
                                               value="{{!empty($editcat) ? $editcat->logo : '' }}">
                                    </div>
                                    <div>
                                        <img id="cholder" style="margin-top:15px;max-height:100px;"
                                             src="{{!empty($editcat) ? $editcat->logo : '' }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-12 control-label lft-align">Publish</label>
                                    <div class="col-md-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="Publish" <?php echo(isset($editcat->status)&&(($editcat->status)=="Publish"))?"checked":"checked"; ?>>
                                                Publish
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="Unpublish" <?php echo(isset($editcat->status)&&(($editcat->status)=="Unpublish"))?"checked":""; ?>>
                                                Unpublish
                                            </label>
                                        </div>
                                    </div><!--col-->
                                </div><!--form-group-->

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
