<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts;
use App\Models\Postcat;
use App\Models\Postmeta;
use App\Models\Cat_relation;
use App\Models\Psc_relation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostCatController extends Controller
{
  public function getCategoryList($list="", $sel="")
  {
    //echo "sjdhf sjdfhsjdf";exit;
    $categories="";
    $output="";
    $parents = $this->getParent();

    if(!empty($parents))
    {
      //print_r($parents);exit;
      $categories = array();
      foreach($parents as $p)
      {
        $prod_sel='';
        if(is_array($sel) and in_array($p->id, $sel ))
            $prod_sel='selected';
        elseif($sel==$p->id)
          $prod_sel='selected';
        $subCat = $this->hasChild($p->id, $sel);
        if($subCat!==false)
          $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel,  'subcategory' => $subCat);
        else
          $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel);
      }
    }

    if($list=="li")
    {
      $output="";
      if(!empty($categories))
      {//print_r($categories);exit;
        $output .= '<ul>';
        $output .= $this->getCategoryLi($categories, $sel);
        $output .= '</ul>';
      }
      //echo $output;exit;
      return $output;
    }
    else
      return $categories;
  }

  public function getParent()
  {
    return Postcat::where('type', '=', 'category')
                        ->where('parent', '=', '0')
                        ->get();
  }

  public function hasChild($id, $sel="")
  {
    //print_r($sel);
    $cat = array();
    $categories = Postcat::where('parent', '=', $id)->get();
    if(!empty($categories) and $categories!== false)
    {//print_r($categories);exit;
      foreach($categories as $category)
      {
        $prod_sel='';
        if(is_array($sel) and in_array($category->id, $sel))
          $prod_sel='selected';
        elseif($sel==$category->id)
          $prod_sel='selected';
        //$subCat = $this->hasChild($category->id);
        $prodType = $this->getProductType($category->id, $sel);
        /*if($subCat!==false)
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'subcategory' => $subCat);
        else*/
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'selected' => $prod_sel, 'prodType' => $prodType);
      }
      return $cat;
    }
    else
      return false;
  }

  public function getProductType($parent, $sel="")
  {
    $cat = array();
    //$psc = Psc_relation::where('parent', '=', $parent)->get();
    if(!empty($psc))
    {
      foreach($psc as $p)
      {
        $prod_sel='';
        if(is_array($sel) and in_array($p->catid, $sel))
          $prod_sel='selected';
        elseif($sel==$p->id)
          $prod_sel='selected';
        $category = Postcat::where('id', '=', $p->catid)->first();
        if(!empty($category))
        {
          $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'selected' => $prod_sel);
        }
      }
    }
    return $cat;
  }

  public function getCategoryLi($categories, $sel="")
  {
    $output = "";
    if(!empty($categories))
    {//echo "herer ";print_r($categories);exit;
      //echo "ksdjhfksjdf";print_r($sel);exit;
      foreach($categories as $cat)
      {
        if($sel!="")
        {
          if(in_array($cat['id'], $sel))
            $output .='<li><label><input type="checkbox" name="category[]" checked value="'.$cat['id'].'"></label> '.$cat['name'];
          else
            $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        }
        else
          $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
        if(!empty($cat['subcategory']))
        { //print_r($cat['subcategory']);exit;
          $output .='<ul>';
          $output .=$this->getCategoryLi($cat['subcategory'], $sel);
          $output .='</ul></li>';
        }
        else
          $output .= '</li>';
      }
    }
    //echo $output;exit;
    return $output;
  }

  /* gets the categories of the post
   * Parameter: post id whose categories to be returned
   * Returns array of categories
   */
  public function getPostCategories($postid)
  {
      $cat="";
      $categories = Cat_relation::where('postid', '=', $postid)->get();
      foreach($categories as $category)
      {
        $cat[]=$category->catid;
      }
      return $cat;
  }

  /* gets the products id list of the categories
   * Parameter: Category id array
   * Returns array of products id
   */
  public function getRelationProduct($cats)
  {
    $products="";
    //$products = Cat_relation::where('postid', '=', $postid)->get();
    $results = Cat_relation::where(function ($q) use ($cats) {
        foreach ($cats as $c) {
            $q->orWhere('catid', '=', $c);
        }
    })->get();
    //print_r($results);
    //echo "Search index: ".$results->search($postid);

          //->where('postid', '!=', $postid);
    $products = Posts::where(function ($q) use ($results) {
        foreach ($results as $result) {
            $q->orWhere('id', '=', $result->postid);
        }
    })->get();
    return $products;
  }

  /* gets the shops with all the category
   * Parameter: none
   * Returns array of category with shops
   */
  public function getShopTree()
  {
    $shops = "";
    $cat = Postcat::where('type', '=', 'sites')
                    ->orderBy('catorder', 'ASC')->get();
    if(!empty($cat))
    {
      $iCount=0;
      foreach($cat as $c)
      {
        $post = "";
        $s = array('id' => $c->id, 'name' => $c->name);
        $cat_relation = Cat_relation::where('catid', '=', $c->id)->get();
        if(!empty($cat_relation))
        {
          foreach($cat_relation as $cr)
          {
            $p = $cr->posts;
            //print_r($p);echo "<br><br>";
            if(!empty($p))
            {
              $post[]=array('id' => $p->id, 'title' => $p->title, 'link' => $p->excerpt, 'image' => $p->image);
              $s['shops'] = $post;
            }
          }
        }
        $shops[$iCount] = $s;//array_push($s, $post);
        $iCount++;
      }
    }
    return $shops;
  }

}
