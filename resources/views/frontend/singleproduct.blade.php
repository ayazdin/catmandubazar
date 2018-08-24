<?php
$cat = "";$scat = "";$isFeatured = "";$tags = "";$price = "";$keywords = "";$metadesc = "";
$purchase = "";$quantity = "";$buyurl = "";$images = "";$stock = "";$currency = "";
$showPrice = "";$showQty = ""; $showStock = ""; $showDesc = "";$options = "";$priceOptions = "";
if (!empty($postmeta)) {
    foreach ($postmeta as $pm) {
        if ($pm->meta_key == 'category')
            $cat = $pm->meta_value;
        if ($pm->meta_key == 'sub-cat')
            $scat = $pm->meta_value;
        if ($pm->meta_key == 'isFeatured')
            $isFeatured = $pm->meta_value;
        if ($pm->meta_key == 'hashtags')
            $tags = $pm->meta_value;
        if ($pm->meta_key == 'price')
            $price = $pm->meta_value;
        if ($pm->meta_key == 'keywords')
            $keywords = $pm->meta_value;
        if ($pm->meta_key == 'metadesc')
            $metadesc = $pm->meta_value;
        if ($pm->meta_key == 'purchase')
            $purchase = $pm->meta_value;
        if ($pm->meta_key == 'quantity')
            $quantity = $pm->meta_value;
        if ($pm->meta_key == 'buyurl')
            $buyurl = $pm->meta_value;
        if ($pm->meta_key == 'images')
            $images = $pm->meta_value;
        if ($pm->meta_key == 'currency')
            $currency = $pm->meta_value;
        if ($pm->meta_key == 'stock')
            $stock = $pm->meta_value;
        if ($pm->meta_key == 'showPrice')
            $showPrice = $pm->meta_value;
        if ($pm->meta_key == 'showQty')
            $showQty = $pm->meta_value;
        if ($pm->meta_key == 'showStock')
            $showStock = $pm->meta_value;
        if ($pm->meta_key == 'showDesc')
            $showDesc = $pm->meta_value;
        if ($pm->meta_key == 'options')
            $options = unserialize($pm->meta_value);
        if ($pm->meta_key == 'priceOption')
            $priceOptions = unserialize($pm->meta_value);
    }
}
?>
@extends('frontend.layouts.app')

@section('title',  config('app.name').' | '.$post->title)

@section('keywords',  $keywords)
@section('description',  $metadesc)
@section('url',   URL::to('product/'.$post->clean_url))
@section('image',  URL::to($post->image))



