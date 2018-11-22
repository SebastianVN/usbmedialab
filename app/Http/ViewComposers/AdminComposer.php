<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\ContactMessage;
use App\User;

use Auth;
use Log;

class AdminComposer
{
	public function compose(View $view)
	{
		$messages = ContactMessage::all();
		$unread_messages = ContactMessage::where('read', '0')->count();
		$total_messages = $messages->count();
		$user=Auth::user();
		$users_count = User::all()->count();
		if($user->level >= 16){
			$view->with(compact('user', 'messages', 'unread_messages', 'total_messages', 'users_count'));
		}
	}
}