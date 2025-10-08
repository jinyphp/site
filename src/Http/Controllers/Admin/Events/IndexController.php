<?php
namespace Jiny\Site\Http\Controllers\Admin\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $events = DB::table('site_events')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('jiny-site::admin.events.index', [
            'events' => $events,
            'config' => ['title' => 'Event 관리', 'subtitle' => '이벤트를 관리합니다.'],
        ]);
    }
}
