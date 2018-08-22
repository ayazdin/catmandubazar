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
@extends('frontend.layouts.app')

@section('title',  config('app.name').' | '.$post->title)

@section('keywords',  $keywords)
@section('description',  $metadesc)
@section('url',   URL::to('product/'.$post->clean_url))
@section('image',  URL::to($post->image))



@section('content')

    <div class="productpage">
        <div class="row">
            <div class="col-md-5">
                <div class="prodimage">
                    <div class="prodimageslider">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{URL::to($post->image)}}" alt="First slide">
                                </div>
                                <?php if($images!=""){
                                $imgArr = unserialize($images);
                                foreach($imgArr as $img){
                                if($img!=''){
                                ?>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{url::to($img)}}" alt="Second slide">
                                </div>
                                <?php }
                                }
                                }?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>

                    <div class="enqcartbutt">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="javascript:void(0)" class="enqbut btn" data-toggle="modal" data-target="#singleModal">
                                    <img src="{{ URL::to('frontend/images/enqform.png') }}" alt="">Enquiry
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0)" class="cartbutt btn" data-toggle="modal" data-target="#cartModal">
                                    <img src="{{ URL::to('frontend/images/cart.png') }}" alt=""> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="singleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden" class="form-controll" name="user_id" value="@if ($logged_in_user){{$logged_in_user->id}}@endif">
                                    <input type="hidden" class="form-control" name="productname" value="{{$post->title}}">
                                    <input type="hidden" class="form-control" name="pid" value="{{$post->id}}">

                                    <div class="form-group">
                                        <label for="fullname" class="col-form-label">Full Name:</label>
                                        <input type="text" class="form-control" name="fullname" value="@if ($logged_in_user){{$logged_in_user->name}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label for="emailid" class="col-form-label">Email Address *:</label>
                                        <input type="email" class="form-control" name="emailid" value="@if ($logged_in_user){{ $logged_in_user->email }}@endif" required>
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

                <div class="modal fade bd-example-modal-lg" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            foreach($opts as $ot){
                                echo '<li>'.$ot.'</li>';
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

    <div class="relatedprducts">

        <div class="row mar-bot-30 featured">
            <div class="block-ttl auto-search col-sm-12">
                <h2><span>Similar products</span> <hr></h2>
            </div>
            @foreach($relatedprods as $product)
                <?php
                if(!empty($product->image))
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

                                    <a href="javascript:void(0)" class="addtocart" data-toggle="modal" data-target="#exampleModal_{{$product->id}}">
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
                        <div class="modal fade bd-example-modal-lg" id="exampleModal_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form method="post" action="{{route('frontend.productEnquiry')}}">
                                        {!! csrf_field() !!}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enquiry For: {{$product->title}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" class="form-controll" name="user_id" value="@if ($logged_in_user){{$logged_in_user->id}}@endif">
                                            <input type="hidden" class="form-control" name="productname" value="{{$product->title}}">
                                            <input type="hidden" class="form-control" name="pid" value="{{$product->title}}">
                                            {{--<div class="form-group">
                                                <label for="productname" class="col-form-label">Enquiry For:</label>
                                                <input type="text" class="form-control" name="productname" value="{{$product->title}}" disabled>
                                            </div>--}}
                                            <div class="form-group">
                                                <label for="fullname" class="col-form-label">Full Name:</label>
                                                <input type="text" class="form-control" name="fullname" value="@if ($logged_in_user){{$logged_in_user->name}}@endif">
                                            </div>
                                            <div class="form-group">
                                                <label for="emailid" class="col-form-label">Email Address *:</label>
                                                <input type="email" class="form-control" name="emailid" value="@if ($logged_in_user){{ $logged_in_user->email }}@endif" required>
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


                        <div class="clear"></div>
                    </div>
                </div>
            @endforeach



        </div>

    </div>

@endsection
