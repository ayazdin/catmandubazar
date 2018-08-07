<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Brands;
use App\Models\Psc_relation;
use DB;
use App\Http\Controllers\Posts\PostCatController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProduct()
    {
      $products = Posts::where('ctype', '=', 'product')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
      // $products = DB::table('posts')->join('postmetas', 'posts.id', '=', 'postmetas.postid')
      //                               ->select('posts.*', 'postmetas.meta_key', 'postmetas.meta_value')
      //                               ->orderBy('posts.updated_at','DESC')
      //                               ->groupBy('posts.id')
      //                               ->paginate(25);
      //$category = getMetaValue
      //print_r($products);
      return view('admin.posts.products')->with('products', $products);
    }

    /**
     * Show the form for creating a new Products.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct()
    {
        $catCtrl = new PostCatController();
        //echo "here we are";exit;
        $ddlCat = $catCtrl->getCategoryList();
        //print_r($ddlCat);exit;
        $proType = Postcat::where('type','=', 'product')->orderBy('catorder', 'ASC')->get();
        $typeLi = $catCtrl->getCategoryLi($proType);
        $sliderCat = $this->getPostsByType("home", false);
        $sliders = $this->getPostsInSlider($sliderCat);

        return view('admin.posts.add-product')->with('ddlCat', $ddlCat)
                                                    ->with('proType', $typeLi)
                                                    ->with('sliders', $sliders);
    }

    /**
     * Show the form for edit Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id)
    {
        //$sel="";
        $catCtrl = new PostCatController();
        //$postcat = Postcat::where('parent','=', '0')->orderBy('catorder', 'ASC')->get();
        $post = Posts::where('id', $id)->first();
        $postmeta = Postmeta::where('postid', $id)->get();
        $catrel = Cat_relation::where('postid','=', $id)->get();
        $sliderCat = $this->getPostsByType("home", false);
        $sliders = $this->getPostsInSlider($sliderCat);

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
        return view('admin.posts.add-product')->with('post', $post)
                                                    ->with('postmeta', $postmeta)
                                                    ->with('ddlCat', $ddlCat)
                                                    ->with('proType', $typeLi)
                                                    ->with('sliders', $sliders);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProductCategory($id='')
    {
        $catCtrl = new PostCatController();
        $postcat = $catCtrl->getCategoryList();
        $subcategories = Postcat::where('type', '=', 'category')
                                    ->where('parent', '!=', '0')
                                    ->get();

        //print_r($postcat);
        if($id!="")
        {
          $editcat = Postcat::where('id', $id)->first();
          return view('admin.posts.add-category')->with('postcat', $postcat)
                                                      ->with('editcat', $editcat)
                                                      ->with('subcategories', $subcategories)
                                                      ->with('categoryType', 'category');
        }
        return view('admin.posts.add-category')->with('postcat', $postcat)
                                                    ->with('subcategories', $subcategories)
                                                    ->with('categoryType', 'category');
    }

    /**
     * Show the form for creating a new Category for home page sliders.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHomeCategory($id='')
    {
        $hSlider = Posts::where('ctype', '=', 'home')
                            ->orderBy('menu_order', 'ASC')
                            ->paginate(25);

        if($id!="")
        {
          $editSlider = Posts::where('id', $id)->first();
          //print_r($editSlider);exit;
          return view('admin.posts.add-home-slider')->with('slider', $hSlider)
                                                      ->with('editslider', $editSlider)
                                                      ->with('cType', 'home');
        }
        return view('admin.posts.add-home-slider')->with('slider', $hSlider)
                                                    ->with('cType', 'home');
    }

    /**
     * Show the form for creating a new Product type.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProductType($id='')
    {
        $postcat = Postcat::where('type', '=', 'product')
                            ->orderBy('catorder', 'ASC')->paginate(15);
        $subcategories = Postcat::where('type', '=', 'category')
                                    ->where('parent', '!=', '0')
                                    ->get();
        //print_r($subcategories);
        if($id!="")
        {
          $editcat = Postcat::where('id', $id)->first();
          return view('admin.posts.add-product-type')->with('postcat', $postcat)
                                                      ->with('editcat', $editcat)
                                                      ->with('subcategories', $subcategories)
                                                      ->with('categoryType', 'product');
        }
        return view('admin.posts.add-product-type')->with('postcat', $postcat)
                                                        ->with('subcategories', $subcategories)
                                                    ->with('categoryType', 'product');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                  $options[] = array('name' => $optionNames[$icount],
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

            $this->removeSliderItems($posts->id);
            //exit;
            if($request['sliders']!="")
            {
              $this->addSliderItems($request['sliders'], $posts->id);
            }


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
          $request->session()->flash('succ', 'One item updated successfully!!!');
        else
          $request->session()->flash('succ', 'One item added successfully!!!');
        return back();
        return redirect('/admin/product/add');
    }

    public function removeSliderItems($pid)
    {
      $hs = Posts::where('ctype', '=', 'home')->get();
      foreach($hs as $h)
      {
        $hmSlider =Postmeta::where('postid', '=', $h->id)
                              ->where('meta_key', '=', 'home-slider')->first();
        $pString = $hmSlider->meta_value;
        $pArr = explode(",", $hmSlider->meta_value);
        //print_r($pArr);echo "<br><br>";
        $index = array_search($pid, $pArr);

        if($index!==false)
          unset($pArr[$index]);
        $pStr = implode(",",$pArr);

        $hmSlider->meta_value=$pStr;
        $hmSlider->update();
      }
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request)
    {

      try {
        //$cmn = new CommonController();
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
          $postcat->type = 'category';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        $postcat->parent = $request['subCat'];
        $postcat->image = $request['filepath'];
        //echo $postcat->slug;exit;
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
      return redirect('/admin/product/category/add');

    }

    public function getProductOrderList()
    {
      $orders="";
      $orders = DB::table('carts')
                      ->select('*', DB::raw('count(*) as items'), DB::raw('sum(price*quantity) as total'))
                      ->where('orderid', '>', 0)
                      ->groupBy('orderid')
                      ->paginate(25);
      //print_r($orders);exit;
      return view('admin.posts.product-orders')->with('orders', $orders);
    }

    public function getProductOrderView($orderid)
    {
      $orders="";
      $orders = DB::table('carts')
                ->join('posts', 'carts.prodid', '=', 'posts.id')
                ->where('carts.orderid', '=', $orderid)
                ->select('carts.*', 'posts.title', 'posts.clean_url', 'posts.image')
                ->get();

      $usr = new UserController();
      $customer = $usr->getUserInfo($orders[0]->userid);
      //print_r($orders);exit;
      return view('admin.posts.product-order-view')->with('orders', $orders)
                                                        ->with('customer', $customer);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProductType(Request $request)
    {
      try {
        if($request['catid']!="")
          $postcat = Postcat::where('id', $request['catid'])->first();
        else
          $postcat = new Postcat();

        //print_r($request['subcategory']);exit;

        $postcat->name = $request['catName'];
        if(empty($request['slug']))
          $slug = $this->generateSeoURL($request['catName']);
        else
          $slug = $request['slug'];
        if(!empty($request['categoryType']))
          $postcat->type = $request['categoryType'];
        else
          $postcat->type = 'category';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        $postcat->parent = "0";
        $postcat->image = $request['filepath'];
        //echo $postcat->slug;exit;
        if($request['catid']!="")
        {
            $postcat->update();
            if(!empty($request['subcategory']))
              $this->setProductRelation($request['subcategory'], $request['catid']);
    				$request->session()->flash('succ', 'One item updated successfully!!!');
    		}
    		else
    		{
    				$postcat->save();
            if(!empty($request['subcategory']))
              $this->setProductRelation($request['subcategory'], $postcat->id);
    				$request->session()->flash('succ', 'One item added successfully!!!');
    		}

      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      return redirect('/admin/product/category/add');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHomeCategory(Request $request)
    {
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
          if(isset($request['menuorder']))
            $posts->menu_order = $request['menuorder'];

          $posts->userid = $user->id;

          if($request['postid']!="")
            $posts->update();
          else
            $posts->save();
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

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProductType(Request $request)
    {
      try {
        if($request['pcatid']!="")
          $postcat = Postcat::where('id', $request['pcatid'])->first();
        else
          $postcat = new Postcat();

        //print_r($request['subcategory']);exit;

        $postcat->name = $request['pcatName'];
        if(empty($request['pslug']))
          $slug = $this->generateSeoURL($request['pcatName']);
        else
          $slug = $request['pslug'];
        $postcat->type = $request['pcategoryType'];
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        $postcat->parent = "0";
        $postcat->image = $request['filepath'];
        //echo $postcat->slug;exit;
        if($request['pcatid']!="")
        {
            $postcat->update();
            if(!empty($request['subcategory']))
              $this->setProductRelation($request['subcategory'], $request['pcatid']);
    				$request->session()->flash('succ', 'One item updated successfully!!!');
    		}
    		else
    		{
    				$postcat->save();
            if(!empty($request['subcategory']))
              $this->setProductRelation($request['subcategory'], $postcat->id);
    				$request->session()->flash('succ', 'One item added successfully!!!');
    		}

      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      return redirect('/admin/product/category/add');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPost($id)
    {
      try {
          Cat_relation::where('postid', $id)->delete();
          Postmeta::where('postid', $id)->delete();
          Posts::destroy($id);
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCategory($id)
    {
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
      return back()->with('succ', 'One item deleted');
    }


    /*
     * Product's Brand section starts here
     */
    public function brandIndex($id=""){
        $brands = Brands::all();
        if($id!="")
        {
            $editcat = Brands::where('id', $id)->first();
            return view('admin.price.brandindex')->with('brands', $brands)
                ->with('editcat', $editcat);

        }

        return view('admin.posts.brandindex');

    }

    public function brandstore(Request $request){
        try {
            if($request['catid']!="")
                $postcat = Brands::where('id', $request['catid'])->first();
            else
                $postcat = new Brands();

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
            Brands::destroy($id);
        } catch ( Illuminate\Database\QueryException $e) {
            var_dump($e->errorInfo);
        }
        return redirect('/admin/price/brand')->with('succ', 'One item deleted');
    }

    /*
     * Product's Brand section ends here
     */

    /* --------------------------- Page controller --------------------------*/
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

    public function getMetaValue($metakey, $postid)
    {
      if($metakey!="" and $postid!="")
      {
        $metavalue = Postmeta::where('postid', '=', $postid)
                                ->where('meta_key', '=', $metakey)->first();
        if(!empty($metavalue))
          return $metavalue->meta_value;
      }
        return "";
    }

    public function getCategoryName($slug="", $id="")
    {
      if($slug!="")
      {
        $catName = Postcat::where('slug', '=', $slug)->first();
        return $catName->name;
      }
      elseif($id!="")
      {
        $catName = Postcat::where('id', '=', $id)->first();
        return $catName->name;
      }
      else
        return "";
    }

    public function getSubCategory($id, $isa)
    {
      $cats = Postcat::where('parent', '=', $id)->get();
      if($isa==true)
        return response()->json(['response' => 'This is post method']);
      else
        return $cats;
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

    public function addSliderItems($sliders, $pid)
    {
      foreach($sliders as $s)
      {
        $postMeta = "";
        $postMeta = Postmeta::where('postid', $s)
                            ->where('meta_key', '=', 'home-slider')->first();
        if(!empty($postMeta))
        {
          $postMeta->postid = $s;
          $postMeta->meta_key = 'home-slider';
          if(strpos($postMeta->meta_value, ",") > 0)
          {
            $sArr = explode(",", $postMeta->meta_value);
            array_push($sArr, $pid);
            $sun = array_unique($sArr);
            $postMeta->meta_value = implode(",", $sun);
          }
          else
          {
            if($postMeta->meta_value!=$pid)
              $sun = $postMeta->meta_value.",".$pid;
            else
              $sun = $pid;
            $postMeta->meta_value =  $sun;
          }
          $postMeta->update();
        }
        else
        {
          $postMeta = "";
          $postMeta = new Postmeta();
          $postMeta->postid = $s;
          $postMeta->meta_key = 'home-slider';
          $postMeta->meta_value = $pid;
          $postMeta->save();
        }
      }
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

    public function getPostByField($fieldName, $fieldValue, $operator='=')
    {
      $post = Posts::where($fieldName, $operator, $fieldValue)->get();
      return $post;
    }

    public function getThumbnail($image)
    {
      return substr_replace($image, '/thumbs/', strrpos($image, "/"), 0);
    }

    /* gets the recommended products of the post
     * Parameter: post id
     * Returns array of products
     */
    public function getRecomendedProduct($postid)
    {
      $pc = new PostCatController();
      $cats = $pc->getPostCategories($postid);
      $productlist = $pc->getRelationProduct($cats);

      return $productlist;
      //$product = $productlist[0];
      //$postmeta = $product->postmeta;

      //print_r($postmeta);
    }

    /* insert the rlation of each product type and its $subcategories
     * Parameter: subcategory array and product type id
     * Return nothing
     */
     public function setProductRelation($subs, $pid)
     {
       //echo $pid;exit;
       $delCatRelation = Psc_relation::where('catid', $pid)->delete();
       foreach($subs as $s)
       {
           $addrel="";
           $addrel = new Psc_relation();
           $addrel->catid = $pid;
           $addrel->parent = $s;
           $addrel->save();
       }
     }

     public function getSubsOfProductType($id)
     {
        $subs=array();$output="";
        $subcategories = Postcat::where('type', '=', 'category')
                                    ->where('parent', '!=', '0')
                                    ->get();
        $psc = Psc_relation::where('catid', '=', $id)->get();
        if(!empty($psc))
        {
          foreach($psc as $p)
          {
            $subs[] = $p->parent;
          }
        }
        foreach($subcategories as $sb)
        {
            if(in_array($sb->id, $subs))
              $output .= '<option value="'.$sb->id.'" selected>'.$sb->name.'</option>';
            else
              $output .= '<option value="'.$sb->id.'">'.$sb->name.'</option>';
        }
        return response()->json($output);
     }


     public function getLinkById($id)
     {
       $post = Posts::where('id', '=', $id)->first();
       return url('item/'.$post->clean_url);
     }
}