@section('content')
    <style type="text/css">
        #productCarousel .list-inline {
            /*white-space:nowrap;
            overflow-x:auto;*/
        }

        #productCarousel .carousel-indicators {
            position: static;
            /*left: initial;
            width: initial;*/

            margin:12px 0px 10px 0px
        }

        #productCarousel .carousel-indicators > li {
            width: initial;
            height: initial;
            text-indent: initial;
            display: inline-table;
        }

        #productCarousel .carousel-indicators > li.active img {
            opacity: 0.7;
        }

        #productCarousel .carousel-inner img{
            width: 100%;
            height: 400px;
            object-fit: contain;
        }
        #productCarousel .carousel-indicators li img{
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        #productCarousel .carousel-control{
            top: 40%;
            position: absolute;
            font-size: 26px;
            color: #eaa27f;
        }

        #productCarousel .carousel-control.right{
            right: 0;
        }

        .img-zoom-container {
            position: relative;
        }

        .img-zoom-lens {
            position: absolute;
            border: 1px solid #d4d4d4;
            /*set the size of the lens:*/
            width: 80px;
            height: 80px;
        }

        .img-zoom-result {
            border: 1px solid #d4d4d4;
            /*set the size of the result div:*/
            width: 400px;
            height: 400px;
        }

    </style>
    <div class="productpage">
        <div class="row">
            <div class="col-md-5">
                <!-- {{ App\Http\Controllers\Frontend\FrontendController::getThumbnail($post->image) }} -->
                <div class="prodimage">
                    <div class="prodimageslider">


                        <div id="productCarousel" class="carousel slide">
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <div class="active item carousel-item img-zoom-container"  data-slide-number="0">
                                    <img  id="myimage"  src="{{URL::to($post->image)}}" class="">
                                </div>

                                <?php if($images != ""){
                                $imgArr = unserialize($images);
                                foreach($imgArr as $img){
                                if($img != ''){
                                ?>
                                <div class="item carousel-item img-zoom-container"   data-slide-number="1">
                                    <img id="myimage" src="{{url::to($img)}}" class="">
                                </div>
                                <?php }
                                }
                                }?>

                                <a class="carousel-control left pt-3" href="#productCarousel" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                                <a class="carousel-control right pt-3" href="#productCarousel" data-slide="next"><i class="fa fa-chevron-right"></i></a>

                            </div>
                            <!-- main slider carousel nav controls -->


                            <ul class="carousel-indicators list-inline">
                                <li class="list-inline-item active">
                                    <a id="carousel-selector-0" class="selected" data-slide-to="0"
                                       data-target="#productCarousel">
                                        <img src="{{URL::to($post->image)}}" class="">
                                    </a>
                                </li>
                                <?php if($images != ""){
                                $imgArr = unserialize($images);
                                foreach($imgArr as $img){
                                if($img != ''){
                                ?>

                                <li class="list-inline-item">
                                    <a id="carousel-selector-1" data-slide-to="1" data-target="#productCarousel">
                                        <img src="{{url::to(App\Http\Controllers\Frontend\FrontendController::getThumbnail($img))}}"
                                             class="">
                                    </a>
                                </li>
                                <?php }
                                }
                                }?>
                            </ul>
                        </div>


                        <div id="myresult" class="img-zoom-result"></div>
                    </div>

                    <div class="enqcartbutt">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="javascript:void(0)" class="enqbut btn" data-toggle="modal"
                                   data-target="#singleModal">
                                    <img src="{{ URL::to('frontend/images/enqform.png') }}" alt="">Enquiry
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0)" class="cartbutt btn" data-toggle="modal"
                                   data-target="#cartModal">
                                    <img src="{{ URL::to('frontend/images/cart.png') }}" alt=""> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="singleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="post" action="{{route('frontend.productEnquiry')}}">
                                {!! csrf_field() !!}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Enquiry For: {{$post->title}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-controll" name="user_id"
                                           value="@if ($logged_in_user){{$logged_in_user->id}}@endif">
                                    <input type="hidden" class="form-control" name="productname"
                                           value="{{$post->title}}">
                                    <input type="hidden" class="form-control" name="pid" value="{{$post->id}}">

                                    <div class="form-group">
                                        <label for="fullname" class="col-form-label">Full Name:</label>
                                        <input type="text" class="form-control" name="fullname"
                                               value="@if ($logged_in_user){{$logged_in_user->name}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailid" class="col-form-label">Email Address *:</label>
                                        <input type="email" class="form-control" name="emailid"
                                               value="@if ($logged_in_user){{ $logged_in_user->email }}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-form-label">Phone Number:</label>
                                        <input type="text" class="form-control" name="phone" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-form-label">Message:</label>
                                        <textarea class="form-control" name="message"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Send Enquiry">
                                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-example-modal-lg" id="cartModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Oops....</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                This Feature is currently unavailable. You can make an enquiry.

                            </div>
                            <div class="modal-footer">
                                {{--<input type="submit" name="submit" class="btn btn-primary" value="Send Enquiry">--}}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-7 proddetail">
                <div class="shortdesc">
                    <h2 class="title">{!! $post->title !!}</h2>
                    {!! $post->excerpt !!}
                    <div class="prodprice productoptions">
                        Price : <span>{!! $currency .' '.$price !!}</span>
                    </div>

                    <?php
                    if(!empty($options))
                    {
                    foreach($options as $opt){

                    $optname = $opt['name'];
                    $opts = $opt['options'];
                    ?>
                    <div class="productoptions prod<?php echo $optname?>">
                        <?php echo $optname?> :
                        <ul>
                            <?php
                            foreach ($opts as $ot) {
                                echo '<li>' . $ot . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <?php }
                    }
                    ?>

                </div>


                <div class="productcontent">
                    <h4 class="subtitle">Full Description</h4>
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="container">

                <!-- main slider carousel -->
                <div class="row">
                    <div class="col-lg-8 offset-lg-2" id="slider">

                    </div>

                </div>
                <!--/main slider carousel-->
            </div>


        </div>
    </div>

    <div class="relatedprducts">

        <div class="row mar-bot-30 featured">
            <div class="block-ttl auto-search col-sm-12">
                <h2><span>Similar products</span>
                    <hr>
                </h2>
            </div>
            @foreach($relatedprods as $product)
                <?php
                if (!empty($product->image))
                    $prodImage = $product->image;
                else
                    $prodImage = 'frontend/images/image-not-found.png';
                ?>
                <div class="col-sm-3">
                    <div class="wrap ">
                        <div class="f-top">
                            <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                                <div class="ima" style="background-image:url('{{ URL::to($prodImage) }}')"></div>
                            </a>

                            <div class="switch">
                                <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                                    <div class="overlay"></div>
                                </a>

                                <div class="button-group">

                                    <a href="javascript:void(0)" class="addtocart" data-toggle="modal"
                                       data-target="#exampleModal_{{$product->id}}">
                                        Enquiry
                                    </a>
                                    <a class="wishlist" href="javascript:void(0)" title="Price">
                                        <i class="fa fa-tag"></i>
                                        {{ App\Http\Controllers\Frontend\FrontendController::getProductPrice($product->id) }}

                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="f-right">
                            <h3>
                                <a href="{{ URL::to('product/'.$product->clean_url) }}" title="{{ $product->title }}">
                                    {{$product->title}}
                                </a>
                            </h3>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModal_{{$product->id}}" tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form method="post" action="{{route('frontend.productEnquiry')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enquiry
                                                For: {{$product->title}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" class="form-controll" name="user_id"
                                                   value="@if ($logged_in_user){{$logged_in_user->id}}@endif">
                                            <input type="hidden" class="form-control" name="productname"
                                                   value="{{$product->title}}">
                                            <input type="hidden" class="form-control" name="pid"
                                                   value="{{$product->title}}">
                                            {{--<div class="form-group">
                                                <label for="productname" class="col-form-label">Enquiry For:</label>
                                                <input type="text" class="form-control" name="productname" value="{{$product->title}}" disabled>
                                            </div>--}}
                                            <div class="form-group">
                                                <label for="fullname" class="col-form-label">Full Name:</label>
                                                <input type="text" class="form-control" name="fullname"
                                                       value="@if ($logged_in_user){{$logged_in_user->name}}@endif">
                                            </div>
                                            <div class="form-group">
                                                <label for="emailid" class="col-form-label">Email Address *:</label>
                                                <input type="email" class="form-control" name="emailid"
                                                       value="@if ($logged_in_user){{ $logged_in_user->email }}@endif"
                                                       required>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone Number:</label>
                                                <input type="text" class="form-control" name="phone" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">Message:</label>
                                                <textarea class="form-control" name="message"></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="submit" class="btn btn-primary"
                                                   value="Send Enquiry">
                                            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="clear"></div>
                    </div>
                </div>
            @endforeach


        </div>

    </div>

@endsection
@section('after-scripts')
    <script>
        function imageZoom(imgID, resultID) {
            var img, lens, result, cx, cy;
            img = document.getElementById(imgID);
            result = document.getElementById(resultID);
            /*create lens:*/
            lens = document.createElement("DIV");
            lens.setAttribute("class", "img-zoom-lens");
            /*insert lens:*/
            img.parentElement.insertBefore(lens, img);
            /*calculate the ratio between result DIV and lens:*/
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;
            /*set background properties for the result DIV:*/
            result.style.backgroundImage = "url('" + img.src + "')";
            result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
            /*execute a function when someone moves the cursor over the image, or the lens:*/
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mousemove", moveLens);
            /*and also for touch screens:*/
            lens.addEventListener("touchmove", moveLens);
            img.addEventListener("touchmove", moveLens);
            function moveLens(e) {
                var pos, x, y;
                /*prevent any other actions that may occur when moving over the image:*/
                e.preventDefault();
                /*get the cursor's x and y positions:*/
                pos = getCursorPos(e);
                /*calculate the position of the lens:*/
                x = pos.x - (lens.offsetWidth / 2);
                y = pos.y - (lens.offsetHeight / 2);
                /*prevent the lens from being positioned outside the image:*/
                if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
                if (x < 0) {x = 0;}
                if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
                if (y < 0) {y = 0;}
                /*set the position of the lens:*/
                lens.style.left = x + "px";
                lens.style.top = y + "px";
                /*display what the lens "sees":*/
                result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
            }
            function getCursorPos(e) {
                var a, x = 0, y = 0;
                e = e || window.event;
                /*get the x and y positions of the image:*/
                a = img.getBoundingClientRect();
                /*calculate the cursor's x and y coordinates, relative to the image:*/
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /*consider any page scrolling:*/
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {x : x, y : y};
            }
        }
    </script>
    <script>
        // Initiate zoom effect:
        imageZoom("myimage", "myresult");
    </script>
@endsection