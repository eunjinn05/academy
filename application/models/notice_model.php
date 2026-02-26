<?php
    class Notice_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function notice_write_exec()
        {
            $title = @$_POST['title'];
            $content = @$_POST['content'];
            $files = @$_POST['files'];
            $idx = @$_POST['idx'];
            $original_name = @$_POST['original_name'];

            if (@$title && @$content) {
                if (@$idx) {
                    $sql = "DELETE FROM file WHERE board_type = ? AND board_idx = ?";
                    $res = $this->db->query($sql, array('notice', $idx));

                    $sql = "UPDATE notice SET title = ?, content = ?, writer = ? WHERE idx = ?";
                    $res = $this->db->query($sql, array($title, $content, '민영어', $idx));
                } else {
                    $sql = "INSERT INTO notice (title, content, writer) VALUES (?, ?, ?)";
                    $res = $this->db->query($sql, array($title, $content, '민영어'));
                    $idx = $this->db->insert_id();
                }
                if ($res) {
                    if (@$files) {
                        for ($i=0; $i<count($files); $i++) {
                            $sql = "INSERT INTO file (board_type, file_path, original_name, board_idx) VALUES (?, ?, ?, ?)";
                            $res = $this->db->query($sql, array('notice', $files[$i], $original_name[$i], $idx));
                        }
                    }
                    echo json_encode(array("return"=>true));
                } else {
                    echo json_encode(array('return'=>false));
                }
            }
        }

        public function notice_upload_exec() {
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



    public function notice_list_exec($start, $end) {
        $sql = "SELECT * FROM notice ORDER BY idx DESC limit ?, ?";
        $query = $this->db->query($sql, array($start, $end));
        return $query;
    }

    public function notice_data_exec($idx) {

        $sql = "SELECT * FROM notice WHERE idx = ?";
        $query = $this->db->query($sql, array($idx));
        $arr['notice'] = $query->row();

        if (!$idx || $arr['notice'] == null) {
            echo "<script>alert('잘못된 경로입니다.'); history.back(); </script>";
        }

        $sql2 = "SELECT * FROM file WHERE board_type = 'notice' AND board_idx = ?";
        $arr['files'] = $this->db->query($sql2, array($idx))->result_array();

        return $arr;
    }

    public function notice_board_count() {
        $sql = "SELECT COUNT(*) con FROM notice";
        $query = $this->db->query($sql);
        $result = $query->row()->con;

        return $result;
    }

    public function notice_delete_exec() {
        $idx = $_POST['idx'];
        $sql = "DELETE FROM notice WHERE idx = ?";
        $query = $this->db->query($sql, array($idx));
        if ($query) {
            echo json_encode(array('result'=>true));
        } else {
            echo json_encode(array('result'=>false));
        }
    }

}