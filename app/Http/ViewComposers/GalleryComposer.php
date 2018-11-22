<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\StaticPage;
use App\StaticContent;
use App\GalleryContent;
use App\GalleryCategory;

use App;

class GalleryComposer
{
	public function compose(View $view)
	{
		$locale = App::getLocale();
		$page = StaticPage::where('identifier', 'gallery')->first();
		$main_title = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'page_title')->first();
		$categories = GalleryCategory::all();
		$view->with(compact('page', 'main_title', 'categories'));
	}
}