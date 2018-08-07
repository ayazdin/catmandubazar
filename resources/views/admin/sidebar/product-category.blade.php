@push('admincss')
<link rel="stylesheet" href="/dist/css/select2.min.css">
@endpush
<?php $subcat_options="";$prodtype_options="";?>
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Category</h3>
    </div>
    <div class="box-body">
        <div class="form-group no-mar">
          <div class="col-sm-12">
            <div class="category-list">
              <select name="category[]" id="category" class="form-control select2"
                      multiple="multiple" data-placeholder="Select Category"
                      style="width: 100%;">
                @if(!empty($ddlCat))
                @foreach($ddlCat as $cat)
                  <?php
                  if($cat['selected']=='selected' and !empty($cat['subcategory']))
                  {
                    $subcategories = $cat['subcategory'];
                    foreach($subcategories as $subcat)
                    {
                      if($subcat['selected']=='selected' and !empty($subcat['prodType']))
                      {
                        $prodTypes = $subcat['prodType'];
                        if(count($prodTypes)>0)
                        {
                          foreach($prodTypes as $pt)
                          {
                            $prodtype_options .= '<option value="'.$pt['id'].'" '.$pt['selected'].'>'.$pt['name'].'</option>';
                          }
                        }
                      }
                      $subcat_options .= '<option value="'.$subcat['id'].'" '.$subcat['selected'].'>'.$subcat['name'].'</option>';
                    }
                  }
                  //echo $subcat_options;
                  ?>
                  <option value="{{$cat['id']}}" {{$cat['selected']}}>{{$cat['name']}}</option>
                @endforeach
                @endif
              </select>

            </div>
          </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Sub Category</h3>
    </div>
    <div class="box-body">
        <div class="form-group no-mar">
          <div class="col-sm-12">
            <div class="category-list">
              <select name="category[]" id="subCategory" class="form-control select2"
                      multiple="multiple" data-placeholder="Select Sub Category"
                      style="width: 100%;">
                      <?php echo $subcat_options;?>
              </select>
            </div>
          </div>
        </div>
    </div>
</div>

@push('adminjs')
<!-- Select2 -->
<script src="/dist/js/select2.full.min.js"></script>
<script>
$(function () {
  $('.select2').select2();
  var _catArr= <?php echo json_encode($ddlCat ); ?>;
  //console.log(_catArr);
  $('#category').on('select2:select', function (e) {
      var data = e.params.data;
      $.each( _catArr, function( i, _catObj ) {
        if(_catObj.id==data.id)
        {
          _subCat = _catObj.subcategory;
          $.each(_subCat, function(i, _subCatObj){

              if ($('#subCategory').find("option[value='" + _subCatObj.id + "']").length) {
                  $('#subCategory').val(_subCatObj.id).trigger('change');
              } else {
                  // Create a DOM Option and pre-select by default
                  var newOption = new Option(_subCatObj.name, _subCatObj.id, false, false);
                  // Append it to the select
                  $('#subCategory').append(newOption).trigger('change');
              }
          });
        }
      });
  });

  $('#category').on('select2:unselect', function (e) {
    //var _unsel = e.params.data;
    var _selArr = $(this).select2('data');
    //console.log(_selArr);
    $('#subCategory').empty().trigger("change");


    $.each( _catArr, function( i, _catObj ) {
      $.each( _selArr, function( i, _selObj ){
          if(_catObj.id==_selObj.id)
          {
            _subCat = _catObj.subcategory;
            $.each(_subCat, function(i, _subCatObj){

                if ($('#subCategory').find("option[value='" + _subCatObj.id + "']").length) {
                    $('#subCategory').val(_subCatObj.id).trigger('change');
                } else {
                    // Create a DOM Option and pre-select by default
                    var newOption = new Option(_subCatObj.name, _subCatObj.id, false, false);
                    // Append it to the select
                    $('#subCategory').append(newOption).trigger('change');
                }
            });
          }
      });
    });
  });
  //console.log(_catArr);


  $('#subCategory').on('select2:select', function (e) {
      var data = e.params.data;
      var _selCat = $("#category").select2('data');
      var _selCatIds = [];
      $.each( _selCat, function( i, _selObj ) {
        _selCatIds.push(parseInt(_selObj.id)) ;
      });
      //console.log(_selCatIds);
      $.each( _catArr, function( i, _catObj ) {
        //_subCat = _catObj.subcategory;
        if($.inArray(_catObj.id, _selCatIds)>= 0)
        {
          _subCat = _catObj.subcategory;
          $.each(_subCat, function(i, _subCatObj){
            if(data.id == _subCatObj.id)
            {
              _prodType = _subCatObj.prodType;
              //console.log(_prodType);
              $.each(_prodType, function(i, _prodTypeObj){
                if ($('#prodType').find("option[value='" + _prodTypeObj.id + "']").length) {
                    $('#prodType').val(_prodTypeObj.id).trigger('change');
                } else {
                    // Create a DOM Option and pre-select by default
                    var newOption = new Option(_prodTypeObj.name, _prodTypeObj.id, false, false);
                    // Append it to the select
                    $('#prodType').append(newOption).trigger('change');
                }
              });
            }
          });
        }
      });
  });

  $('#subCategory').on('select2:unselect', function (e) {
    var _selArr = $(this).select2('data');
    var _selSubCatIds = [];
    $.each( _selArr, function( i, _selSubCatObj ) {
      _selSubCatIds.push(parseInt(_selSubCatObj.id)) ;
    });
    console.log(_selArr.id);
    $('#prodType').empty().trigger("change");
    var _selCat = $("#category").select2('data');
    var _selCatIds = [];
    $.each( _selCat, function( i, _selObj ) {
      _selCatIds.push(parseInt(_selObj.id)) ;
    });


    $.each( _catArr, function( i, _catObj ) {
      //_subCat = _catObj.subcategory;
      if($.inArray(_catObj.id, _selCatIds)>= 0)
      {
        _subCat = _catObj.subcategory;
        console.log(_subCat);
        $.each(_subCat, function(i, _subCatObj){
          console.log(_selArr.id+'----'+_subCatObj.id);
          if($.inArray(_subCatObj.id, _selSubCatIds)>= 0)
          {

            _prodType = _subCatObj.prodType;
            //console.log(_prodType);
            $.each(_prodType, function(i, _prodTypeObj){
              if ($('#prodType').find("option[value='" + _prodTypeObj.id + "']").length) {
                  $('#prodType').val(_prodTypeObj.id).trigger('change');
              } else {
                  // Create a DOM Option and pre-select by default
                  var newOption = new Option(_prodTypeObj.name, _prodTypeObj.id, false, false);
                  // Append it to the select
                  $('#prodType').append(newOption).trigger('change');
              }
            });
          }
        });
      }
    });


  });


});
</script>
@endpush
