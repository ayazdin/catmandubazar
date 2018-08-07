<?php
$cat="";$scat="";$isFeatured="";$tags="";$price="";$keywords="";$metadesc="";
$purchase="";$quantity="";$buyurl="";$images="";$stock="";$currency="";
$showPrice="";$showQty=""; $showStock=""; $showDesc="";$options="";$priceOptions="";
if(!empty($postmeta))
{
  foreach($postmeta as $pm)
  {
    if($pm->meta_key=='category')
      $cat = $pm->meta_value;
    if($pm->meta_key=='sub-cat')
      $scat = $pm->meta_value;
    if($pm->meta_key=='isFeatured')
      $isFeatured = $pm->meta_value;
    if($pm->meta_key=='hashtags')
        $tags = $pm->meta_value;
    if($pm->meta_key=='price')
        $price = $pm->meta_value;
    if($pm->meta_key=='keywords')
        $keywords = $pm->meta_value;
    if($pm->meta_key=='metadesc')
        $metadesc = $pm->meta_value;
    if($pm->meta_key=='purchase')
        $purchase = $pm->meta_value;
    if($pm->meta_key=='quantity')
        $quantity = $pm->meta_value;
    if($pm->meta_key=='buyurl')
        $buyurl = $pm->meta_value;
    if($pm->meta_key=='images')
        $images = $pm->meta_value;
    if($pm->meta_key=='currency')
        $currency = $pm->meta_value;
    if($pm->meta_key=='stock')
        $stock = $pm->meta_value;
    if($pm->meta_key=='showPrice')
        $showPrice = $pm->meta_value;
    if($pm->meta_key=='showQty')
        $showQty = $pm->meta_value;
    if($pm->meta_key=='showStock')
        $showStock = $pm->meta_value;
    if($pm->meta_key=='showDesc')
        $showDesc = $pm->meta_value;
    if($pm->meta_key=='options')
      $options = unserialize($pm->meta_value);
    if($pm->meta_key=='priceOption')
        $priceOptions = unserialize($pm->meta_value);
  }
}
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
  <form class="form-horizontal" name="frmAddPost" action="/admin/post/store" method="post">
	<section class="content-header">
		<div class="row">
			<div class="col-xs-8">
        @include('admin.traits.product-editor')

        @include('admin.traits.product-image')

        @include('admin.traits.product-option-new')

			</div>

      <div class="col-xs-4">
        @include('admin.sidebar.publish')

        @include('admin.sidebar.product-category')

        <?php /*include('admin.sidebar.product-home-slider')*/?>

        @include('admin.sidebar.product-featured-image')

        @include('admin.sidebar.product-attribute')

        @include('admin.sidebar.product-seo')

      </div>

		</div>
    {!! csrf_field() !!}
    </form>
	</section>
</div>
@push('adminjs')
<script>
var _next = 0;
$('#addPrice').on('click', function(e){
  e.preventDefault();
  _next = $("#addPriceSelection").attr('data-nextsel');
  console.log("next: "+_next);
  addPricingBlock();
});

$("#addPriceSelection").on('click', function(e){
  e.preventDefault();
  _next = $(this).attr('data-nextsel');
  console.log("next11: "+_next);
  addPricingBlock();
  $(".price-list").append('<div class="sep'+_next+'"><hr></div>');
});
$('.price-list').on('click', '.delPriceField', function(){
  var _rowid = $(this).data('price-field');
  $(".priceField"+_rowid).remove();
  $(".sep"+_rowid).remove();
  _selCount = parseInt($("#priceSelCount").val());
  $("#priceSelCount").val(_selCount-1);
  //console.log(_rowid)
});
function addPricingBlock()
{
  var _optString = "";
  var _optValues = [];
  var _optSel = "";
  var _options = $("input[name='optName[]']")
          .map(function(){return $(this).val();}).get();

  var _optNumber = $("#optionNumber").val();
  console.log("OPtion Number: "+_optNumber);
  var _optArr = _optNumber.split(",");
  for(var i=0; i<_optArr.length;i++)
  {
    _optString='<option value="">Select</option>';
    var _optSet = $("input[name='optValue"+_optArr[i]+"[]']")
            .map(function(){return $(this).val();}).get();
    for(var j=0; j<_optSet.length;j++)
    {
      _optString += '<option value="'+_optSet[j]+'">'+_optSet[j]+'</option>';
    }
    _optValues[i]=_optString;
    _fieldNameStr = _options[i].toLowerCase();
    var _fieldName = _fieldNameStr.replace(/[^A-Z0-9]+/ig, "_");
    _optSel += '<div class="col-sm-4">'+
                '<label class="control-label lft-align">'+_options[i]+'</label>'+
                '<select class="form-control" name="'+_fieldName+'_sel[]">'+_optValues[i]+
                '</select>'+
              '</div>';

  }

    _output = '<div class="row form-group priceField'+_next+'">'+_optSel+
      '<div class="col-sm-4">'+
        '<label class="control-label lft-align">Price</label><br>'+
        '<input type="text" class="form-control pfld" name="selPrice[]">'+
        '<a data-price-field="'+_next+'" class="btn btn-primary delPriceField">'+
            '<i class="fa fa-fw fa-minus-circle"></i>'+
          '</a>'+
      '</div>'+
    '</div>';
  $(".price-list").append(_output);
  var _psc = parseInt($("#priceSelCount").val())+1;
  $("#priceSelCount").val(_psc);
  //_next = ;
  console.log("nextsel: "+_next);
  $("#addPriceSelection").attr('data-nextsel', parseInt(_next)+1);
}
</script>
@endpush
