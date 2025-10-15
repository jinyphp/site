<?php

namespace Jiny\Site\Http\Controllers\Site\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Frontend Testimonials 저장 컨트롤러
 */
class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,service',
            'item_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'headline' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Validate item exists
        if ($validated['type'] === 'product') {
            $exists = DB::table('site_products')
                ->where('id', $validated['item_id'])
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->exists();
        } else {
            $exists = DB::table('site_services')
                ->where('id', $validated['item_id'])
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->exists();
        }

        if (!$exists) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Create testimonial (auto-approved)
        $validated['user_id'] = auth()->id();
        $validated['enable'] = true; // Auto-approved
        $validated['verified'] = false;
        $validated['featured'] = false;
        $validated['likes_count'] = 0;
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table('site_testimonials')->insertGetId($validated);

        // Get the created testimonial with basic info
        $testimonial = DB::table('site_testimonials')
            ->where('id', $id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => '리뷰가 성공적으로 등록되었습니다.',
            'testimonial' => $testimonial
        ]);
    }
}