<!-- jQuery 2.2.3 -->
<script src="{{url('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Select2 -->
<script src="{{url('plugins/select2/select2.full.min.js')}}"></script>
<script src="{{url('tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{url('tinymce/tinymce.min.js')}}"></script>
<script src="{{url('vendor/laravel-filemanager/js/lfm.js')}}"></script>

<script>
var editor_config = {
    path_absolute : "/",
    selector: "textarea.tinymce",height: 480,
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 2.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);



    $(".select2").select2();
  	$.widget.bridge('uibutton', $.ui.button);
  	$( "#btnSave" ).click(function() {
  		$("#action").attr('value', 'save');
  		$("#frmPrepareQuote").submit();
	});
	$( "#btnDone" ).click(function() {
		$("#action").attr('value', 'done');
		$("#frmPrepareQuote").submit();
	});
    $( "#btnOrder" ).click(function() {
        var quoteid = $("#qid").val();
        var processUrl = $("#orderUrl").val();
        console.log(quoteid +'----' + processUrl);
        //return false;

        $.ajax({
            type: "GET",
            url: processUrl,
            data: { qid : quoteid },
            success: function( data ) {
                $( "#btnOrder" ).hide();
                alert(data);
            }
        });
    });

    /*$("#orderStatus").on('change', function(){
        alert($(this).val());
    });*/
