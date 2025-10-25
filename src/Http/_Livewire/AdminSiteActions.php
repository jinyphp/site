<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AdminSiteActions extends Component
{
    use WithFileUploads;

    public $path;
    public $newDirectory;

    public $popupDelete = false;
    public $popupWindowWidth = '2xl';

    public $popupDeletePath = false;

    public function render()
    {
        // 기본 이미지 디렉토리 경로 설정
        //$baseActionPath = public_path('images');
        $baseActionPath = resource_path('actions');

        // URL에서 전달된 경로 파라미터 처리
        $subPath = $this->path ?? '';
        $currentPath = $baseActionPath . '/' . $subPath;

        // 상대 경로 보안 검사
        if (strpos(realpath($currentPath), realpath($baseActionPath)) !== 0) {
            abort(403, '잘못된 경로입니다.');
        }

        // 디렉토리와 이미지 정보를 저장할 배열
        $data = [
            'directories' => [],
            'files' => [],
            'current_path' => $subPath,
            'parent_path' => dirname($subPath)
        ];

        if (is_dir($currentPath)) {
            // 디렉토리 스캔
            $items = scandir($currentPath);

            foreach ($items as $item) {
                if ($item != '.' && $item != '..') {
                    $fullPath = $currentPath . '/' . $item;
                    $relativePath = trim($subPath . '/' . $item, '/');

                    if (is_dir($fullPath)) {
                        $data['directories'][] = [
                            'name' => $item,
                            'path' => $relativePath
                        ];
                    } else {
                        // json 파일 확장자 체크
                        $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                        if ($extension === 'json') {
                            $data['files'][] = [
                                'name' => $item,
                                'path' => $relativePath
                            ];
                        }
                    }
                }
            }
        }

        //dd($data);

        return view('jiny-site::admin.actions.action',$data);
    }

    public function deleteDirectory($path)
    {
        $this->popupDelete = true;
    }

    public function deleteCancel()
    {
        $this->popupDelete = false;
        $this->popupDeletePath = false;
    }

    public function deleteConfirm($path)
    {
        $this->popupDelete = false;

        // 기본 이미지 경로 설정
        $baseActionPath = resource_path('actions');

        // 삭제할 디렉토리 경로 생성
        $fullPath = $baseActionPath . '/' . $path;

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath($fullPath), realpath($baseActionPath)) !== 0) {
            session()->flash('error', '잘못된 디렉토리 경로입니다.');
            return;
        }

        // 디렉토리 존재 여부 확인
        if (!is_dir($fullPath)) {
            session()->flash('error', '디렉토리를 찾을 수 없습니다.');
            return;
        }

        try {
            // 디렉토리 삭제
            rmdir($fullPath);
            session()->flash('success', '디렉토리가 성공적으로 삭제되었습니다.');

            // 상위 디렉토리로 리다이렉트
            $parentPath = dirname($path);
            return redirect()->route('admin.site.actions.index', ['path' => $parentPath]);

        } catch (\Exception $e) {
            session()->flash('error', '디렉토리 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    public function createDirectory($path)
    {
        // 기본 이미지 경로 설정
        $baseActionPath = resource_path('actions');

        // 새 디렉토리 경로 생성
        $newPath = $baseActionPath . '/' . $path . '/' . $this->newDirectory;

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath(dirname($newPath)), realpath($baseActionPath)) !== 0) {
            session()->flash('error', '잘못된 디렉토리 경로입니다.');
            return;
        }

        // 디렉토리명 유효성 검사
        if (empty($this->newDirectory)) {
            $this->addError('newDirectory', '디렉토리 이름을 입력해주세요.');
            return;
        }

        // 이미 존재하는 디렉토리인지 확인
        if (is_dir($newPath)) {
            $this->addError('newDirectory', '이미 존재하는 디렉토리입니다.');
            return;
        }

        try {
            // 디렉토리 생성
            mkdir($newPath, 0755);
            session()->flash('success', '디렉토리가 생성되었습니다.');
            $this->newDirectory = ''; // 입력 필드 초기화

        } catch (\Exception $e) {
            session()->flash('error', '디렉토리 생성 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    public $fullPath;
    public $deleteFileName;
    public function deleteImage($path, $name)
    {
        $this->popupDeletePath = true;

        // 기본 이미지 경로 설정
        $baseActionPath = resource_path('actions');

        // 실제 파일 경로 생성
        $fullPath = public_path($path);

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath($fullPath), realpath($baseActionPath)) !== 0) {
            session()->flash('error', '잘못된 파일 경로입니다.');
            return;
        }

        // 파일 존재 여부 확인
        if (!file_exists($fullPath)) {
            session()->flash('error', '파일을 찾을 수 없습니다.');
            return;
        }

        $this->fullPath = $fullPath;
        $this->deleteFileName = $name;

    }

    public function deleteImageConfirm($path, $name)
    {
        $this->popupDeletePath = false;

        try {
            // 파일 삭제
            unlink($this->fullPath);
            session()->flash('success', '이미지가 성공적으로 삭제되었습니다.');

        } catch (\Exception $e) {
            session()->flash('error', '이미지 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }





}
