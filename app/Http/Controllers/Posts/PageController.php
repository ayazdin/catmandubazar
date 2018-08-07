<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Http\Controllers\Posts\PostsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPage()
    {
      $pages = Posts::where('ctype', '=', 'page')
                          ->orderBy('updated_at', 'DESC')->paginate(25);
        return view('admin.pages.pages')->with('pages', $pages);
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPage($id="")
    {
        if($id!="")
        {
          $pages = Posts::where('ctype', '=', 'page')
                            ->where('id', '=', $id)->first();
          return view('admin.pages.add-pages')->with('post', $pages);
        }
        return view('admin.pages.add-pages');
    }


    /**
     * Show the form for edit Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPage($id)
    {
        $post = Posts::where('id', $id)->first();
        //print_r($post->postmeta);
        return view('admin.pages.add-pages')->with('post', $post)
                                                              ->with('postmeta', $post->postmeta);
    }

    public function store(Request $request)
    {
      $pc = new PostsController();
      try{
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
          $pc->addAttributes('keywords', $request['keywords'], $posts->id);
          $pc->addAttributes('metadesc', $request['metadesc'], $posts->id);
          //$pc->addAttributes('author_post', $request['author_post'], $posts->id);
          //$pc->addAttributes('enterby', $request['enterby'], $posts->id);
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
      //return redirect('/admin/product/add');
    }

}