$(document).on('click', '.uploadImage' , function(e){
    console.log($(this).data('input'));
    localStorage.setItem('target_input', $(this).data('input'));
    localStorage.setItem('target_preview', $(this).data('preview'));
    window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
    return false;
});
$(document).ready(function () {

  $("#prodTitle").on('keyup', function(){
    prodttl = $(this).val();
    prodttl = prodttl.replace(/[^a-zA-Z0-9]/g,'-').replace(/-{2,}/g,'-');
    $("#prodSlug").val(prodttl.toLowerCase());
  });
  $("#frmAddCategory #catName").on('keyup', function(){
    prodttl = $(this).val();
    prodttl = prodttl.replace(/[^a-zA-Z0-9]/g,'-').replace(/-{2,}/g,'-')
    $("#frmAddCategory #slug").val(prodttl.toLowerCase());
  });
  $("#frmAddProduct #pcatName").on('keyup', function(){
    prodttl = $(this).val();
    prodttl = prodttl.replace(/[^a-zA-Z0-9]/g,'-').replace(/-{2,}/g,'-');
    $("#frmAddProduct #pslug").val(prodttl.toLowerCase());
  });

  $("#catName").on('keyup', function(){
    prodttl = $(this).val();
    //console.log(prodttl);
    prodttl = prodttl.replace(/[^a-zA-Z0-9]/g,'-').replace(/-{2,}/g,'-');
    //console.log(prodttl.toLowerCase());
    $("#slug").val(prodttl.toLowerCase());
  });

  $('#lfm').filemanager('image');
  $('.uploadImage').filemanager('image');

  $(".addCmt").click(function(event){
        event.preventDefault();
        if($('#cmt').summernote('isEmpty')===true)
        {
          alert("Comment field cannot be empty!!!")
          return false;
        }
        var data = $('.form-comment').serialize();
        var viewUrl = $(this).attr('href');
        $("#cmtProgress").modal({backdrop: "static"});
        //console.log(data);
        //return false;
        $.ajax({
            type: "POST",
            url: viewUrl,
            data: data,
            success: function( data ) {
                var cmtStr = '';
                quote = data['quote'];
                cmtStr += '<tr><td><div class="mar-bot-10">'+quote['comment']+'</div><div class="rht-align"><b>'+quote['author']+'</b><br><span class="cmt-time">'+quote['formatted']+'</span></div></td></tr>';
                cmt = data['comments'];
                //console.log(cmt);
                for(var i=0;i<cmt.length;i++)
                {
                    cmtStr += '<tr><td><div class="mar-bot-10">'+cmt[i]['comment']+'</div><div class="rht-align"><b>'+cmt[i]['author']+'</b><br><span class="cmt-time">'+cmt[i]['formatted']+'</span></div></td></tr>';
                    //$("#comments").scrollTop($("#comments")[0].scrollHeight+20);
                }
                $('#cmt').summernote('reset');//.code('');
                $("#comments").html(cmtStr);
                //$("#cmtBoxx").scrollTop($("#cmtBoxx")[0].scrollHeight);
                $('#cmtBoxx').stop().animate({
                    scrollTop: $('#cmtBoxx')[0].scrollHeight
                  }, 800);
                $("#cmtProgress").modal('hide');
            }
        });
    });

    $('#exchange').blur(function(){
        var exRate = $('#exchange').val();
        var exlink = $("#url").val();
        // console.log(exlink);
        // return false;
        $.ajax({
                type: "GET",
                url: exlink,
                data: { rate : exRate },
                success: function( msg ) {
                    alert(msg);
                    console.log(msg);
                }
            });
    });

    $('.slimScrollDiv').slimScroll({
        height: '250px'
    });

    var imgCount = parseInt($('#imgCount').val())+1;
    //console.log("imgCount: "+imgCount+" Till");
    //var imgCount = 2;
    $('.btnAddImage').on('click', function(){
      console.log(imgCount);//return false;
      $('#imageList').append('<div class="form-group img'+imgCount+'">'+
                                '<div class="col-xs-8">'+
                                  '<div class="input-group">'+
                                    '<span><div class="delImage" data-action="'+imgCount+'">'+
                                    '<i class="fa fa-fw fa-minus-circle"></i></div></span>'+
                                    '<span class="input-group-btn">'+
                                    '<a data-input="thumbinput'+imgCount+'" data-preview="thumholder'+imgCount+'" class="btn btn-primary uploadImage">'+
                                    '<i class="fa fa-picture-o"></i> Choose</a></span>'+
                                    '<input id="thumbinput'+imgCount+'" class="form-control" type="text" name="imagespath[]" value="">'+
                                    '</div></div>'+
                                    '<div class="col-xs-4"><img id="thumholder'+imgCount+'" style="max-height:40px;"></div></div>');
      imgCount++;
      return false;
    });

    $('#imageList').on('click', '.delImage', function(){
      delCount = $(this).data('action');
      console.log(delCount);
      $(".img"+delCount).remove();
      return false;
    });

    var optCount = $("#optCount").data('optioncount');
    var valCount = 2;
    $('.btnAddOption').on('click', function(){
      //console.log(optCount);//return false;

      $('#option-list').append('<div class="option-box optList'+optCount+'">'+
        '<input type="hidden" name="valueCount'+optCount+'" id="valueCount'+optCount+'" value="2">'+
        '<div class="form-group">'+
          '<label for="optName" class="col-sm-12 control-label lft-align">Name</label>'+
          '<div class="col-sm-12">'+
            '<input type="text" class="form-control" name="optName[]" placeholder="Option Name">'+
          '</div>'+
        '</div>'+
        '<div class="form-group option'+optCount+'value1">'+
          '<label class="col-sm-12 control-label lft-align">Value</label>'+
          '<div class="col-sm-12">'+
            '<input type="text" class="form-control opt-val mar-rht-10" name="optValue'+optCount+'[]" placeholder="value">'+
            /*'<input type="text" class="form-control opt-val" name="optPrice'+optCount+'[]" placeholder="price">'+*/
            '<div class="fa-add-but">'+
              '<a data-optioncount="'+optCount+'" class="btn btn-primary addOptValue">'+
                '<i class="fa fa-fw fa-plus-circle"></i>'+
              '</a>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="del-button-row delOptionButton'+optCount+'">'+
        '<button class="btn btn-danger btnDelOption" data-deloption="'+optCount+'">Delete Option</button>'+
      '</div>'+
      '<div class="hr'+optCount+'"><hr></div>');
      optionStr = $("#optionNumber").val();
      $("#optionNumber").attr('value', optionStr+","+optCount);

      optCount++;
      return false;
    });


    $('#option-list').on('click', '.addOptValue', function(){
      //valueNum = $(this).data('num');
      optionCount = $(this).data('optioncount');
      valueCount = parseInt($('#valueCount'+optionCount).val());
      console.log(valueCount);
      nextValue = valueCount+1;
      console.log('option: '+optionCount+' value: '+valueCount);
      //return false;
      $('.optList'+optionCount).append('<div class="form-group option'+optionCount+'value'+valueCount+'">'+
        '<label class="col-sm-12 control-label lft-align">Value</label>'+
        '<div class="col-sm-12">'+
          '<input type="text" class="form-control opt-val mar-rht-10" name="optValue'+optionCount+'[]" placeholder="value">'+
          /*'<input type="text" class="form-control opt-val" name="optPrice'+optionCount+'[]" placeholder="price">'+*/
          '<div class="fa-add-but">'+
            '<a data-optionCount="'+optionCount+'" data-valueCount="'+valueCount+'" class="btn btn-primary addOptValue">'+
              '<i class="fa fa-fw fa-plus-circle"></i>'+
            '</a>'+
          '</div>'+
          '<div class="fa-add-but">'+
            '<a data-optioncount="'+optionCount+'" data-valuecount="'+valueCount+'" class="btn btn-primary delOptValue">'+
              '<i class="fa fa-fw fa-minus-circle"></i>'+
            '</a>'+
          '</div>'+
        '</div>'+
      '</div>');
      $('#valueCount'+optionCount).attr('value', nextValue);

      return false;
    });

    $('#option-list').on('click', '.delOptValue', function(){
      delOptCount = $(this).data('optioncount');
      delValCount = $(this).data('valuecount');
      console.log('del Option: '+delOptCount+' del Value: '+delValCount);
      $(".option"+delOptCount+"value"+delValCount).remove();
      return false;
    });

    $('#option-list').on('click', '.btnDelOption', function(){

      delOption = $(this).data('deloption');
      console.log('Del Option Number: '+delOption);
      $('.optList'+delOption).remove();
      $('.delOptionButton'+delOption).remove();
      $('.hr'+delOption).remove();

      itemArray = new Array();
      delOptionStr = $("#optionNumber").val();
      itemArray = delOptionStr.split(',');
      var itemIndex = $.inArray(delOption.toString(), itemArray);
      //console.log("Array: "+itemArray);
      //console.log(itemIndex)
      if (itemIndex != -1) {
          itemArray.splice(itemIndex, 1);
      }
      itemStr = itemArray.join(',');
      $("#optionNumber").attr('value', itemStr);

      return false;
    });

    $('.payCheck').on('change', function(){
        var thVal = this.value;
        var thArr = thVal.split('-');
        var exlink = $("#payUrl").val();
        console.log({ ordid : thArr[0], pay_status : thArr[1] });
        //return false;
        $.ajax({
                type: "GET",
                url: exlink,
                data: { ordid : thArr[0], pay_status : thArr[1] },
                success: function( msg ) {
                    //alert(msg);
                    console.log(msg);
                }
            });
    });

    $('#cmt').summernote();
});
$('.itemCategory').select2({
    placeholder: 'Select category',
    ajax: {
        url: 'auto-search-category/',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            console.log(data);
            return {
                results: data
            };
        },
        cache: true
    }
});

$( "#fromdate" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
});
$( "#todate" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
});
</script>


<!-- Bootstrap 3.3.6 -->
<script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{url('/summernote/summernote.min.js')}}"></script>

@stack('adminjs')
