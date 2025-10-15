<?php

namespace Jiny\Site\Http\Controllers\Site\Testimonials;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Testimonials 좋아요 컨트롤러
 */
class LikeController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $testimonial = DB::table('site_testimonials')
            ->where('id', $id)
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->first();

        if (!$testimonial) {
            return response()->json(['error' => 'Testimonial not found'], 404);
        }

        $userId = auth()->id();
        $ipAddress = $request->ip();

        // Check if already liked
        $existingLike = DB::table('site_testimonial_likes')
            ->where('testimonial_id', $id)
            ->where(function($query) use ($userId, $ipAddress) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('ip_address', $ipAddress);
                }
            })
            ->first();

        if ($existingLike) {
            // Unlike
            DB::table('site_testimonial_likes')
                ->where('id', $existingLike->id)
                ->delete();

            // Decrement likes count
            DB::table('site_testimonials')
                ->where('id', $id)
                ->decrement('likes_count');

            $liked = false;
        } else {
            // Like
            DB::table('site_testimonial_likes')->insert([
                'testimonial_id' => $id,
                'user_id' => $userId,
                'ip_address' => $ipAddress,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment likes count
            DB::table('site_testimonials')
                ->where('id', $id)
                ->increment('likes_count');

            $liked = true;
        }

        // Get updated count
        $likesCount = DB::table('site_testimonials')
            ->where('id', $id)
            ->value('likes_count');

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}