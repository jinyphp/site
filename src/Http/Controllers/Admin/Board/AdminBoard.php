<?php
namespace Jiny\Site\Http\Controllers\Admin\Board;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin Board Controller
 *
 * 게시판 설정을 관리하는 컨트롤러입니다.
 */
class AdminBoard extends Controller
{
    /**
     * 테이블명
     */
    protected $table = 'site_board';

    /**
     * 뷰 경로
     */
    protected $viewPath = 'jiny-site::admin.board';

    /**
     * 페이지 설정
     */
    protected $config = [
        'title' => '계시판',
        'subtitle' => '복수의 계시판을 관리합니다.',
    ];

    /**
     * 목록 표시
     */
    public function index(Request $request)
    {
        $rows = DB::table($this->table)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // 각 게시판의 게시글 수와 총 조회수 계산
        foreach ($rows as $row) {
            if (isset($row->code)) {
                $tableName = "site_board_" . $row->code;

                if (Schema::hasTable($tableName)) {
                    // 게시글 수 계산
                    $row->post_count = DB::table($tableName)->count();

                    // DB에 저장된 총 조회수가 있으면 사용, 없으면 실시간 계산
                    if (isset($row->total_views) && $row->total_views > 0) {
                        // DB에 저장된 값 사용
                    } else {
                        // 실시간 계산 후 DB 업데이트
                        $calculatedViews = DB::table($tableName)->sum('click') ?? 0;
                        $row->total_views = $calculatedViews;

                        // DB에 업데이트
                        if ($calculatedViews > 0) {
                            DB::table($this->table)
                                ->where('code', $row->code)
                                ->update(['total_views' => $calculatedViews]);
                        }
                    }
                } else {
                    $row->post_count = 0;
                    $row->total_views = 0;
                }
            } else {
                $row->post_count = 0;
                $row->total_views = 0;
            }
        }

        return view("{$this->viewPath}.list", [
            'rows' => $rows,
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 생성 폼 표시
     */
    public function create()
    {
        return view("{$this->viewPath}.form", [
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 데이터 저장
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // 체크박스 처리
        $data['enable'] = $request->has('enable') ? 1 : 0;

        // 타이틀명 hash코드를 기반으로 신규 테이블을 생성합니다.
        if (isset($data['title']) && $data['title']) {
            $code = md5($data['title'] . date("Y-m-d_H:i:s"));
            $code = substr($code, 0, 7);
            $data['code'] = $code;

            // 게시판 테이블과 코멘트 테이블, 평가 테이블을 생성합니다.
            $this->schemaCreate("site_board_" . $code);
            $this->createCommentTable("site_board_" . $code . "_comments");
            $this->createRatingTable("site_board_" . $code . "_ratings");
        }

        // 타임스탬프 추가
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table($this->table)->insert($data);

        return redirect()->route('admin.cms.board.list')
            ->with('success', '게시판이 생성되었습니다.');
    }

    /**
     * 수정 폼 표시
     */
    public function edit($id)
    {
        $item = DB::table($this->table)->find($id);

        return view("{$this->viewPath}.form", [
            'item' => $item,
            'config' => $this->config,
            'actions' => $this->config,
        ]);
    }

    /**
     * 데이터 수정
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);

        // 체크박스 처리
        $data['enable'] = $request->has('enable') ? 1 : 0;

        // 코드는 변경이 불가능합니다.
        unset($data['code']);

        // 타임스탬프 추가
        $data['updated_at'] = now();

        DB::table($this->table)
            ->where('id', $id)
            ->update($data);

        return redirect()->route('admin.cms.board.list')
            ->with('success', '게시판이 수정되었습니다.');
    }

    /**
     * 데이터 삭제
     */
    public function destroy($id)
    {
        $row = DB::table($this->table)->find($id);

        if ($row && isset($row->code)) {
            // 연결된 게시판 테이블과 코멘트 테이블, 평가 테이블 삭제
            Schema::dropIfExists("site_board_" . $row->code);
            Schema::dropIfExists("site_board_" . $row->code . "_comments");
            Schema::dropIfExists("site_board_" . $row->code . "_ratings");
        }

        DB::table($this->table)->where('id', $id)->delete();

        return redirect()->route('admin.cms.board.list')
            ->with('success', '게시판이 삭제되었습니다.');
    }

    /**
     * 게시판 테이블 스키마 생성
     */
    private function schemaCreate($schema)
    {
        if (Schema::hasTable($schema)) {
            return;
        }

        Schema::create($schema, function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 분류코드
            $table->string('code')->nullable();
            $table->string('slug')->nullable();

            // 작성자 정보
            $table->unsignedBigInteger('user_id')->nullable(); // 회원 ID
            $table->string('user_uuid')->nullable(); // 회원 UUID (샤딩 지원)
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable(); // 비회원일 경우 비밀번호 필요

            // 하위글 구조 (댓글/답글 시스템)
            $table->unsignedBigInteger('parent_id')->nullable(); // 부모 게시글 ID
            $table->string('parent_uuid')->nullable(); // 부모 게시글 UUID (샤딩 지원)
            $table->unsignedTinyInteger('level')->default(0); // 계층 레벨 (0: 원본글, 1: 1단계 답글, ...)

            // post 정보
            $table->string('categories')->nullable();
            $table->string('keyword')->nullable();
            $table->string('tags')->nullable();

            // 제목내용
            $table->string('title')->nullable();
            $table->text('content')->nullable();

            // post 대표 이미지
            $table->string('image')->nullable();

            // 샤딩 지원
            $table->string('uuid')->nullable(); // 게시글 UUID
            $table->unsignedTinyInteger('shard_id')->nullable(); // 샤드 ID

            // 통계
            $table->unsignedBigInteger('click')->default(0); // 조회수
            $table->unsignedBigInteger('like')->default(0); //좋아요
            $table->unsignedBigInteger('rank')->default(0); //랭크

            // 인덱스
            $table->index(['parent_id', 'level', 'created_at']);
            $table->index(['uuid', 'shard_id']);
            $table->index(['user_id']);
            $table->index(['user_uuid', 'shard_id']);
            $table->index(['code', 'created_at']);
        });
    }

    /**
     * 코멘트 테이블 스키마 생성
     */
    private function createCommentTable($tableName)
    {
        if (Schema::hasTable($tableName)) {
            return;
        }

        Schema::create($tableName, function (Blueprint $table) {
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
            $table->string('password')->nullable(); // 비회원일 경우 비밀번호

            // 코멘트 내용 (짧은 글)
            $table->text('content');

            // 샤딩 지원
            $table->unsignedTinyInteger('shard_id')->nullable();

            // 통계
            $table->unsignedBigInteger('like')->default(0); // 좋아요

            // 인덱스
            $table->index(['post_id', 'created_at']);
            $table->index(['post_uuid', 'shard_id']);
            $table->index(['user_id']);
            $table->index(['user_uuid', 'shard_id']);
        });
    }

    /**
     * 평가(좋아요/별점) 테이블 스키마 생성
     */
    private function createRatingTable($tableName)
    {
        if (Schema::hasTable($tableName)) {
            return;
        }

        Schema::create($tableName, function (Blueprint $table) {
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
    }
}
