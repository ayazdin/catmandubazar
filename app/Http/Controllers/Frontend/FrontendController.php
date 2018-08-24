<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;

use Mail;
/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Posts::where('ctype', '=', 'product')
            ->where('status', '=', 'publish')
            ->orderBy('created_at', 'DESC')->get();

        return view('frontend.index')->with('products',$products);
    }

    /**
     * @return \Illuminate\View\View
     */
    /*public function macros()
    {
        return view('frontend.macros');
    }*/



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
        $enq = new Enquiry();
        if($request['user_id']=='')
            $enq->userid =0;
        else
            $enq->userid = $request['user_id'];

        $enq->pid = $request['pid'];
        $enq->productname = $request['productname'];
        $enq->name = $request['fullname'];
        $enq->email = $request['emailid'];
        $enq->phone = $request['phone'];
        $enq->message = $request['message'];

        $enq->save();

        $data = array(
            'productname'   => $request['productname'],
            'name'   => $request['fullname'],
            'email'   => $request['emailid'],
            'phone'   => $request['phone'],
            'bodyMessage'   => $request['message'],
        );


        Mail::send('frontend.mail.enquiry', $data ,function($enqMessage) use($enq){
            $enqMessage->from($enq['email']);
            $enqMessage->to('binaya619@gmail.com');
            $enqMessage->subject('New enquiry mail received');
        });



        return redirect()->back()->with('enquirysuccess', 'Enquiry Send Successfully. We will contact you soon. Thank you for your Enquiry.');
        //dd($enq);

    }

    public function enquiryList(){
        $user = Auth::user();
        $user->id;

        $enquiries = Enquiry::where('userid',$user->id)->get();

        return view('frontend.enquiry')->with('enquiries',$enquiries);

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

    public static function getThumbnail($image){
        return substr_replace($image, '/thumbs', strrpos($image, "/"), 0);
        
    }

}
