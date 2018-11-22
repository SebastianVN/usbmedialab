<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GalleryCategory;
use App\GalleryContent;
use App\StaticContent;
use App\ContentBox;
use App\StaticPage;
use App\SystemNotification;
use App\User;
use Carbon\Carbon;
Carbon::setLocale('es');
use DateTime;
use Response;
use Mail;
use Auth;
use File;
use Log;
use DB;
class SudoController extends Controller
{
    public function delete_page(Request $request){
      Log::debug($request);
      $this->validate($request, [
        'id'=>'required|integer|min:0',
      ]);
      $page = StaticPage::find($request->id);
      if(isset($page)){
      $page->delete();
    }else{
      abort(404);
    }
    }
    public function sudo(){
        return View('admin.sudo_dashboard');
    }
    public function sudo_site($identifier = null){
      if(isset($identifier)){return View('admin.sudo_page',['identifier' => $identifier]);}else{abort(404);}
    }
    public function content_boxes($alias){
      return View('admin.content_boxes',['alias' => $alias]);
    }
    public function content_box(){
      return View('admin.content_box');
    }
    public function system_notification($id){
      return View('admin.sudo_system_notification',['id'=>$id]);
    }
    public function new_content_box(Request $request){
      Log::debug($request);
      $this->validate($request,[
        'alias' => 'required|string',
        'page_select' => 'required|integer',
      ]);
      $page = StaticPage::find($request->page_select);
      $boxes = ContentBox::where('page_id',$request->page_select)->count();
      $box = new ContentBox;
      $box->alias = $request->alias;
      $box->page_id = $request->page_select;
      $box->page_order = $boxes + 1;
      $box->save();
      return response()->json(['box'=>$box ]);
    }
    public function new_registry(Request $request){
      $this->validate($request,[
        'identifier'=>'required|string',
        'lang'=>'required|string',
        'descripcion'=>'required|string',
        'content_type'=>'required|string',
        'content'=>'required|string',
        'box'=>'required|integer',
      ]);
      $box = ContentBox::find($request->box);
      $contents = StaticContent::where('box_id',$request->box)->count();
      $content = new StaticContent;
      $content->identifier = $request->identifier;
      $content->box_id = $request->box;
      $content->lang = $request->lang;
      $content->descripcion = $request->descripcion;
      $content->content_type = $request->content_type;
      $content->content = $request->content;
      $content->box_order = $contents + 1;
      $content->save();
    }
    public function order_content_box(Request $request){
      Log::debug($request);
      $this->validate($request, [
        'id'=>'required|integer|min:0',
      ]);
      $boxes = ContentBox::where('page_id',$request->id)->get();
      $max = ContentBox::where('page_id',$request->id)->count();
      Log::debug($max);
      $order =1;
      while ($order <= $max) {
        foreach($boxes as $box){
        $box->page_order = 0;
        $box->page_order = $box->page_order+$order;
        Log::debug($box->page_order);
        $box->save();
        $order++;
        }
      }
      return response()->json(['id'=>$request->id]);
    }
    public function up_box(Request $request){
      Log::debug($request);
      $this->validate($request,[
        'box_id'=>'required|integer',
      ]);
      $up = ContentBox::find($request->box_id);
      if($up->page_order > 1){
        $anterior = $up->page_order - 1;
        $previous = ContentBox::where('page_order',$anterior)->where('page_id',$up->page_id)->first();
        $previous->page_order++;
        $up->page_order = $anterior;
        $previous->save();
        $up->save();
        return response()->json(['box_id'=>$request->box_id]);
      }
    }
    public function up_content(Request $request){
      log::debug($request);
      $this->validate($request,[
        'content_id'=>'required|integer',
      ]);
      $up = StaticContent::find($request->content_id);
      if($up->box_order > 1){
        $anterior = $up->box_order - 1;
        $previous = StaticContent::where('box_order',$anterior)->where('box_id',$up->box_id)->first();
        $previous->box_order++;
        $up->box_order = $anterior;
        $previous->save();
        $up->save();
        return response()->json(['content_id'=>$request->content_id]);
      }
    }
    public function down_box(Request $request){
      Log::debug($request);
      $this->validate($request,[
        'box_id'=>'required|integer',
      ]);
      $down = ContentBox::find($request->box_id);
      $max = ContentBox::where('page_id',$down->page_id)->count();
      if($down->page_order < $max){
        $siguiente = $down->page_order + 1;
        $next = ContentBox::where('page_order',$siguiente)->where('page_id', $down->page_id)->first();
        $next->page_order--;
        $down->page_order = $siguiente;
        $next->save();
        $down->save();
        return response()->json(['box_id'=>$request->box_id]);
      }
    }
    public function get_sudo_content(Request $request){
      Log::debug($request);
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $content = StaticContent::where('box_id',$request->id)->orderBy('box_order')->get();
      $alias = ContentBox::find($request->id);
      if(isset($content)){
        return response()->json(['contents' => $content, 'alias' => $alias->alias, 'box_id'=>$alias->id]);
      }
    }
    public function down_content(Request $request){
      log::debug($request);
      $this->validate($request,[
        'content_id'=>'required|integer',
        'box_id'=>'required|integer',
      ]);
      $max = StaticContent::where('box_id',$request->box_id)->count();
      $down = StaticContent::find($request->content_id);
      if($down->box_order < $max){
        $siguiente = $down->box_order + 1;
        $next = StaticContent::where('box_order',$siguiente)->where('box_id',$down->box_id)->first();
        $next->box_order--;
        $down->box_order = $siguiente;
        $next->save();
        $down->save();
        return response()->json(['content_id'=>$request->content_id]);
      }
    }
    public function delete_content_box(Request $request){
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $boxs = ContentBox::find($request->id);
      $content = StaticContent::where('box_id',$request->id);
      $boxs->delete();
      $content->delete();
    }
    public function get_page(Request $request){
      Log::debug($request);
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $page = StaticPage::where('id',$request->id)->first();
      if(isset($page)){
        return response()->json(['page'=>$page]);
      }
    }
    public function delete_all_page (Request $request){
      log::debug($request);
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $page = StaticPage::where('id',$request->id)->first();
      Log::debug($page);
      $boxs = ContentBox::where('page_id',$page->id)->first();
      if(isset($boxs)){
        $boxs->delete();
      }
      Log::debug($boxs);
      $contents = StaticContent::where('box_id',$boxs->id)->first();
      if(isset($contents)){
        $contents->delete();
      }
      $page->delete();
    }
    public function enable_user(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'id' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
        ]);
            $user = User::find($request->id);
            $user->level = $request->level;
            $user->save();
            return response()->json(['name'=>$user->name,'id'=>$request->id,'level'=>$request->level,'email'=>$user->email]);
    }
    public function disabled_user(Request $request){
      log::debug($request);
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $user = User::find($request->id);
      $user->level = 1;
      $user->save();
      return response()->json(['id' => $request->id]);
    }
     public function new_page(Request $request){
      Log::debug($request);
     	$this->validate($request,[
     		'identifier' => 'required|string',
     		'title' => 'required|string',
     		'description' => 'required|string',
     		'url' => 'required|string',
        'keywords_es' => 'required|string',
        'title_en' => 'string',
        'description_en' => 'string',
        'keywords' => 'string',
        'bilingual' => 'integer'
     	]);
     	$page = new StaticPage;
     	$page->identifier = $request->identifier;
     	$page->es_title = $request->title;
      $page->en_title = $request->title_en;
      $page->es_description = $request->description;
     	$page->en_description = $request->description_en;
      $page->en_keywords = $request->keywords;
      $page->es_keywords = $request->keywords_es;
      $page->bilingual = $request->bilingual;
     	$page->url = $request->url;
     	$page->save();
      return response()->json(['identifier' => $request->identifier, 'descripcion' =>$request->description, 'url' =>$request->url, 'id' => $page->id]);
     }
     public function edit_page(Request $request){
        log::debug($request);
        $this->validate($request, [
            'id' => 'required|integer|min:0',
            'identifier' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
            'keywords_es' => 'required|string',
            'title_en' => 'string',
            'description_en' => 'string',
            'keywords' => 'string',
            'bilingual' => 'integer',
        ]);

        $page = StaticPage::find($request->id);
        $page->identifier = $request->identifier;
        $page->es_title = $request->title;
        $page->es_description = $request->description;
        $page->en_title = $request->title_en;
        $page->en_keywords = $request->keywords;
        $page->es_keywords = $request->keywords_es;
        $page->en_description = $request->description_en;
        $page->bilingual = $request->bilingual;
        $page->url = $request->url;
        $page->save();
        return response()->json(['page' => $page ]);
     }
     public function get_identifier_sudo(Request $request){
         $this->validate($request,[
             'id'=> 'required|integer',
             ]);
         $content = StaticContent::find($request->id);
         if(isset($content)){
             return response()->json(['content' => $content]);
         }else{
             abort(404);
         }
     }
     public function save_identifier (Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id' => 'required|integer|min:0',
         'identifier' => 'required|string',
         'lang'=>'required|string',
         'descripcion'=> 'required|string',
         'content_type'=> 'required|string',
         'content_box'=> 'required|integer',
         'content'=> 'required|string',
       ]);
       $identifier = StaticContent::find($request->id);
         $identifier->identifier = $request->identifier;
         $identifier->lang = $request->lang;
         $identifier->descripcion = $request->descripcion;
         $identifier->content_type = $request->content_type;
         $identifier->box_id = $request->content_box;
         $identifier->content = $request->content;
         $identifier->save();
     }
     public function delete_notification(Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id' =>'required|integer',
       ]);
       $notification = SystemNotification::find($request->id);
       $notification->delete();
     }
     public function delete_note(Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id' => 'required|integer',
       ]);
       $notification = SystemNotification::find($request->id);
       $notification->delete();
     }
     public function blocked_user(Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id'=> 'required|integer',
       ]);
       $user = User::find($request->id);
       $user->status = 'blocked';
       $user->save();
       return response()->json(['user'=>$user]);
     }
     public function unBlocked_user(Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id'=> 'required|integer',
       ]);
       $user = User::find($request->id);
       $user->status = 'active';
       $user->save();
       return response()->json(['user'=>$user]);
     }
     public function delete_user(Request $request){
       Log::debug($request);
       $this->validate($request,[
         'id'=> 'required|integer',
       ]);
       $user = User::find($request->id);
       $user->delete();
     }
}
