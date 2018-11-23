<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserMail;
use App\NotificationSubscription;
use App\BlogViewsHistory;
use App\GalleryCategory;
use App\GalleryContent;
use App\ContactMessage;
use App\BlogDestacado;
use App\StaticContent;
use App\BlogCategory;
use App\SocialMedia;
use App\BlogStatus;
use App\HasBlogTag;
use App\StaticPage;
use App\ContentBox;
use App\BlogMedia;
use App\SentMail;
use App\BlogPost;
use App\BlogTag;
use App\Blogger;
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
use App\Events\UserDeleted;

function post_status_class($status){
    switch ($status) {
        case 'waiting_approval':
            return("warning");
        case 'approved_unavailable':
            return("danger");
        case 'approved_available':
            return("");
        case 'not_approved':
            return("danger");
        case 'needs_revision':
            return("info");
        default:
            break;
    }
}

function make_destacados_row(){
    $destacados = BlogDestacado::all();
    $response="";
    foreach($destacados as $destacado){
        $post_destacado = BlogPost::find($destacado->post_id);
        $response .= '<a href="/Mr_Administrator/BlogMan/post_editor/'. $post_destacado->name_identifier .'" class="btn btn-default"><i class="fa fa-star" aria-hidden="true"></i><br>'. $post_destacado->name .'</a>';
    }
    return $response;
}

function make_post_row($post){
    $total_posts = BlogStatus::where('name_identifier', 'total_posts')->first()->int_content;
    $destacados = BlogDestacado::all();
    $array_destacados = array();
    $category = BlogCategory::find($post->category_id);
    if(isset($category)){
      $post_link = url('smart_blog/'.$category->name_identifier.'/'.$post->name_identifier);
    }else{
      $post_link = url('smart_blog/loner_post/'.$post->name_identifier);
    }
    foreach ($destacados as $destacado){ $array_destacados[] = $destacado->post_id; }
    $blogger = Blogger::find($post->blogger_id);
    $btns='';
    if($post->status == "waiting_approval" || $post->status == "not_approved"){
    $btns.= '<button class="btn btn-warning btn-xs approve_post" value="'. $post->id .'">Aprobar</button>&nbsp;';
    }elseif($post->status == "approved_unavailable"){
    $btns.= '<button class="btn btn-warning btn-xs enable_post" value="'. $post->id .'">Habilitar</button>&nbsp;';
    }else{
    $btns.= '<button class="btn btn-warning btn-xs disable_post" value="'. $post->id .'">Deshabilitar</button>&nbsp;';
    }
    if(in_array($post->id, $array_destacados)){
    $btns.= '<button class="btn btn-warning btn-xs desdestacar_post" value="'. $post->id .'">Remover Destacado</button>&nbsp;';
    }else{
    $btns.= '<button class="btn btn-info btn-xs destacar_post" value="'. $post->id .'">Agregar a Destacados</button>&nbsp;';
    }
    $response = '<tr class="'. post_status_class($post->status) .'" id="post_'. $post->id .'">
            <td><a href="'. $post_link .'">'. $post->name .'</a></td>
            <td>'. $blogger->name .'</td>
            <td>'. $post->created_at.' ('. $post->created_at->diffForHumans() .')</td>
            <td>'. $post->description .'</td>
            <td>'. $post->total_views .'</td>
            <td>
                '.$btns.'
                <a class="btn btn-success btn-xs edit_post" href="/Mr_Administrator/BlogMan/post_editor/'.$post->name_identifier.'">Editar</a>
                <button class="btn btn-danger btn-xs delete_post" value="'. $post->id .'">Eliminar</button>
            </td>
        </tr>
    ';
    return($response);
}

class AdminController extends Controller
{
    public function dashboard(){
        return View('admin.dashboard');
    }

    public function site_dashboard(){
        return View('admin.site_dashboard');
    }

    public function site_page($identifier){
        return view('admin.site_page', ['identifier' => $identifier]);
    }

    public function messages(){
        return View('admin.messages');
    }

    public function proyecto(){
        return View('admin.proyecto');
    }
    public function reports(){
        return View('admin.reports');
    }

    public function send_message_view(){
        return View('admin.send_message');
    }

    public function academy_dashboard(){
        return View('admin.academy_dashboard');
    }

    public function sent_messages($identifier = null){
        return view('admin.sent_messages', ['identifier' => $identifier]);
    }

