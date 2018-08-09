<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;

class FrontendController extends Controller
{
    //
    public  function getHomePage(){

        $products = Posts::where('ctype', '=', 'product')
                            ->where('status', '=', 'publish')
                            ->orderBy('created_at', 'DESC')->get();
        return view('frontend.home')->with('products',$products);
    }

    public function produtDetail($slug){
        $post = Posts::where('clean_url', $slug)->first();
        $postId = $post->id;
        $postmeta = Postmeta::where('postid', $postId)->get();
        $category = Cat_relation::where('postid',$postId)->first();
        $catId = $category->catid;
        $relatedprods = DB::table('posts')
            ->join('cat_relations', 'cat_relations.postid', '=', 'posts.id')
            ->join('postcats', 'postcats.id', '=', 'cat_relations.catid')
            ->where('posts.id', '!=', $postId)
            ->where('postcats.id', '=', $catId)
            ->select('posts.*')
            ->limit(4)
            ->get();
        return view('frontend.singleproduct')->with('post',$post)
                                             ->with('postmeta',$postmeta)
                                             ->with('relatedprods',$relatedprods);
    }

    public function productEnquiry(Request $request){
        dd($request);
    }

    public static function getProductPrice($id){
        $prodprice = Postmeta::where('postid', $id)
                            ->where('meta_key', '=', 'price')
                            ->first();

        $prodcurrency = Postmeta::where('postid', $id)
                        ->where('meta_key', '=', 'currency')
                        ->first();

        $output = $prodcurrency->meta_value.' '.$prodprice->meta_value;

        echo $output;
    }
}
