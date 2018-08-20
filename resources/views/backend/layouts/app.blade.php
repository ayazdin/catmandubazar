<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', app_name())</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Default Description')">
        <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('/css/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" href="{{url('/css/select2.min.css')}}">
        @langRTL
            {{ Html::style(getRtlCss(mix('css/backend.css'))) }}
        @else
            {{ Html::style(mix('css/backend.css')) }}
        @endif
        <link rel="stylesheet" href="{{url('/css/custom-admin.css')}}">
        @yield('after-styles')

        <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        {{ Html::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
        {{ Html::script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js') }}
        <![endif]-->

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body class="skin-{{ config('backend.theme') }} {{ config('backend.layout') }}">
        @include('includes.partials.logged-in-as')

        <div class="wrapper">
            @include('backend.includes.header')
            @include('backend.includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('page-header')

                    {{-- Change to Breadcrumbs::render() if you want it to error to remind you to create the breadcrumbs for the given route --}}
                    {!! Breadcrumbs::renderIfExists() !!}
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="loader" style="display: none;">
                        <div class="ajax-spinner ajax-skeleton"></div>
                    </div><!--loader-->

                    @include('includes.partials.messages')
                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            @include('backend.includes.footer')
        </div><!-- ./wrapper -->

        <!-- JavaScripts -->
        @yield('before-scripts')
        {{ Html::script(mix('js/backend.js')) }}
        @yield('after-scripts')
        <script src="{{ URL::to('js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ URL::to('vendor/laravel-filemanager/js/lfm.js') }}"></script>

        <script src="{{ URL::to('js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::to('js/select2/select2.full.min.js') }}"></script>
        <script>
            var editor_config = {
                path_absolute : "{{ URL::to('/') }}/",
                selector: ".tinymce",
                height: 300,
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
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                }
            };
            tinymce.init(editor_config);

            var domain = "";
            $('#lfm').filemanager('image', {prefix: domain});
            $('.uploadImage').filemanager('image', {prefix: domain});
            $(document).on('click', '.uploadImage' , function(e){
                localStorage.setItem('target_input', $(this).data('input'));
                localStorage.setItem('target_preview', $(this).data('preview'));
                window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
                return false;
            });


            $( document ).ready(function() {
                $(".select2").select2();


                $('.form-horizontal #title').keyup(function(){
                    var articleTitle= $('.form-horizontal #title').val();
                    var slug = articleTitle.toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-')
                    $('.form-horizontal #slug').val(slug);
                });

                var imgCount = parseInt($('#imgCount').val())+1;
                $('.btnAddImage').on('click',function(){
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

                $('#imageList').on('click','.delImage',function(){
                    delCount = $(this).data('action');
                    console.log(delCount);
                    $('.img'+delCount).remove();
                    return false;
                });


                var optCount = $("#optCount").data('optioncount');
                var valCount = 2;
                $('.btnAddOption').on('click', function(){
                    console.log(optCount);//return false;

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
                            '<input type="text" class="form-control opt-val mar-rht-10" name="optPrice'+optCount+'[]" placeholder="price">'+
                            '<div class="wid20"><div class="fa-add-but">'+
                            '<a data-optioncount="'+optCount+'" class="btn btn-primary addOptValue">'+
                            '<i class="fa fa-fw fa-plus-circle"></i>'+
                            '</a>'+
                            '</div></div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="del-button-row delOptionButton'+optCount+'">'+
                            '<button class="btn btn-danger btnDelOption" data-deloption="'+optCount+'">Delete Option</button>'+
                            '</div>'+
                            '<div class="hr'+optCount+' hrborder"><hr></div>');
                    optionStr = $("#optionNumber").val();
                    $("#optionNumber").attr('value', optionStr+","+optCount);
                    optCount++;
                    return false;
                });


                $('#option-list').on('click', '.addOptValue', function(){
                    //valueNum = $(this).data('num');
                    optionCount = $(this).data('optioncount');
                    valueCount = parseInt($('#valueCount'+optionCount).val());
                    nextValue = valueCount+1;
                    console.log('option: '+optionCount+' value: '+valueCount);
                    //return false;
                    $('.optList'+optionCount).append('<div class="form-group option'+optionCount+'value'+valueCount+'">'+
                            '<label class="col-sm-12 control-label lft-align">Value</label>'+
                            '<div class="col-sm-12">'+
                            '<input type="text" class="form-control opt-val mar-rht-10" name="optValue'+optionCount+'[]" placeholder="value">'+
                            '<input type="text" class="form-control opt-val mar-rht-10" name="optPrice'+optionCount+'[]" placeholder="price">'+
                            '<div class="wid20">' +
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
                            '</div>'+
                            '</div>');
                    $('#valueCount'+optionCount).attr('value', nextValue);


                    return false;
                });

                $('#option-list').on('click', '.delOptValue', function(){
                    delOptCount = $(this).data('optioncount');
                    delValCount = $(this).data('valuecount');
                    console.log('del Option: '+delOptCount+' del Value: '+delValCount);
                    $(this).closest(".option"+delOptCount+"value"+delValCount).remove();
                    //$(".option"+delOptCount+"value"+delValCount).remove();
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


                $('#datefrom,#dateto').datepicker({
                    format: 'mm-dd-yyyy',
                    startDate: new Date()
                });

                $('#bought_date').datepicker({
                    format: 'yyyy-mm-dd',
                });

            });
        </script>

    </body>
</html>