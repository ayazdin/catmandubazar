<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use DB;
use App\Http\Controllers\Posts\PostCatController;
use App\Http\Controllers\Posts\PostsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdsController extends Controller
{
    public function listAds()
    {
      $posts = Posts::where('ctype', '=', 'ads')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
      return view('admin.ads.ads')->with('posts', $posts);
    }

    public function createAds($id="")
    {
      $catCtrl = new PostCatController();

      //$position  = Postcat::where('type','=', 'ads')->orderBy('catorder', 'ASC')->get();
      if($id!="")
      {
        $sel="";
        $catrel = Cat_relation::where('postid','=', $id)->get();
        if($catrel->isNotEmpty())
        {
          foreach($catrel as $cr)
          {
              $sel[]=$cr->catid;
          }
        }
        $ddlCat = $catCtrl->getCategoryList('li', $sel, 'ads');
        $ads = Posts::where('ctype', '=', 'ads')
                        ->where('id', '=', $id)
                        ->first();
        return view('admin.ads.add-ads')->with('ddlCat', $ddlCat)
                                          ->with('post', $ads);
      }
      else {
        $ddlCat = $catCtrl->getCategoryList('li', '', 'ads');
      }
      return view('admin.ads.add-ads')->with('ddlCat', $ddlCat);
    }

    public function storeAds(Request $request)
    {
      try{
          $pc = new PostsController();
          if(Auth::check())
              $user = Auth::user();
          if($request['postid']!="")
            $posts = Posts::where('id', $request['postid'])->first();
          else
            $posts = new Posts();

          $posts->title = $request['prodTitle'];
          if(empty($request['prodSlug']))
            $posts->clean_url = $pc->generateSeoURL($request['prodTitle']);
          else
            $posts->clean_url = $request['prodSlug'];

          if($request['description']!="")
            $posts->content = $request['description'];

          $posts->status = $request['rdoPublish'];
          $posts->ctype = $request['ctype'];
          $posts->userid = $user->id;
          if($request['featuredimage']!="")
            $posts->image = $request['featuredimage'];

          if($request['postid']!="")
            $posts->update();
          else
            $posts->save();
          if(!empty($request['category']))
            $pc->addCategoryRelation($request['category'], $posts->id);
          $pc->addAttributes('startdate', $request['startDate'], $posts->id);
          $pc->addAttributes('enddate', $request['endDate'], $posts->id);
          //$this->addAttributes('author_post', $request['author_post'], $posts->id);
      }
      catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
          $request->session()->flash('fail', 'Due to some technical issues the request cannot be done!!!');
      }
      if($request['postid']!="")
        $request->session()->flash('succ', 'One item updated successfully!!!');
      else
      {
        $request->session()->flash('succ', 'One item added successfully!!!');
        return redirect('/admin/ads/edit/'.$posts->id);
      }
      return back();
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adsPosition($id="")
    {
      $postcat  = Postcat::where('type','=', 'ads')->orderBy('catorder', 'ASC')->paginate(25);
      if($id!="")
      {
        $position = Postcat::where('type','=', 'ads')
                              ->where('id', '=', $id)->first();
        return view('admin.ads.ads-position')->with('position', $position)
                                          ->with('postcat', $postcat);
      }
      return view('admin.ads.ads-position')->with('postcat', $postcat);
    }

    /**
     * Store a newly created advertisement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePosition(Request $request)
    {
      try {
        $pc = new PostsController();
        if($request['catid']!="")
          $postcat = Postcat::where('id', $request['catid'])->first();
        else
          $postcat = new Postcat();

        $postcat->name = $request['catName'];
        if(empty($request['slug']))
          $slug = $pc->generateSeoURL($request['catName']);
        else
          $slug = $request['slug'];
        if(!empty($request['categoryType']))
          $postcat->type = $request['categoryType'];
        else
          $postcat->type = 'category';
        $postcat->slug = $pc->getUniqueSlug($slug, $postcat->id);
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
      return back();
    }

    public function adsDelete($id)
    {
      try {
          Cat_relation::where('postid', $id)->delete();
          Posts::where('id', $id)->delete();
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }

    public function deletePosition($id)
    {
      try {
          Cat_relation::where('catid', $id)->delete();
          Postcat::where('id', $id)->delete();
      } catch ( Illuminate\Database\QueryException $e) {
          var_dump($e->errorInfo);
      }
      return back()->with('succ', 'One item deleted');
    }


}
