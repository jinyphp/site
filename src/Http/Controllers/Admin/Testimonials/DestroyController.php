<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_testimonials',
            'redirect_route' => 'admin.site.testimonials.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $testimonial = DB::table($this->config['table'])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$testimonial) {
            return redirect()
                ->route($this->config['redirect_route'])
                ->with('error', 'Testimonial을 찾을 수 없습니다.');
        }

        // Soft delete
        DB::table($this->config['table'])
            ->where('id', $id)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now()
            ]);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Testimonial이 성공적으로 삭제되었습니다.');
    }
}