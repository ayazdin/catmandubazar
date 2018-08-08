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


    /* 
     * Storing the form data, for page and opening it in edit mode
     * 
     * returns redirection to edit page
    */    
    public function store(Request $req)
    {
      $pc = new PostsController();
      $postId = $pc->justStore($req);            
      return redirect('/admin/page/edit/'.$postId);
    }

    public function destroyPage($id)
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

}
