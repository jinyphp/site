<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupportAutoAssignment;
use App\Models\User;

/**
 * 기술지원 자동 할당 설정 컨트롤러
 */
class AutoAssignmentController extends Controller
{
    /**
     * 자동 할당 설정 목록
     */
    public function index(Request $request)
    {
        $query = SiteSupportAutoAssignment::with('assignee');

        // 유형 필터
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // 활성화 상태 필터
        if ($request->has('enable') && $request->enable !== '') {
            $query->where('enable', (bool)$request->enable);
        }

        // 담당자 필터
        if ($request->has('assignee_id') && $request->assignee_id) {
            $query->where('assignee_id', $request->assignee_id);
        }

        $autoAssignments = $query->orderBy('type')
                                ->orderBy('priority')
                                ->orderBy('order')
                                ->paginate(20);

        // 관리자 목록
        $admins = User::where('isAdmin', true)
                     ->select('id', 'name', 'email')
                     ->orderBy('name')
                     ->get();

        // 유형 목록 (실제 사용 중인 유형들)
        $types = DB::table('site_support')
                   ->select('type')
                   ->distinct()
                   ->whereNotNull('type')
                   ->orderBy('type')
                   ->pluck('type');

        return view('jiny-site::admin.support.auto-assignments.index', [
            'autoAssignments' => $autoAssignments,
            'admins' => $admins,
            'types' => $types,
            'currentType' => $request->type,
            'currentEnable' => $request->enable,
            'currentAssigneeId' => $request->assignee_id,
        ]);
    }

    /**
     * 자동 할당 설정 생성 폼
     */
    public function create()
    {
        // 관리자 목록
        $admins = User::where('isAdmin', true)
                     ->select('id', 'name', 'email')
                     ->orderBy('name')
                     ->get();

        // 유형 목록
        $types = DB::table('site_support')
                   ->select('type')
                   ->distinct()
                   ->whereNotNull('type')
                   ->orderBy('type')
                   ->pluck('type');

        return view('jiny-site::admin.support.auto-assignments.create', [
            'admins' => $admins,
            'types' => $types,
        ]);
    }

    /**
     * 자동 할당 설정 저장
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:100',
            'priority' => 'nullable|in:urgent,high,normal,low',
            'assignee_id' => 'required|exists:users,id',
            'enable' => 'boolean',
            'order' => 'integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            // 할당받을 사용자가 관리자인지 확인
            $assignee = User::where('id', $request->assignee_id)
                           ->where('isAdmin', true)
                           ->first();

            if (!$assignee) {
                return back()->withErrors(['assignee_id' => '유효하지 않은 관리자입니다.']);
            }

            SiteSupportAutoAssignment::create([
                'type' => $request->type,
                'priority' => $request->priority,
                'assignee_id' => $request->assignee_id,
                'enable' => $request->boolean('enable', true),
                'order' => $request->integer('order', 0),
                'description' => $request->description,
            ]);

            return redirect()->route('admin.support.auto-assignments.index')
                           ->with('success', '자동 할당 설정이 생성되었습니다.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => '설정 저장 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 자동 할당 설정 상세 보기
     */
    public function show($id)
    {
        $autoAssignment = SiteSupportAutoAssignment::with('assignee')->findOrFail($id);

        return view('jiny-site::admin.support.auto-assignments.show', [
            'autoAssignment' => $autoAssignment,
        ]);
    }

    /**
     * 자동 할당 설정 수정 폼
     */
    public function edit($id)
    {
        $autoAssignment = SiteSupportAutoAssignment::findOrFail($id);

        // 관리자 목록
        $admins = User::where('isAdmin', true)
                     ->select('id', 'name', 'email')
                     ->orderBy('name')
                     ->get();

        // 유형 목록
        $types = DB::table('site_support')
                   ->select('type')
                   ->distinct()
                   ->whereNotNull('type')
                   ->orderBy('type')
                   ->pluck('type');

        return view('jiny-site::admin.support.auto-assignments.edit', [
            'autoAssignment' => $autoAssignment,
            'admins' => $admins,
            'types' => $types,
        ]);
    }

    /**
     * 자동 할당 설정 업데이트
     */
    public function update(Request $request, $id)
    {
        $autoAssignment = SiteSupportAutoAssignment::findOrFail($id);

        $request->validate([
            'type' => 'required|string|max:100',
            'priority' => 'nullable|in:urgent,high,normal,low',
            'assignee_id' => 'required|exists:users,id',
            'enable' => 'boolean',
            'order' => 'integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            // 할당받을 사용자가 관리자인지 확인
            $assignee = User::where('id', $request->assignee_id)
                           ->where('isAdmin', true)
                           ->first();

            if (!$assignee) {
                return back()->withErrors(['assignee_id' => '유효하지 않은 관리자입니다.']);
            }

            $autoAssignment->update([
                'type' => $request->type,
                'priority' => $request->priority,
                'assignee_id' => $request->assignee_id,
                'enable' => $request->boolean('enable', true),
                'order' => $request->integer('order', 0),
                'description' => $request->description,
            ]);

            return redirect()->route('admin.support.auto-assignments.index')
                           ->with('success', '자동 할당 설정이 업데이트되었습니다.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => '설정 업데이트 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 자동 할당 설정 삭제
     */
    public function destroy($id)
    {
        try {
            $autoAssignment = SiteSupportAutoAssignment::findOrFail($id);
            $autoAssignment->delete();

            return redirect()->route('admin.support.auto-assignments.index')
                           ->with('success', '자동 할당 설정이 삭제되었습니다.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => '설정 삭제 중 오류가 발생했습니다: ' . $e->getMessage()]);
        }
    }

    /**
     * 자동 할당 설정 활성화/비활성화 토글
     */
    public function toggle(Request $request, $id)
    {
        try {
            $autoAssignment = SiteSupportAutoAssignment::findOrFail($id);
            $autoAssignment->update(['enable' => !$autoAssignment->enable]);

            return response()->json([
                'success' => true,
                'enable' => $autoAssignment->enable,
                'message' => $autoAssignment->enable ? '자동 할당이 활성화되었습니다.' : '자동 할당이 비활성화되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상태 변경 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}