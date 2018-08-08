<?php
$keywords="";$metadesc="";$images="";$price="";$currency="";
if(!empty($postmeta)){
    foreach($postmeta as $pm){
        if($pm->meta_key=='keywords')
            $keywords = $pm->meta_value;
        if($pm->meta_key=='metadesc')
            $metadesc = $pm->meta_value;
        if($pm->meta_key=='images')
            $images = $pm->meta_value;
        if($pm->meta_key=='price')
            $price = $pm->meta_value;
        if($pm->meta_key=='currency')
            $currency = $pm->meta_value;
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
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div class="col-sm-12">
        <div class="sharebuttons row">
            <div class="col-sm-9">
                <h2>{{$post->title}}

                </h2>
            </div>
            <div class="col-sm-3">
                <div class="fb-share-button" data-href="{{ URL::to($post->clean_url) }}" data-layout="button" data-size="large" data-mobile-iframe="true">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ URL::to($post->clean_url) }}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                </div>
                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-show-count="false">Tweet</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
        </div>

        <div class="row mar-bot-40">

            {{--@if(!empty($post->image))
                <div class="productimage">
                    <img src="{{URL::to($post->image)}}" alt="{{$post->title}}">
                </div>
            @endif--}}

            <div class="col-md-6 col-sm-12">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{URL::to($post->image)}}" alt="First slide">
                        </div>
                        <?php if($images!=""){
                            $imgArr = unserialize($images);
                            foreach($imgArr as $img){
                            ?>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{url::to($img)}}" alt="Second slide">
                            </div>
                            <?php }
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
            <div class="col-md-6 col-sm-12">
                <div class="shortdesc">
                    {!! $post->excerpt !!}}
                </div>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="javascript:void(0)" class="addtocart btn btn-success" data-toggle="modal" data-target="#exampleModal_{{$post->id}}">
                                Enquiry
                            </a>
                        </div>
                        <div class="col-md-4">
                            <div class="price">
                                {{$currency .' '. $price}}
                            </div>
                        </div>
                    </div>


            </div>

            <div class="col-md-12 col-sm-12 productcontent">
                    {!! $post->content !!}
            </div>

        </div>

    </div>
@endsection
