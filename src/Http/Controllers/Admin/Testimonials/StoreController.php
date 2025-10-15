<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_testimonials',
            'redirect_route' => 'admin.site.testimonials.index',
        ];
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,service',
            'item_id' => 'required|integer',
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'avatar' => 'nullable|string|max:500',
            'headline' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'featured' => 'boolean',
            'verified' => 'boolean',
            'enable' => 'boolean',
        ]);

        // Validate item exists
        if ($validated['type'] === 'product') {
            $exists = DB::table('site_products')
                ->where('id', $validated['item_id'])
                ->whereNull('deleted_at')
                ->exists();
        } else {
            $exists = DB::table('site_services')
                ->where('id', $validated['item_id'])
                ->whereNull('deleted_at')
                ->exists();
        }

        if (!$exists) {
            return back()->withErrors(['item_id' => 'Selected item does not exist.']);
        }

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table($this->config['table'])->insertGetId($validated);

        // Redirect to specific testimonials if came from product/service page
        if ($request->filled('return_to') && $request->get('return_to') === 'item') {
            return redirect()
                ->route('admin.site.testimonials.index', ['type' => $validated['type'], 'itemId' => $validated['item_id']])
                ->with('success', 'Testimonial이 성공적으로 생성되었습니다.');
        }

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Testimonial이 성공적으로 생성되었습니다.');
    }
}