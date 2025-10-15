<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Location 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('/admin/cms/about/location/{id}') → DestroyController::__invoke()
 */
class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $location = DB::table('site_location')->find($id);

        if (!$location) {
            return redirect()->route('admin.cms.about.location.index')
                ->with('error', '해당 Location을 찾을 수 없습니다.');
        }

        DB::table('site_location')->where('id', $id)->delete();

        return redirect()->route('admin.cms.about.location.index')
            ->with('success', 'Location이 성공적으로 삭제되었습니다.');
    }
}