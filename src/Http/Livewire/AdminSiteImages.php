<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AdminSiteImages extends Component
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
        $baseImagePath = public_path('images');

        // URL에서 전달된 경로 파라미터 처리
        $subPath = $this->path ?? '';
        $currentPath = $baseImagePath . '/' . $subPath;

        // 상대 경로 보안 검사
        if (strpos(realpath($currentPath), realpath($baseImagePath)) !== 0) {
            abort(403, '잘못된 경로입니다.');
        }

        // 디렉토리와 이미지 정보를 저장할 배열
        $data = [
            'directories' => [],
            'images' => [],
            'current_path' => '/images/' . $subPath,
            'parent_path' => dirname('/images/' . $subPath)
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
                        // 이미지 파일 확장자 체크
                        $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));
                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $data['images'][] = [
                                'name' => $item,
                                'path' => '/images/' . $relativePath,
                                'size' => filesize($fullPath),
                                'modified' => filemtime($fullPath)
                            ];
                        }
                    }
                }
            }
        }

        //dd($data);

        return view('jiny-site::admin.images.images',$data);
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
        $baseImagePath = public_path('images');

        // 삭제할 디렉토리 경로 생성
        $fullPath = $baseImagePath . '/' . $path;

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath($fullPath), realpath($baseImagePath)) !== 0) {
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
            return redirect()->route('admin.site.images.index', ['path' => $parentPath]);

        } catch (\Exception $e) {
            session()->flash('error', '디렉토리 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    public function createDirectory($path)
    {
        // 기본 이미지 경로 설정
        $baseImagePath = public_path('images');

        // 새 디렉토리 경로 생성
        $newPath = $baseImagePath . '/' . $path . '/' . $this->newDirectory;

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath(dirname($newPath)), realpath($baseImagePath)) !== 0) {
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
        $baseImagePath = public_path('images');

        // 실제 파일 경로 생성
        $fullPath = public_path($path);

        // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
        if (strpos(realpath($fullPath), realpath($baseImagePath)) !== 0) {
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

        //dd($this->imageFile);
        try {
            // 기본 이미지 경로 설정
            $baseImagePath = public_path('images');
            $uploadPath = $baseImagePath;

            // 현재 경로가 있는 경우 추가
            if ($this->path) {
                $uploadPath .= '/' . $this->path;

                // 보안 검사: 기본 이미지 디렉토리 외부 접근 방지
                if (strpos(realpath($uploadPath), realpath($baseImagePath)) !== 0) {
                    session()->flash('error', '잘못된 업로드 경로입니다.');
                    return;
                }

                // 디렉토리가 없는 경우 생성
                if (!is_dir($uploadPath)) {
                    if (!mkdir($uploadPath, 0755, true)) {
                        session()->flash('error', '디렉토리 생성 실패');
                        return;
                    }
                }
            }

            //dump($uploadPath);

            // 원본 파일명 가져오기
            $originalName = $this->imageFile->getClientOriginalName();

            // 파일명 중복 체크
            if (file_exists($uploadPath . '/' . $originalName)) {
                $pathInfo = pathinfo($originalName);
                $originalName = $pathInfo['filename'] . '_' . time() . '.' . $pathInfo['extension'];
            }


            $src = $this->imageFile->getRealPath();
            $dst = $uploadPath . '/' . $originalName;
            //dump($src);
            //dump($dst);
            if(rename($src, $dst)) {
                session()->flash('success', '이미지가 성공적으로 업로드되었습니다.');
                $this->imageFile = null; // 파일 입력 초기화
            } else {
                session()->flash('error', '파일 업로드 실패');
            }

            // // 파일 저장
            // if ($this->imageFile->getRealPath()
            //     && move_uploaded_file($this->imageFile->getRealPath(), $uploadPath . '/' . $originalName)) {
            //     session()->flash('success', '이미지가 성공적으로 업로드되었습니다.');
            //     $this->imageFile = null; // 파일 입력 초기화

            //     //dump('업로드 성공');
            //     // // 화면 갱신
            //     // //$this->emit('fileUploaded');
            // } else {
            //     session()->flash('error', '파일 업로드 실패');
            //     //dump('업로드 실패');
            // }

            //dd('업로드 완료');

        } catch (\Exception $e) {
            session()->flash('error', '이미지 업로드 중 오류가 발생했습니다: ' . $e->getMessage());
            //dd("업로드 오류");
        }
    }


}
