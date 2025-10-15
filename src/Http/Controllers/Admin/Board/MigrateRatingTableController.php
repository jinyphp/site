<?php

namespace Jiny\Site\Http\Controllers\Admin\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 기존 게시판에 평가 테이블 추가 마이그레이션 컨트롤러
 */
class MigrateRatingTableController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // 모든 게시판 조회
            $boards = DB::table('site_board')->get();
            $createdTables = [];
            $skippedTables = [];

            foreach ($boards as $board) {
                if (isset($board->code) && $board->code) {
                    $ratingTableName = "site_board_" . $board->code . "_ratings";

                    // 이미 존재하는지 확인
                    if (Schema::hasTable($ratingTableName)) {
                        $skippedTables[] = $ratingTableName;
                        continue;
                    }

                    // 평가 테이블 생성
                    Schema::create($ratingTableName, function (Blueprint $table) {
                        $table->id();
                        $table->timestamps();

                        // 게시글 연결
                        $table->unsignedBigInteger('post_id'); // 게시글 ID
                        $table->string('post_uuid')->nullable(); // 게시글 UUID (샤딩 지원)

                        // 작성자 정보
                        $table->unsignedBigInteger('user_id')->nullable(); // 회원 ID
                        $table->string('user_uuid')->nullable(); // 회원 UUID (샤딩 지원)
                        $table->string('name')->nullable(); // 작성자명
                        $table->string('email')->nullable(); // 작성자 이메일
                        $table->ipAddress('ip_address')->nullable(); // IP 주소 (비회원 중복 방지)

                        // 평가 유형
                        $table->enum('type', ['like', 'rating']); // 좋아요 또는 별점

                        // 평가 값
                        $table->boolean('is_like')->default(false); // 좋아요 여부 (type='like'일 때)
                        $table->unsignedTinyInteger('rating')->nullable(); // 별점 (1-5, type='rating'일 때)

                        // 샤딩 지원
                        $table->unsignedTinyInteger('shard_id')->nullable();

                        // 인덱스
                        $table->index(['post_id', 'type', 'created_at']);
                        $table->index(['post_uuid', 'shard_id']);
                        $table->index(['user_id', 'type']);
                        $table->index(['user_uuid', 'shard_id']);
                        $table->index(['ip_address', 'type']); // 비회원 중복 체크용

                        // 유니크 제약 조건 (사용자당 게시글당 평가 유형당 하나씩만)
                        $table->unique(['post_id', 'user_id', 'type'], 'unique_user_post_rating');
                        $table->unique(['post_id', 'ip_address', 'type'], 'unique_ip_post_rating');
                    });

                    $createdTables[] = $ratingTableName;
                }
            }

            $message = [];
            if (count($createdTables) > 0) {
                $message[] = count($createdTables) . "개 평가 테이블이 생성되었습니다: " . implode(', ', $createdTables);
            }
            if (count($skippedTables) > 0) {
                $message[] = count($skippedTables) . "개 테이블은 이미 존재합니다: " . implode(', ', $skippedTables);
            }

            if (empty($message)) {
                $message[] = "처리할 게시판이 없습니다.";
            }

            return response()->json([
                'success' => true,
                'message' => implode("\n", $message),
                'created' => count($createdTables),
                'skipped' => count($skippedTables),
            ]);

        } catch (\Exception $e) {
            \Log::error('Rating table migration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => '평가 테이블 생성 중 오류가 발생했습니다: ' . $e->getMessage(),
            ], 500);
        }
    }
}