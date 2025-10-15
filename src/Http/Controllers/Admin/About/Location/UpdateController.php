<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Location 업데이트 컨트롤러
 *
 * 진입 경로:
 * Route::put('/admin/cms/about/location/{id}') → UpdateController::__invoke()
 */
class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $location = DB::table('site_location')->find($id);

        if (!$location) {
            return redirect()->route('admin.cms.about.location.index')
                ->with('error', '해당 Location을 찾을 수 없습니다.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['updated_at'] = now();

        DB::table('site_location')->where('id', $id)->update($data);

        return redirect()->route('admin.cms.about.location.index')
            ->with('success', 'Location이 성공적으로 수정되었습니다.');
    }
}