<?php

namespace App\Http\Controllers\Backend\Posts;

use App\Models\Posts;
use App\Models\Postmeta;
use App\Models\Cat_relation;

use App\Http\Controllers\Backend\Posts\PostController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //
    public function indexPage(){
        $pages = Posts::where('ctype','page')->get();
        return view('backend.pages.pages')->with('pages',$pages);
    }

    public function createPage($id=''){

        if($id!="")
        {
            $pages = Posts::where('ctype', '=', 'page')
                ->where('id', '=', $id)->first();
            return view('backend.pages.add-pages')->with('post', $pages);
        }
        return view('backend.pages.add-pages');
    }

    public function store(Request $request)
    {

        $pc = new PostController();
        try{
            if(Auth::check())
                $user = Auth::user();
            if($request['postid']!="")
                $posts = Posts::where('id', $request['postid'])->first();
            else
                $posts = new Posts();

            $posts->title = $request['prodTitle'];

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
            return back()->withFlashSuccess( 'One item updated successfully!!!');
        else
            return back()->withFlashSuccess( 'One item added successfully!!!');

        //return redirect('/admin/product/add');
    }

    public function destroyPage($id)
    {

        Postmeta::where('postid', $id)->delete();
        Posts::where('id',$id)->delete();
        return redirect()->route('admin.page.indexPage')->withFlashSuccess(__('alerts.backend.page.deleted'));
    }

}
