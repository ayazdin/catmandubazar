<div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Add Category</h3>
      </div>

      <form class="form-horizontal" name="frmAddCategory" id="frmAddCategory" action="{{url('/admin/product/store-category')}}" method="post">
        @if(!empty($editcat))
          <input type="hidden" name="catid" value="{{ $editcat->id }}">
        @endif
        <input type="hidden" name="categoryType" value="category">
        <div class="box-body">
            <div class="form-group">
              <label for="catName" class="col-sm-12 control-label lft-align">Category</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" name="catName" id="title" placeholder="Category name"
                      value="{{!empty($editcat) ? $editcat->name : '' }}">
              </div>
            </div>
            <div class="form-group">
              <label for="catName" class="col-sm-12 control-label lft-align">Parent</label>
              <div class="col-sm-12">
                <select name="subCat" id="subCat" class="form-control ">
                  <option value="0">Please Select</option>
                  @if(!empty($postcat) and count($postcat)>0)
                    @foreach ($postcat as $cat)
                        @if(!empty($editcat))
                          <option value="{{$cat['id']}}" @if($cat['id']==$editcat->parent) selected  @endif
                          @if($cat['id']==$editcat->id) disabled  @endif
                                  >{{$cat['name']}}</option>
                        @else
                          <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                        @endif
                    @endforeach
                  @endif
                </select>
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