    public function social_media(){
        return View('admin.social_media');
    }
    public function save_box(Request $request){
      $this->validate($request,[
        'id'=>'required|integer|min:0',
        'alias'=>'required|string',
      ]);
      $box = ContentBox::find($request->id);
      $box->alias = $request->alias;
      $box->save();
    }
    public function subscription(Request $request){
      $this->validate($request,[
        'id'=>'required|integer',
        'email'=>'required|email',
        'level'=>'required|integer',
      ]);
      if($request->id == -1){
        $subscription = new NotificationSubscription;
      }else{
        $subscription = NotificationSubscription::find($request->id);
      }
      $subscription->email = $request->email;
      $subscription->level = $request->level;
      $subscription->created_by = Auth::user()->id;
      $subscription->save();
      return response()->json(['subscription' => $subscription]);
    }
    public function subscription_delete(Request $request){
      $this->validate($request,[
        'id'=>'required|integer',
      ]);
      $subscription = NotificationSubscription::find($request->id);
      $subscription->delete();
    }

    public function get_content_box(Request $request){
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

    public function send_message(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'from'=> 'required|string',
            'subject'=> 'required|string',
            'message'=> 'required|string',
            ]);
        $message = new SentMail;
        $message->from = $request->from;
        $message->subject = $request->subject;
        $message->message = $request->message;
        $message->to_array = implode(', ', $request->to_array);
        $message->save();
        Log::debug($message->to_array);
        $to_array = explode(', ', $message->to_array);
        Log::debug($to_array);
        foreach ($to_array as $key) {
            $user = User::find($key);
            if(isset($user)){
                Mail::to($user)->send(new UserMail($message));
                Log::debug("Mensaje enviado a " . $user->email);
            }
        }
    }

    public function add_all(){
        $users = User::select('id', 'name', 'surname', 'email')->get();
        return response()->json(['users' => $users]);
    }

    public function save_social(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'icon'=> 'required|string',
            'name'=> 'required|string',
            'url'=> 'required|string',
            'identifier'=> 'required|string|unique:social_media',
            ]);
        $social = new SocialMedia;
        $social->identifier = $request->identifier;
        $social->name = $request->name;
        $social->url = $request->url;
        $social->icon = $request->icon;
        $social->save();
        return response()->json(['social' => $social]);
    }

    public function save_footer(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'identifier'=> 'required|string',
            'value'=> 'required|string',
            ]);
        $item = StaticContent::where('identifier', 'footer_'.$request->identifier)->first();
        if(isset($item)){
            $item->content = $request->value;
            $item->save();
        }
    }

    public function delete_social(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $social = SocialMedia::find($request->id);
        $social->delete();
    }

    public function view_message(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $message = ContactMessage::find($request->id);
        if(isset($message)){
            $message->read = 1;
            $message->save();
            $diff = $message->created_at->diffForHumans();
            return response()->json(['message' => $message, 'diff' => $diff]);
        }else{
            abort(404);
        }
    }
    public function unread_message(Request $request){
        $this->validate($request,[
            'id' => 'required|integer|min:0'
            ]);
        $message = ContactMessage::find($request->id);
        if(isset($message)){
            $message->read = 0;
            $message->save();
            return response()->json(['message' => $message]);
        }else{
            abort(404);
        }
    }

    public function delete_message(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $message = ContactMessage::find($request->id);
        if(isset($message)){
            $message->delete();
            return response()->json(['status' => 'eliminado']);
        }else{
            abort(404);
        }
    }

    public function delete_sent(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        if($request->id != -21){
            $message = SentMail::find($request->id);
            if(isset($message)){
                $message->delete();
                return response()->json(['status' => 'eliminado']);
            }else{
                abort(404);
            }
        }else{
            //Eliminar Todos
            SentMail::truncate();
            return response()->json(['status' => 'eliminados todos']);
        }
    }

    public function delete_all_messages(){
        ContactMessage::truncate();
        return response()->json(['status' => 'eliminados todos']);
    }

    public function users(){
        return View('admin.users');
    }

    public function gallery($category_id = 'destacados'){
        if($category_id ==  'destacados'){
            return View('admin.gallery');
        }else{
            Log::debug($category_id);
            $category = GalleryCategory::where('identifier', $category_id)->first();
            if(isset($category)){
                return view('admin.gallery', ['selected_cat' => $category]);
            }else{
                abort(404);
            }
        }
    }

    public function deleteUser(Request $request){
        $this->validate($request,[
            'id' => 'required|integer|min:0',
            ]);
        $user = User::find($request->id);
        if(isset($user)){
            event(new UserDeleted($user));
            $user->delete();
            /*
            $notification = new SystemNotification;
            $notification->ip = $request->ip();
            $notification->type = 'Delete_user';
            $notification->valor = null;
            $notification->content = 'El usuario '.$user->name.' '.$user->email.' ha sido eliminado';
            $notification->asociated_id = $user->id;
            $notification->save();
            */
            return Response::json(['estado' => 'Eliminado']);
        }else{
            abort(404);
        }
    }

    public function save_page(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            'es_title'=> 'required|string',
            'en_title'=> 'string',
            'page_description'=> 'string',
            'page_keywords'=> 'string',
            ]);
        $page = StaticPage::find($request->id);
        if(isset($page)){
            $page->es_title = $request->es_title;
            $page->en_title = $request->en_title;
            $page->descripcion = $request->page_description;
            $page->keywords = $request->page_keywords;
            $page->save();
            return response()->json(['page' => $page]);
        }else{
            abort(404);
        }
    }

    public function save_content(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            'contenido'=> 'required|string',
            ]);
        $content = StaticContent::find($request->id);
        if(isset($content)){
            if($request->contenido != 'imagen'){
                $content->content = $request->contenido;
            }else{
                Log::debug("Subiendo imagen");
                if ($request->hasFile('file')) {
                //Check if previous existed
                $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/page_content/";
                if(File::exists($destinationPath.$content->content)){
                    File::delete($destinationPath.$content->content);
                    Log::debug("Previous Img Deleted, checking deletion...");
                    if(File::exists($destinationPath.$content->content)){
                        Log::debug("Shit, It didnt work");
                    }else{
                        Log::debug("Succesfully Deleted");
                    }
                }
                $imageName = md5($content->identifier.'_'.$content->box_id).'.'.$request->file->getClientOriginalExtension();
                $request->file->move($destinationPath, $imageName);
                $content->content = $imageName;
            }
            }
            $content->save();
            return response()->json(['content' => $content->content]);
        }else{
            abort(404);
        }
    }

    public function gallery_video($video_id = null){
        Log::debug($video_id);
        $picture = GalleryContent::where('file_name', $video_id)->first();
        if(isset($picture)){

        }else{
            abort(404);
        }
    }

    public function save_image(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'id'=> 'required|integer',
            'img_title'=> 'required|string|max:255',
            'img_caption'=> 'string',
            'category' => 'integer',
            'new_category' => 'string',
            ]);
        if($request->id == -1){
            $picture = new GalleryContent;
        }else{
            $picture = GalleryContent::find($request->id);
        }
        $picture->title = $request->img_title;
        $picture->caption = $request->img_caption;
        if(isset($request->new_category)){
            $category = new GalleryCategory;
            $category->name = $request->new_category;
            $category->identifier = clean_url($category->name);
            $category->save();
            $picture->category_id =  $category->id;
        }else{
            $picture->category_id =  $request->category;
        }

        if ($request->hasFile('file')) {
            Log::debug("Subiendo imagen");
            $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/gallery_content/";
            if(File::exists($destinationPath.$picture->file_name) && isset($picture->file_name)){
                File::delete($destinationPath.$picture->file_name);
                Log::debug("Previous Img Deleted, checking deletion...");
                if(File::exists($destinationPath.$picture->file_name)){
                    Log::debug("Shit, It didnt work");
                }else{
                    Log::debug("Succesfully Deleted");
                }
            }
            $extension = $request->file->getClientOriginalExtension();
            Log::debug($extension);
            $picture->extension = $extension;
            $imageName = md5(time().'_'.$picture->title).'.'.$extension;
            $request->file->move($destinationPath, $imageName);
            $picture->file_name = $imageName;
            if($extension == 'mp4' || $extension == 'ogg'){
                $picture->type = 'video';
            }
        }
        $picture->save();
        return response()->json(['picture' => $picture]);

    }

    public function save_widget(Request $request){
        Log::debug($request);
        $this->validate($request,[
            'id'=> 'required|integer',
            'widget_title'=> 'required|string|max:255',
            'widget_caption'=> 'string',
            'category' => 'integer',
            'widget_category' => 'string',
            ]);
        if($request->id == -1){
            $picture = new GalleryContent;
        }else{
            $picture = GalleryContent::find($request->id);
        }
        $picture->title = $request->widget_title;
        $picture->caption = $request->widget_caption;
        if(isset($request->new_category)){
            $category = new GalleryCategory;
            $category->name = $request->new_category;
            $category->identifier = clean_url($category->name);
            $category->save();
            $picture->category_id =  $category->id;
        }else{
            $picture->category_id =  $request->category;
        }
        $picture->file_name = $request->widget_code;
        $picture->type = 'widget';
        $picture->extension = 'none';
        $picture->save();
        return response()->json(['picture' => $picture]);

    }

    public function delete_image(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $picture = GalleryContent::find($request->id);
        if(isset($picture)){
            Log::debug("Deleting imagen #".$request->id);
            //Check if previous existed
            $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/gallery_content/";
            if(File::exists($destinationPath.$picture->file_name) && isset($picture->file_name)){
                File::delete($destinationPath.$picture->file_name);
                Log::debug("Theoretically Deleted, checking deletion...");
                if(File::exists($destinationPath.$picture->file_name)){
                    Log::debug("Shit, It didnt work");
                }else{
                    $picture->delete();
                    Log::debug("Succesfully Deleted");
                    return response()->json(['status' => 'deleted img']);
                }
            }
        }else{
            abort(404);
        }
    }

    public function feature_image(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $picture = GalleryContent::find($request->id);
        if(isset($picture)){
            if($picture->featured == 0){
                $picture->featured = 1;
            }else{
                $picture->featured = 0;
            }
            $picture->save();
            return response()->json(['featured' => $picture->featured]);
        }else{
            abort(404);
        }
    }

    public function delete_category(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $category = GalleryCategory::find($request->id);
        if(isset($category)){
            Log::debug("Deleting cat #".$category->id);
            $pictures = GalleryContent::where('category_id', $category->id)->get();
            foreach ($pictures as $picture) {
                Log::debug("Deleting imagen #".$picture->id);
                //Check if previous existed
                $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/gallery_content/";
                if(File::exists($destinationPath.$picture->file_name) && isset($picture->file_name)){
                    File::delete($destinationPath.$picture->file_name);
                    Log::debug("Theoretically Deleted, checking deletion...");
                    if(File::exists($destinationPath.$picture->file_name)){
                        Log::debug("Shit, It didnt work");
                    }else{
                        $picture->delete();
                        Log::debug("Succesfully Deleted");
                    }
                }
            }
            $category->delete();
            return response()->json(['status' => 'killed cat']);
        }else{
            abort(404);
        }
    }

    public function save_category(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            'cat_title'=> 'required|string|max:255',
            'cat_identifier'=> 'required|string|max:255',
            'cat_description'=> 'string|max:255',
            ]);
        $category = GalleryCategory::find($request->id);
        if(isset($category)){
            Log::debug("modifying cat #".$category->id);
            $category->name = $request->cat_title;
            $category->identifier = $request->cat_identifier;
            $category->description = $request->cat_description;
            $category->save();
            return response()->json(['status' => 'saved cat']);
        }else{
            abort(404);
        }
    }

    public function get_content(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $content = StaticContent::find($request->id);
        if(isset($content)){
            return response()->json(['content' => $content->content, 'contentType' => $content->content_type]);
        }else{
            abort(404);
        }
    }

    public function blog_dashboard(){
        return View('admin.blog_dashboard');
    }

    public function blog_info(){
        return View('admin.blog_info');
    }

    public function blog_post_editor($identificador = null){

        if(isset($identificador)){
            $post = BlogPost::where('name_identifier', $identificador)->first();
            Log::debug("Editando");
            if(isset($post)){
                $tags = array();
                $has_tags = HasBlogTag::where('post_id', $post->id)->orderBy('id', 'desc')->get();
                foreach ($has_tags as $has_tag) {
                    Log::debug($has_tag);
                    $tag = BlogTag::find($has_tag->tag_id);
                    if(isset($tag)){
                        array_push($tags, $tag->name);
                    }
                }
                Log::debug($tags);
                return view('admin.blog_post_editor', ['post' => $post, 'tags'=> $tags]);
            }
        }else{
            return view('admin.blog_post_editor');
        }
    }

    public function blog_category($cat_identifier){
        $category = BlogCategory::where('name_identifier', $cat_identifier)->first();
        if(isset($category)){
            $posts = BlogPost::where('status', 'approved_available')->where('category_id', $category->id)->orderBy('id', 'desc')->paginate(9);
            $categories = BlogCategory::all();
            return view('admin.blog_category', ['paginated_posts' => $posts, 'show_category' => $category, 'categories' => $categories]);
        }else{
            abort(404);
        }
    }

    public function blog_post($cat_identifier = "loner_post", $post_identifier){
        if($cat_identifier != "loner_post"){
            $category = BlogCategory::where('name_identifier', $cat_identifier)->first();
            $post = BlogPost::where('name_identifier', $post_identifier)->first();
            if(isset($post)){
                if(!isset($category)){
                    Log::debug("Acceso a Post Invalido, No cat named ".$cat_identifier);
                }elseif($post->category_id != $category->id){
                    Log::debug("Acceso a Post Invalido, Not the same cat ");
                    $category = BlogCategory::find($post->category_id);
                    if(isset($category)){
                        return redirect('Mr_Administrator/BlogMan/'.$category->name_identifier.'/'.$post_identifier);
                    }else{
                        return redirect('Mr_Administrator/BlogMan/loner_post/'.$post_identifier);
                    }
                }else{
                    $other_posts = BlogPost::where('category_id', $category->id)->where('id', '!=', $post->id)->get();
                    $post_link = url('blog/'.$category->name_identifier.'/'.$post->name_identifier);
                }
                Log::debug("Post en cat: ".$category->name);
                return view('admin.blog_post', ['post' => $post, 'post_link' => $post_link, 'other_posts' => $other_posts, 'in_cat' => $category]);
            }else{
                Log::debug($post_identifier.'@'.$cat_identifier);
                abort(404);
            }
        }else{
            $post = BlogPost::where('name_identifier', $post_identifier)->first();
            if(isset($post)){
                $other_posts = BlogPost::where('id', '!=0', $post->id)->whereNull('category_id')->orWhere('category_id', 0)->get();
                $post_link = url('blog/loner_post/'.$post->name_identifier);
                Log::debug("Loner Post");
                return view('admin.blog_post', ['post' => $post, 'post_link' => $post_link, 'other_posts' => $other_posts]);
            }else{
                Log::debug($post_identifier.'@loner');
                abort(404);
            }
        }
    }

    public function enableBlogger(Request $request){
        $this->validate($request,[
            'id'=> 'integer|required',
            ]);
        $usuario = User::select('id', 'name', 'surname', 'email')->find($request->id);
        if(Blogger::where('user_id', $request->id)->exists()){
            $status = "habilitado";
        }else{
            $status = "deshabilitado";
        }
        return Response::json(['usuario'=> $usuario, 'estado'=>$status]);
    }
    public function changeEnableBlogger(Request $request){
        $this->validate($request,[
            'id'=> 'integer|required',
            ]);
        $usuario = User::select('name', 'surname', 'email')->find($request->id);
        if($blogger = Blogger::where('user_id', $request->id)->exists()){
            $blogger = Blogger::where('user_id', $request->id)->first();
            $action_performed = "deshabilitado";
            DB::table('blog_posts')
                        ->where('blogger_id', $blogger->id)
                        ->update(['blogger_id' => 1]);
            $blogger->delete();
        }else{
            $blogger = new Blogger;
            $blogger->name = $usuario->name;
            $blogger->name_identifier = clean_url($usuario->name);
            $blogger->user_id = $request->id;
            $action_performed = "habilitado";
            $blogger->save();
        }
        return $action_performed;
    }


    public function blog_getCats(){
        $cats = BlogCategory::select(['name', 'id'])->where('id', '>', 0)->get();
        return response()->json(['cats' => $cats]);
    }

    public function blog_getTags(){
        $tags = BlogTag::select(['name', 'id'])->where('id', '>', 0)->get();
        return response()->json(['tags' => $tags]);
    }

    public function blog_getCat(Request $request){
        $this->validate($request,[
            'id'=> 'integer|required',
            ]);
        $category = BlogCategory::find($request->id);
        if(isset($category)){
            return response()->json(['category' => $category]);
        }
    }

    public function blog_deleteCat(Request $request){
        $this->validate($request,[
            'id'=> 'integer|required',
            ]);
        $category = BlogCategory::find($request->id);
        if(isset($category)){
            DB::table('blog_posts')
                        ->where('category_id', $category->id)
                        ->update(['category_id' => null]);
            $category->delete();
            return response()->json(['status' => "ok"]);
        }
    }

    public function blog_getPost(Request $request){
        $this->validate($request,[
            'id'=> 'integer|required',
            ]);
        $post = BlogPost::find($request->id);
        $cats = BlogCategory::select(['name', 'id'])->where('id', '>', 0)->get();
        if(isset($post)){
            return response()->json(['post' => $post, 'cats' => $cats]);
        }
    }


    public function blog_saveCat(Request $request){
        if(isset($request->id)){
            $category = BlogCategory::find($request->id);
            if(isset($category)){
                if($category->name_identifier == $request->identificador){
                    //Son iguales, no validar unico
                    $this->validate($request,[
                        'id'=> 'integer|required',
                        'cat_titulo'=> 'required|string',
                        'cat_identificador'=> 'required|string',
                        'cat_descripcion'=> 'string',
                        'cat_content'=> 'required|string',
                        'cat_main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                        ]);
                }else{
                    //Identifier cambio, Validar que sea unico
                    $this->validate($request,[
                        'id'=> 'integer|required',
                        'cat_titulo'=> 'required|string',
                        'cat_identificador'=> 'required|string|unique:blog_categories,name_identifier',
                        'cat_descripcion'=> 'string',
                        'cat_content'=> 'required|string',
                        'cat_main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                        ]);
                    $category->name_identifier = $request->cat_identificador;
                }
            }elseif($request->id == -1){
                //Nuevo Validar que sea unico
                $this->validate($request,[
                        'id'=> 'integer|required',
                        'cat_titulo'=> 'required|string',
                        'cat_identificador'=> 'required|string|unique:blog_categories,name_identifier',
                        'cat_descripcion'=> 'string',
                        'cat_content'=> 'required|string',
                        'cat_main_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                        ]);
                $category = new BlogCategory;
                $category->name_identifier = $request->cat_identificador;
            }else{
                abort(500); //Nuevo sin que sea nuevo wtf?
            }
            $category->name = $request->cat_titulo;
            $category->description = $request->cat_descripcion;
            $category->content = $request->cat_content;
            if ($request->hasFile('file')) {
                //Check if previous existed
                $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/blog42_content/uploads/";
                if(isset($category->main_image) && File::exists($destinationPath.$category->main_image)){
                    File::delete($destinationPath.$category->main_image);
                    Log::debug("Previous Img Deleted, checking deletion...");
                    if(File::exists($destinationPath.$category->main_image)){
                        Log::debug("Shit, It didnt work");
                    }else{
                        Log::debug("Succesfully Deleted");
                    }
                }
                $imageName = 'cat_'.$category->name_identifier.'.'.$request->file->getClientOriginalExtension();
                $request->file->move($destinationPath, $imageName);
                $category->main_image = $imageName;
            }
            $category->save();
        }else{
            abort(500);
        }
        if(isset($category)){
            if(isset($category->main_image)){
                $catDisplay = '<img src="/blog42_content/uploads/'.$category->main_image.'" class="media-object rounded-corner">';
            }else{
                $catDisplay = '<i class="fa fa-th-list big-icon" aria-hidden="true"></i>';
            }
            return Response::json(['category'=> $category, 'catDisplay'=> $catDisplay]);
        }
    }

    public function search_user(Request $request){
        $this->validate($request,[
            'search_str'=> 'string|required',
            ]);
        $users = DB::table('users')
                        ->select('id', 'name', 'surname', 'email')
                        ->where('name', 'LIKE', '%'.$request->search_str.'%')
                        ->orWhere('surname', 'LIKE', '%'.$request->search_str.'%')
                        ->orWhere('email', 'LIKE', '%'.$request->search_str.'%')
                        ->get();
        if(isset($users)){
            $cuenta = $users->count();
        }else{
            $cuenta = 0;
        }
        if($cuenta > 0){return Response::json(['search_results'=> $users]);}
        return -1;
    }

    public function blog_upload_image(Request $request){
        $this->validate($request,[
            'alt'=> 'string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);
        if ($request->hasFile('file')) {
            $media = new BlogMedia;
            $imageName = Carbon::now()->format('jmy_His').(isset($request->alt) ? clean_url($request->alt) : '').'.'.$request->file->getClientOriginalExtension();
            $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/blog42_content/uploads/";
            $request->file->move($destinationPath, $imageName);
            $media->file_name = $imageName;
            $media->alt = $request->alt;
            $media->save();
            $count = BlogMedia::all()->count();
            return response()->json(['img_id' => $media->id, 'img_link' => '/blog42_content/uploads/'.$imageName, 'img_alt' => $media->alt, 'num_images' => $count]);
        }else{
            abort(500);
        }
    }

    public function blog_insert_image(Request $request){
        $this->validate($request,[
            'id'=> 'required|integer',
            ]);
        $image = BlogMedia::find($request->id);
        if(isset($image)){
            return response()->json(['img_id' => $image->id, 'img_link' => '/blog42_content/uploads/'.$image->file_name, 'img_alt' => $image->alt]);
        }else{
            abort(404);
        }
    }

    public function blog_load_more_images(Request $request){
        $this->validate($request,[
            'lot'=> 'required|integer',
            'type'=> 'required|integer'
        ]);
        $current_lot = $request->lot;
        $offset = ($request->type == -1 ? ($request->lot - 1) : $request->lot + 1 ) * 8;
        $images = BlogMedia::where('file_name', '!=', '')->orderBy('created_at', 'desc')->offset($offset)->limit(8)->get();
        $more_available = false;
        $less_available = true;
        if($images->count() > 0){
            if($request->type == 1){
                $current_lot++;
            }else{
                $current_lot--;
            }
        }
        $nxt_offset = ($current_lot + 1)*8;
        $available_images = BlogMedia::where('file_name', '!=', '')->orderBy('created_at', 'desc')->offset($nxt_offset)->limit(8)->get();
        if($available_images->count() > 0){
            $more_available = true;
        }
        if($current_lot < 0){
            $current_lot = 0;
        }
        if($current_lot == 0){
            $less_available = false;
        }
        return response()->json(['images' => $images, 'current_lot' => $current_lot, 'less_available' => $less_available, 'more_available' => $more_available]);
    }

    public function blog_savePost(Request $request){
        Log::debug($request);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            if($post->name_identifier == $request->identificador){
                //Son iguales, no validar unico
                $this->validate($request,[
                    'id'=> 'required|integer',
                    'titulo'=> 'required|string',
                    'category'=> 'required|string',
                    'other_category'=> 'nullable|string',
                    'identificador'=> 'required|string',
                    'descripcion'=> 'string',
                    'contenido'=> 'required|string',
                    'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                    'header_type' => 'string',
                    'header_data' => 'nullable|string',
                    ]);
            }else{
                //Identifier cambio, Validar que sea unico
                $this->validate($request,[
                    'id'=> 'required|integer',
                    'titulo'=> 'required|string',
                    'category'=> 'required|string',
                    'other_category'=> 'nullable|string',
                    'identificador'=> 'required|string|unique:blog_posts,name_identifier',
                    'descripcion'=> 'string',
                    'contenido'=> 'required|string',
                    'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                    'header_type' => 'string',
                    'header_data' => 'nullable|string',
                    ]);
                $post->name_identifier = $request->identificador;
            }
        }elseif($request->id == -1){
            //Nuevo Validar que sea unico
            $this->validate($request,[
                    'id'=> 'required|integer',
                    'titulo'=> 'required|string',
                    'category'=> 'required|string',
                    'other_category'=> 'nullable|string',
                    'identificador'=> 'required|string|unique:blog_posts,name_identifier',
                    'descripcion'=> 'string',
                    'contenido'=> 'required|string',
                    'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                    'header_type' => 'string',
                    'header_data' => 'nullable|string',
                    ]);
            $post = new BlogPost;
            $post->name_identifier = $request->identificador;
        }else{
            abort(500); //Nuevo sin que sea nuevo wtf?
        }
        $user = Auth::user();
        $blogger = Blogger::where('user_id', $user->id)->first();
        if(isset($blogger)){
            if($request->id != -1){
                $post = BlogPost::find($request->id);
                if($post->blogger_id != $blogger->id && $user->level < 16){
                    return response()->json(['error' => 'Fallo en credenciales de Blogger']);
                }
            }else{
                $post = new BlogPost;
                $blogger->increment('total_posts');
                $blogger->save();
                $total_posts = BlogStatus::where('name_identifier', 'total_posts')->first();
                $total_posts->increment('int_content');
                $total_posts->save();
            }
            if($request->category == "Otra"){
                if(isset($request->other_category)){
                    if(strlen($request->other_category) > 0){
                        $category = BlogCategory::where('name_identifier', clean_url($request->other_category))->orWhere('name_identifier', $request->other_category)->first();
                        if(!isset($category)){
                            //Nueva Categoria
                            $category = new BlogCategory;
                            $category->name = $request->other_category;
                            $category->name_identifier = clean_url($category->name);
                            $category->total_posts = 1;
                            $category->save();
                        }
                        $post->category_id = $category->id;
                    }
                    else{/*Sin categoria*/}
                }else{/*Sin categoria*/}
            }else{
                //Categoria Existente
                $category = BlogCategory::find($request->category);
                $post->category_id = $category->id;
            }
            $post->blogger_id = $blogger->id;
            $post->name = $request->titulo;
            $post->name_identifier = clean_url($request->identificador);
            $post->description = $request->descripcion;
            $post->content = $request->contenido;
            if(isset($request->header_type)){
                $post->header_type = $request->header_type;
            }else{
                if(!isset($post->header_type)){
                    $post->header_type = 'image';
                }
            }
            $post->header_data = $request->header_data;
            $post->status = 'waiting_approval';
            if ($request->hasFile('file')) {
                $imageName = $post->name_identifier.'.'.$request->file->getClientOriginalExtension();
                $destinationPath= "/home/".env('APP_USER', 'app')."/app/storage/app/public/blog42_content/uploads/";
                $request->file->move($destinationPath, $imageName);
                $post->main_image = $imageName;
            }
            $post->save();
            if($request->id != -1 && isset($category)){
                $category->total_posts = BlogPost::where('category_id', $category->id)->where('status', 'approved_available')->count();
                $category->save();
            }
            DB::table('has_blog_tags')
                        ->where('post_id', $post->id)
                        ->delete();
            if(isset($request->tags)){
                $tag_array = explode(',', $request->tags);
                foreach ($tag_array as $tag) {
                    Log::debug($tag);
                    $db_tag = BlogTag::where('name', $tag)->first();
                    if(!isset($db_tag)){
                        $db_tag = new BlogTag;
                        $db_tag->name = $tag;
                    }
                    $db_tag->increment('total_posts');
                    $db_tag->save();
                    $has_tag = HasBlogTag::where('tag_id', $db_tag->id)->where('post_id', $post->id)->first();
                    if(!isset($has_tag)){
                        $has_tag = new HasBlogTag;
                        $has_tag->post_id = $post->id;
                        $has_tag->tag_id = $db_tag->id;
                        $has_tag->save();
                    }
                }
            }
            if(isset($category)){
                $post_link = url('blog/'.$category->name_identifier.'/'.$post->name_identifier);
            }else{
                $post_link = url('blog/loner_post/'.$post->name_identifier);
            }
            $fecha = $post->created_at.' ('.$post->created_at->diffForHumans().')';
            return response()->json(['post' => make_post_row($post), 'post_id' => $post->id, 'saved_post' => $post, 'post_link'=> $post_link, 'blogger' => $blogger, 'fecha' => $fecha]);
        }else{
            return response()->json(['error' => 'Fallo en credenciales de Blogger']);
        }
    }

    public function approvePost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            ]);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            $post->status = "approved_available";
            $post->notes = $post->notes."<br>Aprovado por: ".Auth::user()->name;
            $post->save();
            return(make_post_row($post));
        }else{
            return response()->json(['error' => 'No se encontro el post']);
        }
    }

    public function enablePost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            ]);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            if($post->status == 'approved_unavailable'){
                $post->status = "approved_available";
                $post->notes = $post->notes."<br>Habilitado por: ".Auth::user()->name;
                $post->save();
                return(make_post_row($post));
            }
        }else{
            return response()->json(['error' => 'No se encontro el post']);
        }
    }

    public function disablePost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            ]);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            $post->status = "approved_unavailable";
            $post->notes = $post->notes."<br>Deshabilitado por: ".Auth::user()->name;
            $post->save();
            return(make_post_row($post));
        }else{
            return response()->json(['error' => 'No se encontro el post']);
        }
    }

    public function destacarPost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            'position'=> 'required|integer',
            ]);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            if(null == BlogDestacado::find($request->position)){
                $destacado = new BlogDestacado;
                $destacado->id = $request->position;
            }else{
                $destacado = BlogDestacado::find($request->position);
            }
            $destacado->post_id = $request->id;
            $destacado->save();
            return response()->json(['post' => make_post_row($post), 'destacados'=>make_destacados_row()]);
        }else{
            return response()->json(['error' => 'No se encontro el post']);
        }
    }


    public function desdestacarPost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            ]);
        $destacado = BlogDestacado::where('post_id', $request->id)->first();
        $post = BlogPost::find($request->id);
        if(isset($post) && isset($destacado)){
            $destacado->delete();
            return response()->json(['post' => make_post_row($post), 'destacados'=>make_destacados_row()]);
        }else{
            return response()->json(['error' => 'No se encontro el destacado']);
        }
    }

    public function deletePost(Request $request){
        Log::debug($request);
        $this->validate($request, [
            'id'=> 'required|integer',
            ]);
        $post = BlogPost::find($request->id);
        if(isset($post)){
            $destacado = BlogDestacado::where('post_id', $request->id)->first();
            $blogger = Blogger::find($post->blogger_id);
            $category = BlogCategory::find($post->category_id);
            $has_tag = HasBlogTag::where('post_id', $request->id)->first();
            if(isset($destacado)){
                $destacado->delete();
            }
            if(isset($blogger)){
                if($blogger->total_posts > 0) $blogger->decrement('total_posts');
            }
            if(isset($category)){
                if($category->total_posts > 0) $category->decrement('total_posts');
            }
            if(isset($has_tag)){
                $has_tag->delete();
            }
            $post->delete();
            return response()->json(['post' => make_post_row($post), 'destacados'=>make_destacados_row()]);
        }else{
            return response()->json(['error' => 'No se encontro el post']);
        }
    }

    public function blog_get_blog_views(Request $request){
        $this->validate($request, [
            'type' => 'required|string',
            'id'=> 'integer',
        ]);
        switch ($request->type) {
            case 'general':
                if(isset($request->start_period)){
                    if(isset($request->end_period)){
                        $end_period = DateTime::createFromFormat('Y-m-d', $request->end_period);
                        $start_period = DateTime::createFromFormat('Y-m-d', $request->start_period);
                        $views_data = BlogViewsHistory::where('type', 'blog')->where('identifier', '1')->where('fecha', '>=', $start_period)->where('fecha', '<=', $end_period)->orderBy('fecha', 'asc')->get();
                    }else{
                        $start_period = DateTime::createFromFormat('Y-m-d', $request->start_period);
                        $views_data = BlogViewsHistory::where('type', 'blog')->where('identifier', '1')->where('fecha', '>=', $start_period)->orderBy('fecha', 'asc')->get();
                    }

                }else{
                    $views_data = BlogViewsHistory::where('type', 'blog')->where('identifier', '1')->orderBy('fecha', 'asc')->get();
                }
                break;

            default:
                # code...
                break;
        }
        $response = array();
        foreach ($views_data as $view) {
            array_push($response, array('x' => $view->created_at->format('Y-m-d'), 'y' => $view->views));
        }
        $response_json = json_encode($response);
        return $response_json;
    }
}
