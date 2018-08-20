@if(!empty($postcat) and count($postcat)>0)
  @foreach ($postcat as $cat)
  <div class="box box-primary collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">{{$cat['name']}} -
        <a href="/admin/post/category/{{$cat['id']}}">Edit</a> |
        <a href="/admin/post/category/delete/{{$cat['id']}}">Delete</a>
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
              <a href="/admin/post/category/{{$sb['id']}}">Edit</a> |
              <a href="/admin/post/category/delete/{{$sb['id']}}">Delete</a>
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
    <h3 class="box-title">No Category Found</h3>
  </div>
</div>
@endif
