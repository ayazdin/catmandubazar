<?php
$keywords="";$metadesc="";
if(!empty($postmeta)){
    foreach($postmeta as $pm){
        if($pm->meta_key=='keywords')
            $keywords = $pm->meta_value;
        if($pm->meta_key=='metadesc')
            $metadesc = $pm->meta_value;
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
    <div class="col-sm-9">
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


            @if(!empty($post->image))
                <div class="productimage">
                    <img src="{{URL::to($post->image)}}" alt="{{$post->title}}">
                </div>
            @endif


            <div class="productcontent">
                {!! $post->content !!}
            </div>
        </div>

    </div>
@endsection
