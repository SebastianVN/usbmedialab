<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\StaticPage;
use App\StaticContent;

use Auth;
use Log;
use App;

class ProfesoresComposer
{
	public function compose(View $view)
	{
		$locale = App::getLocale();
		$page = StaticPage::where('identifier', 'staff')->first();
		switch ($locale) {
			case 'es':
				$titulo = $page->es_title;
				break;
			default:
				$titulo = $page->en_title;
				break;
		}
		$page_head = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'page_head')->first()->content;
		$bg_img_1 = StaticContent::where('page_id',$page->id)->where('lang', 'img')->where('identifier','bg_img_1')->first()->content;
		$widget_1 = StaticContent::where('page_id',$page->id)->where('lang', 'code')->where('identifier','widget_1')->first()->content;
		$view->with(compact('titulo', 'page', 'page_head', 'bg_img_1', 'widget_1'));
	}
}