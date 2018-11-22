<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\StaticPage;
use App\StaticContent;

use Auth;
use Log;
use App;

class AboutComposer
{
	public function compose(View $view)
	{
		$locale = App::getLocale();
		$page = StaticPage::where('identifier', 'about')->first();
		$main_title = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'page_title')->first();
		$header_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'header_1')->first();
		$text_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'text_1')->first();
		$header_2 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'header_2')->first();
		$text_2 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'text_2')->first();
		$header_3 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'header_3')->first();
		$text_3 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'text_3')->first();
		$header_4 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'header_4')->first();
		$text_4 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'text_4')->first();
		$quote_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'quote_1')->first();
		$btn_text_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_1')->first();
		$btn_link_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_link_1')->first();
		$img_header = StaticContent::where('page_id', $page->id)->where('identifier', 'img_header')->first();
		$img_1 = StaticContent::where('page_id', $page->id)->where('identifier', 'img_1')->first();
		$img_2 = StaticContent::where('page_id', $page->id)->where('identifier', 'img_2')->first();
		$img_3 = StaticContent::where('page_id', $page->id)->where('identifier', 'img_3')->first();
		$view->with(compact('page', 'main_title', 'header_1', 'text_1', 'header_2', 'text_2', 'header_3', 'text_3', 'header_4', 'text_4', 'quote_1', 'btn_text_1', 'btn_link_1', 'img_header', 'img_1', 'img_2', 'img_3'));
	}
}