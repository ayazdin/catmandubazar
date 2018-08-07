<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Autobrands;
use DB;

class PriceSearchController extends Controller
{
    /*
     * Product's brand section starts here
     */

    public function brandIndex($id=""){
        $brands = Autobrands::all();
        if($id!="")
        {
            $editcat = Autobrands::where('id', $id)->first();
            return view('admin.price.brandindex')->with('brands', $brands)
                ->with('editcat', $editcat);

        }

        return view('admin.price.brandindex')->with('brands', $brands);

    }

    public function brandstore(Request $request){
        try {
            if($request['catid']!="")
                $postcat = Autobrands::where('id', $request['catid'])->first();
            else
                $postcat = new Autobrands();

            $postcat->title = $request['brandName'];
            $postcat->content = $request['description'];
            if(empty($request['slug']))
                $slug = $this->generateSeoURL($request['brandName']);
            else
                $slug = $request['slug'];

            $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
            $postcat->logo = $request['filepath'];
            $postcat->status = $request['status'];
            //echo $postcat->slug;exit;

            //print_r($postcat); die();
            if($request['catid']!="")
            {
                $postcat->update();
                $request->session()->flash('succ', 'One item updated successfully!!!');
            }
            else
            {
                $postcat->save();
                $request->session()->flash('succ', 'One item added successfully!!!');
            }

        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
            $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
        }
        return redirect('/admin/price/brand');
    }

    public function branddestroy($id){
        try {
            Autobrands::destroy($id);
        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
        return redirect('/admin/price/brand')->with('succ', 'One item deleted');
    }
    /*
     * Product's brand section ends here
     */

    /*
     * Product section starts here
     */

    public function productIndex(){
        $posts = Posts::where('ctype', '=', 'price')
                        ->orderBy('updated_at', 'DESC')->paginate(25);
        return view('admin.price.productIndex')->with('posts', $posts);
    }

    public function productadd($id=''){
        if($id!="")
        {
            $post = Posts::where('id', $id)->first();
            $brands = Autobrands::where('status','Publish')->get();
            $categories = Postcat::where('type','price')->get();
            return view('admin.price.add-product')->with('categories', $categories)
                                                    ->with('brands', $brands)
                                                    ->with('post', $post);

        }
        $brands = Autobrands::where('status','Publish')->get();
        $categories = Postcat::where('type','price')->get();
        return view('admin.price.add-product')->with('categories', $categories)
                                              ->with('brands', $brands);
    }


    public function storeProduct(Request $request){
        try{
            if(Auth::check())
                $user = Auth::user();
            if($request['postid']!="")
                $posts = Posts::where('id', $request['postid'])->first();
            else
                $posts = new Posts();

            $posts->title = $request['prodTitle'];
            if(empty($request['prodSlug']))
                $posts->clean_url = $this->generateSeoURL($request['prodTitle']);
            else
                $posts->clean_url = $request['prodSlug'];

            if($request['description']!="")
                $posts->content = $request['description'];
            if($request['excerpt']!="")
                $posts->excerpt = $request['excerpt'];

            $posts->status = $request['rdoPublish'];
            $posts->ctype = $request['ctype'];
            $posts->userid = $user->id;
            if($request['featuredimage']!="")
                $posts->image = $request['featuredimage'];

            if($request['postid']!="")
                $posts->update();
            else
                $posts->save();

            $this->addAttributes('keywords', $request['keywords'], $posts->id);
            $this->addAttributes('metadesc', $request['metadesc'], $posts->id);
            $this->addAttributes('brand', $request['brand'], $posts->id);
            $this->addAttributes('category', $request['category'], $posts->id);

        }
        catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
            $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
        }
        if($request['postid']!="")
            $request->session()->flash('succ', 'One item updated successfully!!!');
        else
            $request->session()->flash('succ', 'One item added successfully!!!');
        return back();
    }


    public function deleteProduct($id){
        //dd($id);
        Postmeta::where('postid', $id)->delete();
        Posts::destroy($id);
        return redirect('/admin/price/product-list')->with('succ', 'One item deleted');
    }

    /*
     * Product section ends here
     */

    /*
     * Product's category section starts here
     */

    public function indexCategory($id='')
    {
        $postcat="";
        $sel="";
        $li="";
        $catCtrl = new PostCatController();
        $postcat = $catCtrl->getCategoryList($li, $sel, 'price');

        if($id!="")
        {
            $editcat = Postcat::where('id', $id)->first();
            return view('admin.price.price-category')->with('postcat', $postcat)
                ->with('editcat', $editcat)
                ->with('categoryType', 'price');
        }
        //return "we are here";
        return view('admin.price.price-category')->with('postcat', $postcat)
            ->with('categoryType', 'price');
    }

    public function storeCategory(Request $request){
        try {
            if($request['catid']!="")
                $postcat = Postcat::where('id', $request['catid'])->first();
            else
                $postcat = new Postcat();

            $postcat->name = $request['catName'];
            if(empty($request['slug']))
                $slug = $this->generateSeoURL($request['catName']);
            else
                $slug = $request['slug'];
            if(!empty($request['categoryType']))
                $postcat->type = $request['categoryType'];
            else
                $postcat->type = 'price';
            $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
            $postcat->parent = $request['subCat'];
            $postcat->image = $request['filepath'];
            //echo $postcat->slug;exit;

            //print_r($postcat); die();
            if($request['catid']!="")
            {
                $postcat->update();
                $request->session()->flash('succ', 'One item updated successfully!!!');
            }
            else
            {
                $postcat->save();
                $request->session()->flash('succ', 'One item added successfully!!!');
            }

        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
            $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
        }
        return redirect('/admin/price/category');
    }

    public function catdestroy($id)
    {
        //dd($id);
        try {
            Postcat::destroy($id);
        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
        return redirect('/admin/price/category')->with('succ', 'One item deleted');

    }


    /*
     * Product's category section ends here
     */


    public function generateSeoURL($string, $wordLimit = 0)
    {
        $separator = '-';

        if($wordLimit != 0){
            $wordArr = explode(' ', $string);
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
        }

        $quoteSeparator = preg_quote($separator, '#');

        $trans = array(
            '&.+?;'                    => '',
            '[^\w\d _-]'            => '',
            '\s+'                    => $separator,
            '('.$quoteSeparator.')+'=> $separator
        );

        $string = strip_tags($string);
        foreach ($trans as $key => $val){
            //$string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
            $string = preg_replace('#'.$key.'#i', $val, $string);
        }

        $string = strtolower($string);

        return trim(trim($string, $separator));
    }

    public function getUniqueSlug($s, $catid="")
    {
        if($catid!="")
            $postcat = Postcat::where('slug', $s)
                ->where('id', '<>', $catid)
                ->first();
        else
            $postcat = Postcat::where('slug', $s)->first();
        if(!empty($postcat))
            return $postcat->slug."-".date('md');
        else
            return $s;
    }

    public function addAttributes($metaKey, $metaValue, $postid)
    {
        if($metaValue=="")
            $metaValue="";
        //{
        $hasAtt = Postmeta::where('postid', $postid)
            ->where('meta_key', '=', $metaKey)->first();
        if(!empty($hasAtt))
            $postMeta = Postmeta::where('postid', $postid)
                ->where('meta_key', '=', $metaKey)->first();
        else
            $postMeta = new Postmeta();
        $postMeta->postid = $postid;
        $postMeta->meta_key = $metaKey;
        $postMeta->meta_value = $metaValue;
        if(!empty($hasAtt))
            $postMeta->update();
        else
            $postMeta->save();

        //}
    }

}
