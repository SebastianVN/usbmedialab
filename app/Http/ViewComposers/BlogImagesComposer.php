<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\BlogMedia;

use Auth;
use Log;

class BlogImagesComposer
{
	public function compose(View $view)
	{
		$images = BlogMedia::where('file_name', '!=', '')->orderBy('created_at', 'desc')->limit(8)->get();
		$view->with(compact('images'));
	}
}