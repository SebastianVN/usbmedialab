<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/index', 'HomeController@index');
Route::get('/animov', 'HomeController@animov');
Route::get('/gamedev', 'HomeController@gamedev');
Route::get('/cabalas', 'HomeController@cabalas');
Route::get('/tecnosoft', 'HomeController@tecnosoft');
Route::get('/solsytec', 'HomeController@solsytec');
Route::get('/tv', 'HomeController@tv');
Route::get('/emisora', 'HomeController@emisora');
Route::get('/eventos', 'HomeController@eventos');
Route::get('/quienes','HomeController@quienes');
Route::get('/concurso', 'HomeController@concurso');
Route::get('/miembros', 'HomeController@miembros');
Route::get('/servicios','HomeController@servicios');
Route::get('/portafolio', 'HomeController@portafolio');
//Enviar Email
Route::resource('mail','EmailController');

//Administrador USB Media Lab
Route::group(['middleware' => 'admin'], function(){
    //Admin42 Update
    
        Route::get('/Mr_Administrator', 'AdminController@dashboard');
    
        //Mensajes
        Route::get('/Mr_Administrator/messages', 'AdminController@messages');
        Route::get('/Mr_Administrator/messages/compose/', 'AdminController@send_message_view');
        Route::post('/Mr_Administrator/messages/view', 'AdminController@view_message');
        Route::post('/Mr_Administrator/messages/unread', 'AdminController@unread_message');
        Route::post('/Mr_Administrator/messages/delete','AdminController@delete_message');
        Route::post('/Mr_Administrator/messages/delete_all','AdminController@delete_all_messages');
        Route::post('/Mr_Administrator/messages/send_message','AdminController@send_message');
        Route::post('/Mr_Administrator/messages/add_all','AdminController@add_all');
        Route::get('/Mr_Administrator/messages/sent/{identifier?}', 'AdminController@sent_messages');
        Route::post('/Mr_Administrator/messages/sent/delete','AdminController@delete_sent');
        Route::post('/Mr_Administrator/messages/subscription','AdminController@subscription');
        Route::post('/Mr_Administrator/messages/subscription/delete','AdminController@subscription_delete');
        //Usuarios
        Route::get('/Mr_Administrator/users', 'AdminController@users');
        Route::get('/Mr_Administrator/users/{userEmail}', 'AdminController@showUser');
        Route::post('/Mr_Administrator/deleteUser', 'AdminController@deleteUser');
        Route::post('/Mr_Administrator/newUser', 'AdminController@newUser');
        Route::post('/Mr_Administrator/search_user', 'AdminController@search_user');
        //Proyectos
        Route::get('/Mr_Administrator/proyectos','AdminController@proyecto');
        //Semilleros
        Route::get('/Mr_Administrator/semilleros','AdminController@semillero');
        //Galeria
        Route::get('/Mr_Administrator/gallery/{category_id?}', 'AdminController@gallery');
        Route::post('/Mr_Administrator/gallery/save_image', 'AdminController@save_image');
        Route::post('/Mr_Administrator/gallery/save_widget', 'AdminController@save_widget');
        Route::post('/Mr_Administrator/gallery/delete_image', 'AdminController@delete_image');
        Route::post('/Mr_Administrator/gallery/feature_image', 'AdminController@feature_image');
        Route::post('/Mr_Administrator/gallery/save_category', 'AdminController@save_category');
        Route::post('/Mr_Administrator/gallery/delete_category', 'AdminController@delete_category');
    
        //Blog
        Route::get('/Mr_Administrator/BlogMan', 'AdminController@blog_dashboard');
        Route::get('/Mr_Administrator/BlogMan/blog_info/', 'AdminController@blog_info');
        Route::get('/Mr_Administrator/BlogMan/post_editor/{identificador?}', 'AdminController@blog_post_editor');
        Route::get('/Mr_Administrator/BlogMan/{cat_identifier}', 'AdminController@blog_category');
        Route::get('/Mr_Administrator/BlogMan/{cat_identifier}/{post_identifier}', 'AdminController@blog_post');
        Route::get('/Mr_Administrator/BlogMan/loner_post/{post_identifier}', 'AdminController@blog_post');
        Route::post('/Mr_Administrator/BlogMan/get_blog_views', 'AdminController@blog_get_blog_views');
        Route::post('/Mr_Administrator/BlogMan/insert_image', 'AdminController@blog_insert_image');
        Route::post('/Mr_Administrator/BlogMan/load_more_images', 'AdminController@blog_load_more_images');
        Route::post('/Mr_Administrator/BlogMan/GetCat', 'AdminController@blog_getCat');
        Route::post('/Mr_Administrator/BlogMan/DeleteCat', 'AdminController@blog_deleteCat');
        Route::post('/Mr_Administrator/BlogMan/GetCats', 'AdminController@blog_getCats');
        Route::post('/Mr_Administrator/BlogMan/GetTags', 'AdminController@blog_getTags');
        Route::post('/Mr_Administrator/BlogMan/SaveCat', 'AdminController@blog_saveCat');
        Route::post('/Mr_Administrator/BlogMan/GetPost', 'AdminController@blog_getPost');
        Route::post('/Mr_Administrator/BlogMan/SavePost', 'AdminController@blog_savePost');
        Route::post('/Mr_Administrator/BlogMan/UploadImage', 'AdminController@blog_upload_image');
        Route::post('/Mr_Administrator/BlogMan/enableBlogger', 'AdminController@enableBlogger');
        Route::post('/Mr_Administrator/BlogMan/changeEnableBlogger', 'AdminController@changeEnableBlogger');
        Route::post('/Mr_Administrator/BlogMan/approvePost', 'AdminController@approvePost');
        Route::post('/Mr_Administrator/BlogMan/deletePost', 'AdminController@deletePost');
        Route::post('/Mr_Administrator/BlogMan/enablePost', 'AdminController@enablePost');
        Route::post('/Mr_Administrator/BlogMan/disablePost', 'AdminController@disablePost');
        Route::post('/Mr_Administrator/BlogMan/destacarPost', 'AdminController@destacarPost');
        Route::post('/Mr_Administrator/BlogMan/desdestacarPost', 'AdminController@desdestacarPost');
    
        //Paginas
        Route::get('/Mr_Administrator/site/reports', 'AdminController@reports');
        Route::get('/Mr_Administrator/site', 'AdminController@site_dashboard');
        Route::get('/Mr_Administrator/site/{identifier}', 'AdminController@site_page');
        Route::post('/Mr_Administrator/site/save_page', 'AdminController@save_page');
        Route::post('/Mr_Administrator/site/save_box','AdminController@save_box');
        Route::post('/Mr_Administrator/site/save_content', 'AdminController@save_content');
        Route::post('/Mr_Administrator/site/get_content', 'AdminController@get_content');
        Route::post('/Mr_Administrator/site/get_content_box', 'AdminController@get_content_box');
    
        Route::post('Mr_Administrator/save_footer', 'AdminController@save_footer');
        Route::post('Mr_Administrator/save_schedule', 'AdminController@save_schedule');
        Route::post('Mr_Administrator/save_social', 'AdminController@save_social');
        Route::post('Mr_Administrator/delete_social', 'AdminController@delete_social');
    });
    Route::group(['middleware' => 'sudo'], function(){

        //SUDO
        Route::get('/Mr_Administrator/sudo','SudoController@sudo');
        Route::get('/Mr_Administrator/sudo/site/{identifier?}','SudoController@sudo_site');
        Route::get('/Mr_Administrator/sudo/system_notification/{id}','SudoController@system_notification');
        Route::post('/Mr_Administrator/enable_user','SudoController@enable_user');
        Route::post('/Mr_Administrator/create_page','SudoController@new_page');
        Route::post('/Mr_Administrator/delete_page', 'SudoController@delete_page');
        Route::post('/Mr_Administrator/disableUser','SudoController@disabled_user');
        Route::post('/Mr_Administrator/edit_page','SudoController@edit_page');
        Route::post('/Mr_Administrator/sudo/get_content','SudoController@get_sudo_content');
        Route::post('/Mr_Administrator/up_box','SudoController@up_box');
        Route::post('/Mr_Administrator/up_content','SudoController@up_content');
        Route::post('/Mr_Administrator/down_box','SudoController@down_box');
        Route::post('/Mr_Administrator/down_content','SudoController@down_content');
        Route::post('/Mr_Administrator/create_content_box','SudoController@new_content_box');
        Route::post('/Mr_Administrator/create_registry','SudoController@new_registry');
        Route::post('/Mr_Administrator/delete_all_page','SudoController@delete_all_page');
        Route::post('/Mr_Administrator/delete_content_box','SudoController@delete_content_box');
        Route::post('/Mr_Administrator/delete_content','SudoController@deleteContent');
        Route::post('/Mr_Administrator/sudo/get_page','SudoController@get_page');
        Route::post('/Mr_Administrator/sudo/order_content_box','SudoController@order_content_box');
        Route::post('/Mr_Administrator/sudo/get_identifier_sudo','SudoController@get_identifier_sudo');
        Route::post('/Mr_Administrator/sudo/save_identifier','SudoController@save_identifier');
        Route::post('/Mr_Administrator/sudo/delete_notification','SudoController@delete_notification');
        Route::post('/Mr_Administrator/sudo/delete_note','SudoController@delete_note');
        Route::post('/Mr_Administrator/sudo/blocked_user','SudoController@blocked_user');
        Route::post('/Mr_Administrator/sudo/unBlocked_user','SudoController@unblocked_user');
        Route::post('/Mr_Administrator/sudo/delete_user','SudoController@delete_user');
      });