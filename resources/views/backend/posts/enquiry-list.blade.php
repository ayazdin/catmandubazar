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
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.product.all_product') }}</h3>

            <div class="box-tools pull-right">
                {{--@include('backend.products.includes.partials.page-header-buttons')--}}
            </div><!--box-tools pull-right-->

        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="article-table" class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Phone</th>
                        <th>User Message</th>
                        <th>{{ trans('labels.backend.product.table.created') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($enquiries))
                        @forelse ($enquiries as $product)
                            <tr>
                                <td> {!! $product->productname !!} </td>
                                <td> {!! $product->name !!} </td>
                                <td>{!!$product->email!!}</td>
                                <td>{!!$product->phone!!}</td>
                                <td>{!!$product->message!!}</td>

                                <td>{!!$product->created_at!!}</td>
                                <td>
                                    {{--<a href="{{ route('admin.page.page.show',$product->id) }}" class="btn btn-xs btn-info"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>--}}
                                    <a href="{{ route('admin.product.editProduct',$product->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    <a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="btn btn-xs btn-danger" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i>
                                        <form action="{{ route('admin.product.destroyEnquiry',$product->id) }}" method="POST" name="delete_item" style="display:none">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                                        </form>
                                    </a>
                                    {{--<a href="{{ route('admin.product.listStock',$product->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-search" data-toggle="tooltip" data-placement="top" title="View Stock"></i></a>--}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No products added</td>
                            </tr>
                        @endforelse
                    @endif
                    </tbody>


                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
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