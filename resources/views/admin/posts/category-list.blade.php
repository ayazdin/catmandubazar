@push('admincss')
<link rel="stylesheet" href="{{url('/dist/css/select2.min.css')}}">
@endpush
@if(!empty($postcat) and count($postcat)>0)
  @foreach ($postcat as $cat)
  <div class="box box-primary collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">{{$cat['name']}} -
        <a href="{{url('/admin/product/category/add/'.$cat['id'])}}">Edit</a> |
        <a href="{{url('/admin/product/category/delete/'.$cat['id'])}}">Delete</a>
      </h3>

      <div class="box-tools pull-right collapsed-box">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="display:none;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Image</th>
            <th>Slug</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $subcats = $cat['subcategory'];
          foreach($subcats as $sb)
          {?>
          <tr data-toggle="collapse" data-target="#accordion{{$sb['id']}}" class="clickable">
            <td>{{$sb['name']}}</td>
            <td>@if($sb['image']!="") <img src="{{$sb['image']}}" width="40" alt="{{ $sb['name'] }}"> @endif</td>
            <td>{{$sb['slug']}}</td>
            <td>
              <a href="{{url('/admin/product/category/add/'.$sb['id'])}}">Edit</a> |
              <a href="{{url('/admin/product/category/delete/'.$sb['id'])}}">Delete</a>
            </td>
          </tr>
          <tr id="accordion{{$sb['id']}}" class="collapse">
            <td colspan="4" style="background-color: #ccc;">
              <?php
              $prodtype = $sb['prodType'];
              if(count($prodtype)>0)
              {
              ?>
                <div style="text-align: center;"><strong>Product Type</strong></div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Slug</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prodtype as $pt)
                    <tr>
                      <td>{{$pt['name']}}</td>
                      <td>@if($pt['image']!="") <img src="{{$pt['image']}}" width="40" alt="{{ $pt['name'] }}"> @endif</td>
                      <td>{{$pt['slug']}}</td>
                      <td>
                        <a href="#" data-toggle="modal"
                                    data-target="#modalProdTypeForm"
                                    data-id="{{$pt['id']}}"
                                    data-name="{{$pt['name']}}"
                                    data-slug="{{$pt['slug']}}"
                                    data-image="{{$pt['image']}}"
                        >
                          Edit
                        </a> |
                        <a href="{{url('/admin/product/category/delete/'.$pt['id'])}}">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              <?php } else {?>
                  <div style="text-align: center;"><strong>No Product type assigned</strong></div>
              <?php }?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  @endforeach
@else
<div class="box box-primary collapsed-box">
  <div class="box-header with-border">
    <h3 class="box-title">No Record Found</h3>
  </div>
</div>
@endif

<div class="modal fade" id="modalProdTypeForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Edit Product Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/admin/post/store-product-type')}}" method="post" name="frmEnquiry">
            <input type="hidden" name="catid" id="catid" value="">
            <input type="hidden" name="categoryType" value="product">
            <div class="modal-body mx-3">

                <div class="md-form mb-4">
                  <input type="text" class="form-control validate" name="catName" id="catName" placeholder="Product Type" value="">
                    <label data-error="wrong" data-success="right" for="catName">Product Type</label>
                </div>

                <div class="md-form mb-4">
                    <select name="subcategory[]" id="subcategory" class="form-control select2" multiple="multiple" data-placeholder="Select Category"
                            style="width: 100%;">
                        @if(!empty($subcategories) and $subcategories->count()>0)
                          @foreach($subcategories as $sb)
                              <option value="{{$sb->id}}">{{$sb->name}}</option>
                          @endforeach
                        @endif
                    </select>
                    <label data-error="wrong" data-success="right" for="subcategory">Sub Category</label>
                </div>

                <div class="md-form mb-4">
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
                          value="">
                    <label data-error="wrong" data-success="right" for="slug">Slug</label>
                </div>

                <div class="md-form mb-4">
                    <div class="input-group">
                     <span class="input-group-btn">
                       <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                         <i class="fa fa-picture-o"></i> Choose
                       </a>
                     </span>
                     <input id="thumbnail" class="form-control" type="text" name="filepath" value="">
                   </div>
                   <div>
                     <img id="holder" style="margin-top:15px;max-height:100px;" src="">
                   </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary">Update</button>
            </div>
            {!! csrf_field() !!}
            </form>
        </div>
    </div>
</div>
@push('adminjs')
<script>
$('#modalProdTypeForm').on('show.bs.modal', function(e) {
	$(this).find('#catid').attr('value', $(e.relatedTarget).data('id'));
  $(this).find('#catName').attr('value', $(e.relatedTarget).data('name'));
  $(this).find('#slug').attr('value', $(e.relatedTarget).data('slug'));
  $(this).find('#thumbnail').attr('value', $(e.relatedTarget).data('image'));
  $(this).find('#holder').attr('src', $(e.relatedTarget).data('image'));
    $.ajax({
               type:'GET',
               url:"/admin/product/type/relation/"+$(e.relatedTarget).data('id'),
               success:function(data){
                  $("#subcategory").html(data);
               }
            });
});
</script>
@endpush
