<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\StaticContent;
use App\BlogPost;
use App\StaticPage;
use App\BlogStatus;
use App\Clase;
use Auth;
use Log;
use App;

class QuienesSomosComposer
{
	public function compose(View $view)
	{
		$locale = App::getLocale();
		$page = StaticPage::where('identifier','about')->first();
		$paragraph_1 = StaticContent::where('page_id',$page->id)->where('lang',$locale)->where('identifier','paragraph_1')->first()->content;
		$paragraph_2 = StaticContent::where('page_id',$page->id)->where('lang',$locale)->where('identifier','paragraph_2')->first()->content;
		$paragraph_3 = StaticContent::where('page_id',$page->id)->where('lang',$locale)->where('identifier','paragraph_3')->first()->content;
		$paragraph_4 = StaticContent::where('page_id',$page->id)->where('lang',$locale)->where('identifier','paragraph_4')->first()->content;
		$imagen_1 = StaticContent::where('page_id',$page->id)->where('identifier','imagen_1')->first()->content;
		$imagen_2 = StaticContent::where('page_id',$page->id)->where('identifier','imagen_2')->first()->content;
		$imagen_3 = StaticContent::where('page_id',$page->id)->where('identifier','imagen_3')->first()->content;
		Log::debug($paragraph_1);
		$view->with(compact('paragraph_1', 'paragraph_2','paragraph_3','paragraph_4','imagen_1','imagen_2','imagen_3'));
	} 	
}