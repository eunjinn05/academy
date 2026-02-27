<?php
    class common_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function upload_exec() {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'word', 'hwp', 'excel'];
            $photo_extensions = ['jpg', 'jpeg', 'png', 'gif'];

            $max_file_size = 5 * 1024 * 1024;
            $upload_dir = "upload/files/";

            // 이미지 압축 설정
            $max_width  = 1920;
            $max_height = 1080;
            $jpg_quality = 30;  // JPEG 품질 (0~100)
            $png_compression = 5; // PNG 압축 (0~9)

            for ($i=0; $i < count($_FILES['files']['name']); $i++) {

                // 파일 크기 체크
                if ($_FILES['files']['size'][$i] > $max_file_size) {
                    $response['success'] = false;
                    $response['message'] = "파일이 크기를 초과하였습니다. (최대 5MB)";
                    return false;
                }

                // 확장자 체크
                $original_name = $_FILES['files']['name'][$i];
                $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                
                if (!in_array($ext, $allowed_extensions)) {
                    $response['success'] = false;
                    $response['message'] = "허용되지 않은 파일 형식입니다.";
                    return false;
                }

                // 안전한 파일명 생성
                $new_name = uniqid() . '_' . time() . '.' . $ext;

                // 폴더 존재 확인 후 생성
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $upload_path = $upload_dir . $new_name;

                // 파일 이동
                if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $upload_path)) {
                    $response['files'][] = [
                        'saved_name' => $new_name,
                        'original_name' => $original_name,
                        'path' => "/".$upload_path,
                        "ext" => $ext
                    ];

                    if (in_array($ext, $photo_extensions)) {
                        $this->compress_image($upload_path, $ext, $max_width, $max_height, $jpg_quality, $png_compression);
                    }

                } else {
                    $response['success'] = false;
                    $response['message'] = "다시 시도해주세요.";
                    return false;
                }
                $response['success'] = true;
                $response['message'] = count($response['files']) . '개 파일 처리 완료';
            }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }


    private function compress_image($path, $ext, $max_width, $max_height, $jpg_quality, $png_compression) {
        // GD 라이브러리 확인
        if (!extension_loaded('gd')) return;
        // 원본 이미지 로드
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $src = @imagecreatefromjpeg($path);
                break;
            case 'png':
                $src = @imagecreatefrompng($path);
                break;
            case 'gif':
                $src = @imagecreatefromgif($path);
                break;
            default:
                return;
        }

        if (!$src) return;

        $origin_w = imagesx($src);
        $origin_h = imagesy($src);

        // 리사이즈 비율 계산
        $ratio = min($max_width / $origin_w, $max_height / $origin_h, 1); // 1 이하일 때만 축소
        $new_w  = (int)($origin_w * $ratio);
        $new_h  = (int)($origin_h * $ratio);

        // 새 캔버스 생성
        $dst = imagecreatetruecolor($new_w, $new_h);

        // PNG / GIF 투명도 유지
        if (in_array($ext, ['png', 'gif'])) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $new_w, $new_h, $transparent);
        }

        // 리사이징
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_w, $new_h, $origin_w, $origin_h);

        // 저장 (원본 덮어쓰기)
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($dst, $path, $jpg_quality);
                break;
            case 'png':
                imagepng($dst, $path, $png_compression);
                break;
            case 'gif':
                imagegif($dst, $path);
                break;
        }

        imagedestroy($src);
        imagedestroy($dst);
    }

}

?>