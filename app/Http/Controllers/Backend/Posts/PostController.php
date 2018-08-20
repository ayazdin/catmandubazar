<?php

namespace App\Http\Controllers\Backend\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Brands;
use App\Http\Controllers\Backend\Posts\PostCatController;
use App\Models\Enquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Product Category Start
        public function createProductCategory($id=''){
            $catCtrl = new PostCatController();
            $postcat = $catCtrl->getCategoryList();
            $subcategories = Postcat::where('type', '=', 'category')
                ->where('parent', '!=', '0')
                ->get();

            //print_r($postcat);
            if($id!="")
            {
                $editcat = Postcat::where('id', $id)->first();
                return view('backend.posts.add-category')->with('postcat', $postcat)
                    ->with('editcat', $editcat)
                    ->with('subcategories', $subcategories)
                    ->with('categoryType', 'category');
            }
            return view('backend.posts.add-category')->with('postcat', $postcat)
                ->with('subcategories', $subcategories)
                ->with('categoryType', 'category');;
        }

    public function storeCategory(Request $request)
    {

        try {
            //$cmn = new CommonController();
            if($request['catid']!="")
                $postcat = Postcat::where('id', $request['catid'])->first();
            else
                $postcat = new Postcat();

            $postcat->name = $request['catName'];

            $slug = $request['slug'];
            if(!empty($request['categoryType']))
                $postcat->type = $request['categoryType'];
            else
                $postcat->type = 'category';
            $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
            $postcat->parent = $request['subCat'];
            $postcat->image = $request['filepath'];
            //echo $postcat->slug;exit;

            //dd($postcat);
            if($request['catid']!="")
            {
                $postcat->update();
                return back()->withFlashSuccess( 'One item updated successfully!!!');
            }
            else
            {
                $postcat->save();
                return redirect('/admin/product/category/add')->withFlashSuccess('One item added successfully!!!');
            }

        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
            return redirect('/admin/product/category/add')->withFlashSuccess( 'Due to some technical issues the request cannot be done!!!');
        }


    }

    public function destroyCategory($id){
        try {
            $cat = Postcat::where('id', '=', $id)->first();
            if($cat->type=='product')
            {
                //$delProdRelation = Psc_relation::where('catid', $id)->delete();//Psc_relation::destroy()
                $delCatRelation = Cat_relation::where('catid', $id)->delete();
            }
            elseif($cat->type=='category' and $cat->parent==0)
                $delCatRelation = Cat_relation::where('catid', $id)->delete();
            Postcat::destroy($id);
        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
        return back()->withFlashSuccess('One item deleted');
    }

    //Product Category End

    //Product Starts
        public function indexProduct(){
            $products = Posts::where('ctype', '=', 'product')
                ->get();
            return view('backend.posts.products')->with('products', $products);
        }

        public function createProduct(){
            $catCtrl = new PostCatController();

            $ddlCat = $catCtrl->getCategoryList();

            $proType = Postcat::where('type','=', 'product')->orderBy('catorder', 'ASC')->get();
            $typeLi = $catCtrl->getCategoryLi($proType);
            $sliderCat = $this->getPostsByType("home", false);
            $sliders = $this->getPostsInSlider($sliderCat);

            return view('backend.posts.add-product')->with('ddlCat', $ddlCat)
                        /*->with('proType', $typeLi)
                        ->with('sliders', $sliders)*/;
        }
        public function store(Request $request)
    {
        //print_r($request['menuorder']);exit;
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
            if($request['featuredimage']!="")
                $posts->image = $request['featuredimage'];
            else
                $posts->image = "";
            if(isset($request['menuorder']))
                $posts->menu_order = $request['menuorder'];

            $posts->userid = $user->id;

            if($request['postid']!="")
                $posts->update();
            else
                $posts->save();

            //print_r($request['category']);exit;
            if($request['optionNumber']!="")
                $optNameList = explode(",", $request['optionNumber']);
            if($request['optName']!="")
                $optionNames = $request['optName'];
            $options="";
            $icount = 0;

            if(!empty($optionNames))
            {
                $options = array();
                foreach($optNameList as $onl)
                {
                    if($optionNames[$icount]!="")
                    {
                        $options = array('name' => $optionNames[$icount],
                            'options' => $request['optValue'.$onl]);
                        $icount++;
                    }
                }
            }
            //print_r($optionNames);exit;
            $priceSelCount = $request['priceSelCount'];
            $rPrice = $request['selPrice'];
            //print_r($rPrice);exit;
            $combiArr = [];
            for($iCo=0;$iCo<$priceSelCount;$iCo++)
            {
                $temp = [];
                foreach($optionNames as $opn)
                {
                    $field = preg_replace('/[^A-Z0-9]+/i', '_', strtolower($opn));
                    $rVal = $request[$field."_sel"];
                    //print_r($rVal);
                    //if(!empty($rVal[$iCo]))
                    array_push($temp, $rVal[$iCo]);
                }

                array_push($temp, $rPrice[$iCo]);
                array_push($combiArr, $temp);
            }
            //print_r($combiArr);exit;
            $this->addAttributes('priceOption', serialize($combiArr), $posts->id);
            //print_r($request['category']);exit;
            if(!empty($request['category']))
                $this->addCategoryRelation($request['category'], $posts->id);

            /*$this->removeSliderItems($posts->id);
            //exit;
            if($request['sliders']!="")
            {
                $this->addSliderItems($request['sliders'], $posts->id);
            }*/


            if($options!="")
                $this->addAttributes('options', serialize($options), $posts->id);
            $this->addAttributes('isFeatured', $request['isfeatured'], $posts->id);
            $this->addAttributes('hashtags', $request['prodTags'], $posts->id);
            $this->addAttributes('price', $request['prodPrice'], $posts->id);
            $this->addAttributes('keywords', $request['keywords'], $posts->id);
            $this->addAttributes('metadesc', $request['metadesc'], $posts->id);
            $this->addAttributes('currency', $request['currency'], $posts->id);
            $this->addAttributes('price', $request['prodPrice'], $posts->id);
            $this->addAttributes('purchase', $request['prodPurchase'], $posts->id);
            $this->addAttributes('quantity', $request['prodqty'], $posts->id);
            $this->addAttributes('stock', $request['stock'], $posts->id);
            $this->addAttributes('purchase', $request['prodPurchase'], $posts->id);
            //$this->addAttributes('currency', $request['currency'], $posts->id);

            $this->addAttributes('showQty', $request['showQty'], $posts->id);
            $this->addAttributes('showPrice', $request['showPrice'], $posts->id);
            $this->addAttributes('showPrice', $request['showPrice'], $posts->id);
            $this->addAttributes('showStock', $request['showStock'], $posts->id);
            $this->addAttributes('showDesc', $request['showDesc'], $posts->id);
            //echo $request['hasbuyurl'];exit;
            if($request['hasbuyurl'])
                $this->addAttributes('buyurl', $request['buyurl'], $posts->id);
            else
                $this->addAttributes('buyurl', '', $posts->id);

            if($request['imagespath']!="")
                $this->addAttributes('images', serialize($request['imagespath']), $posts->id);
        }
        catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
            $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
        }
        if($request['postid']!="")
            return back()->withFlashSuccess( 'One item updated successfully!!!');
        else
            return back()->withFlashSuccess( 'One item added successfully!!!');
        /*return back();
        return redirect('/admin/product/add');*/
    }

        public function editProduct($id){
            $sel=array();
            $catCtrl = new PostCatController();
            //$postcat = Postcat::where('parent','=', '0')->orderBy('catorder', 'ASC')->get();
            $post = Posts::where('id', $id)->first();
            $postmeta = Postmeta::where('postid', $id)->get();
            $catrel = Cat_relation::where('postid','=', $id)->get();
            //$sliderCat = $this->getPostsByType("home", false);
            //$sliders = $this->getPostsInSlider($sliderCat);

            if($catrel->isNotEmpty())
            {
                foreach($catrel as $cr)
                {
                    $sel[]=$cr->catid;
                }
            }
            //print_r($sel);//exit;
            $ddlCat = $catCtrl->getCategoryList('', $sel);
            //print_r($ddlCat);exit;
            $proType = Postcat::where('type','=', 'product')->orderBy('catorder', 'ASC')->get();
            $typeLi = $catCtrl->getCategoryLi($proType);

            //echo $categories;exit;
            return view('backend.posts.add-product')->with('post', $post)
                ->with('postmeta', $postmeta)
                ->with('ddlCat', $ddlCat)
                /*->with('proType', $typeLi)
                ->with('sliders', $sliders)*/;
        }
        public function destroyProduct($id){
            Postmeta::where('postid', $id)->delete();
            Posts::where('id',$id)->delete();
            return redirect()->route('admin.product.indexProduct')->withFlashSuccess(__('Product deleted successfully'));
        }
    //product End

    //enquiry start
    public function enquiryList(){
        $enquiries = Enquiry::get();

        return view('backend.posts.enquiry-list')->with('enquiries',$enquiries);
    }
    //enquiry end


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

    public function getPostsByType($type="product", $paging=false, $page="25")
    {
        if($paging==true)
            $posts = Posts::where('ctype', '=', $type)
                ->where('status', '=', 'publish')->paginate($page);
        else
            $posts = Posts::where('ctype', '=', $type)
                ->where('status', '=', 'publish')->get();
        return $posts;
    }

    public function getPostsInSlider($sliders)
    {
        $items = "";
        foreach($sliders as $s)
        {
            $prods = $this->getMetaValue('home-slider', $s->id);
            if($prods!="")
            {
                if(strpos($prods, ",")>0)
                    $prodArr = explode(",", $prods);
                else
                    $prodArr = $prods;
                $items[] = array('ID' => $s->id, 'Title' => $s->title, 'prods' => $prodArr);
            }
            else {
                $items[] = array('ID' => $s->id, 'Title' => $s->title, 'prods' => '');
            }
        }
        return $items;
    }

    public function getSliders($page="")
    {
        $combine="";
        $sliders = "";$fullArr=array();$products="";
        $sPosts = $this->getPostsByType('home', true, $page);
        foreach($sPosts as $s)
        {
            $prods = $this->getMetaValue('home-slider', $s->id);
            if($prods!="")
            {
                $pArr = explode(",", $prods);
                $fullArr = array_merge($pArr, $fullArr);
                //print_r($pArr);echo "<br>";
                $sliders[] = array('id' => $s->id, 'title' => $s->title, 'excerpt' => $s->excerpt, 'clean_url' => $s->clean_url, 'prods' => $pArr );
            }
        }
        //print_r($fullArr);echo "<br>";
        $prodArr = array_unique($fullArr);
        //print_r($prodArr);exit;
        foreach($prodArr as $p)
        {
            $proditem = Posts::where('id', '=', $p)->first();
            //echo count($proditem);
            if(count($proditem)==0)
                continue;
            $price = $this->getMetaValue('price', $p);
            $showprice = $this->getMetaValue('showPrice', $p);
            $currency = $this->getMetaValue('currency', $p);
            $purchase = $this->getMetaValue('purchase', $p);
            //echo $proditem->image;
            $thumbImage = $this->getThumbnail($proditem->image);
            $products[$p] = array('prodid' => $proditem->id, 'prodtitle' => str_limit($proditem->title, 80),
                'produrl' => $proditem->clean_url, 'prodimage' => $thumbImage,
                'prodprice' => $price, 'currency' => $currency,
                'showprice' => $showprice, 'purchase' => $purchase);
        }
        $combine = array('sliders' => $sliders, 'products' => $products);
        return $combine;
    }

    public function addCategoryRelation($categories, $postid)
    {
        //print_r($categories);exit;
        if(!empty($categories))
        {
            $cr = new Cat_relation();
            $cr->where('postid', $postid)->delete();

            foreach($categories as $c)
            {
                $crs = new Cat_relation();
                $crs->postid = $postid;
                $crs->catid = $c;
                $crs->save();
            }
        }
    }
}
