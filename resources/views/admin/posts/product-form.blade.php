@push('admincss')
<link rel="stylesheet" href="/dist/css/select2.min.css">
@endpush
<div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Product Type</h3>
      </div>

      <form class="form-horizontal" name="frmAddProduct" id="frmAddProduct" action="/admin/post/add-product-type" method="post">
        @if(!empty($editcat))
          <input type="hidden" name="pcatid" value="">
        @endif
        <input type="hidden" name="pcategoryType" value="product">
      <div class="box-body">
            <div class="form-group">
              <label for="pcatName" class="col-sm-12 control-label lft-align">Product Type Name</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="pcatName" id="pcatName" placeholder="Product Type Name"
                      value="">
              </div>
            </div>
            <div class="form-group">
              <label for="catName" class="col-sm-12 control-label lft-align">Sub Category</label>
              <div class="col-sm-12">
                <select name="subcategory[]" class="form-control select2" multiple="multiple" data-placeholder="Select Category"
                        style="width: 100%;">
                    @if(!empty($subcategories) and $subcategories->count()>0)
                      @foreach($subcategories as $sb)
                          <option value="{{$sb->id}}">{{$sb->name}}</option>
                      @endforeach
                    @endif
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="pslug" class="col-sm-12 control-label lft-align">Slug</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="pslug" id="pslug" placeholder="Slug"
                      value="">
              </div>
            </div>
            <div class="non-pad col-sm-12">
              <div class="input-group">
               <span class="input-group-btn">
                 <a data-input="pthumbnail" data-preview="pholder" class="btn btn-primary uploadImage">
                   <i class="fa fa-picture-o"></i> Choose
                 </a>
               </span>
               <input id="pthumbnail" class="form-control" type="text" name="filepath" value="">
             </div>
             <div>
               <img id="pholder" style="margin-top:15px;max-height:100px;" src="">
             </div>
           </div>


      </div>

      <div class="box-footer">
          <button type="submit" class="btn btn-default">Save</button>
        </div>
        {!! csrf_field() !!}
        </form>

    </div>

    @push('adminjs')
    <!-- Select2 -->
    <script src="/dist/js/select2.full.min.js"></script>
    <script>
    $(function () {
    	$('.select2').select2()
    });
    </script>
    @endpush
