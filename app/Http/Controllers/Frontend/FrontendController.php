<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;

class FrontendController extends Controller
{
    //
    public  function getHomePage(){

        $products = Posts::where('ctype', '=', 'product')
                            ->where('status', '=', 'publish')
                            ->orderBy('created_at', 'DESC')->limit(3)->get();
        return view('frontend.home')->with('products',$products);
    }

    public function produtDetail($slug){
        $post = Posts::where('clean_url', $slug)->first();
        $postId = $post->id;
        $postmeta = Postmeta::where('postid', $postId)->get();

        return view('frontend.singleproduct')->with('post',$post)
                                             ->with('postmeta',$postmeta);
    }

    public function productEnquiry(Request $request){
        dd($request);
    }
}
