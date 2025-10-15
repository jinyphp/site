<?php
namespace Jiny\Site\Http\Controllers\Admin\Notifications;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $notifications = DB::table('user_notifications')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('jiny-site::admin.notifications.index', [
            'notifications' => $notifications,
            'config' => ['title' => 'Notification 관리', 'subtitle' => '알림을 관리합니다.'],
        ]);
    }
}
