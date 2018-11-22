<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\BlogPost;
use App\BlogStatus;

use Auth;
use Log;

class BlogComposer
{
	public function compose(View $view)
	{
		$sidebar_title = BlogStatus::where('name_identifier', 'sidebar_title')->first()->str_content;
		$sidebar_message = BlogStatus::where('name_identifier', 'sidebar_message')->first()->str_content;
		$recent_posts = BlogPost::where('status', 'approved_available')->orderBy('created_at', 'desc')->limit(3)->get();
		$popular_posts = BlogPost::where('status', 'approved_available')->orderBy('total_views', 'desc')->limit(3)->get();
		$view->with(compact('recent_posts', 'sidebar_title', 'sidebar_message', 'popular_posts'));
	}
}