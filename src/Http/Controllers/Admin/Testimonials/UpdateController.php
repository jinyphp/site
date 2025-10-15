<?php

namespace Jiny\Site\Http\Controllers\Admin\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 업데이트 컨트롤러
 */
class UpdateController extends Controller
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

        // Handle toggle field requests (AJAX)
        if ($request->has('toggle_field')) {
            return $this->handleToggleField($request, $id, $testimonial);
        }

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

        $validated['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update($validated);

        return redirect()
            ->route($this->config['redirect_route'])
            ->with('success', 'Testimonial이 성공적으로 업데이트되었습니다.');
    }

    /**
     * Handle toggle field requests (AJAX)
     */
    protected function handleToggleField(Request $request, $id, $testimonial)
    {
        $field = $request->input('toggle_field');
        $allowedFields = ['enable', 'featured', 'verified'];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Invalid field'], 400);
        }

        $currentValue = $testimonial->{$field};
        $newValue = !$currentValue;

        DB::table($this->config['table'])
            ->where('id', $id)
            ->update([
                $field => $newValue,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => '상태가 성공적으로 변경되었습니다.',
            'field' => $field,
            'new_value' => $newValue
        ]);
    }
}