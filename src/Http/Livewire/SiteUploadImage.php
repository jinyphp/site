<?php
namespace Jiny\Site\Http\Livewire;

use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Route;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;

use Livewire\WithFileUploads;
use Livewire\Attributes\On;

/**
 * 이미지 업로드 컴포넌트
 */
class SiteUploadImage extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $viewFile;
    public $path;

    public $popupWindowWidth = "2xl";

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site::site.upload.image";
        }
    }

    public function render()
    {
        return view($this->viewFile, [
            'images' => $this->getImages()
        ]);
    }

    /**
     * 이미지 목록 조회
     */
    private function getImages()
    {
        $images = [];
        if ($this->path) {
            $path = public_path($this->path);
            if(!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            if(file_exists($path)) {
                $files = array_diff(scandir($path), ['.', '..']);
                foreach ($files as $file) {
                    if (is_file($path . '/' . $file)) {
                        $images[] = [
                            'url' => $this->path . '/' . $file,
                            'filename' => $file
                        ];
                    }
                }
            }
        }

        return $images;
    }


    #[On('image-updated')]
    public function refreshImages()
    {
        $this->render();
    }

    /**
     * 이미지 파일
     */
    public $imageFile;
    public function uploadImage()
    {
        // 이미지 파일 유효성 검사
        $this->validate([
            'imageFile' => 'required|mimes:jpg,jpeg,png,gif|max:2048', // 2MB 제한
        ], [
            'imageFile.required' => '이미지 파일을 선택해주세요.',
            'imageFile.mimes' => 'jpg, jpeg, png, gif 형식의 이미지 파일만 업로드 가능합니다.',
            'imageFile.max' => '파일 크기는 2MB를 초과할 수 없습니다.'
        ]);

        try {
            // 기본 이미지 경로 설정
            $uploadPath = public_path($this->path);

            // 디렉토리가 없는 경우 생성
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0755, true)) {
                    session()->flash('error', '디렉토리 생성 실패');
                    return;
                }
            }

            // 원본 파일명 가져오기
            $originalName = $this->imageFile->getClientOriginalName();

            // 파일명 중복 방지
            $pathInfo = pathinfo($originalName);
            $filename = $pathInfo['filename'] . '_' . time() . '.' . $pathInfo['extension'];

            // 파일 이동
            $src = $this->imageFile->getRealPath();
            $dst = $uploadPath . '/' . $filename;

            if (rename($src, $dst)) {
                chmod($dst, 0644); // 파일 권한 설정
                session()->flash('message', '이미지가 성공적으로 업로드되었습니다.');
                $this->imageFile = null;
                $this->emit('imageUploaded');
            } else {
                throw new \Exception('파일 이동 실패');
            }

        } catch (\Exception $e) {
            session()->flash('error', '이미지 업로드 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 이미지 삭제 관련 속성
     */
    public $popupDeletePath = false;
    public $fullPath;
    public $deleteFileName;

    /**
     * 이미지 삭제 확인 팝업
     */
    public function deleteImage($path, $name)
    {
        $this->popupDeletePath = true;

        $fullPath = public_path($path);
        $fullPath = str_replace(['\/','\\','/'], DIRECTORY_SEPARATOR, $fullPath);

        // 파일 존재 여부 확인
        if (!file_exists($fullPath)) {
            session()->flash('error', '파일을 찾을 수 없습니다.');
            return;
        }

        $this->fullPath = $fullPath;
        $this->deleteFileName = $name;
    }

    public function deleteCancel()
    {
        $this->popupDeletePath = false;
    }
    /**
     * 이미지 삭제 실행
     */
    public function deleteImageConfirm()
    {
        $this->popupDeletePath = false;

        try {
            // 파일 삭제
            unlink($this->fullPath);
            session()->flash('message', '이미지가 성공적으로 삭제되었습니다.');

        } catch (\Exception $e) {
            session()->flash('error', '이미지 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

}
