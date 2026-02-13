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

            if (@$title && @$content) {
                if (@$idx) {
                    $sql = "DELETE FROM file WHERE board_type = ? AND board_idx = ?";
                    $res = $this->db->query($sql, array('notice', $idx));

                    $sql = "UPDATE notice SET title = ?, content = ?, writer = ? WHERE idx = ?";
                    $res = $this->db->query($sql, array($title, $content, '선생님', $idx));
                } else {
                    $sql = "INSERT INTO notice (title, content, writer) VALUES (?, ?, ?)";
                    $res = $this->db->query($sql, array($title, $content, '선생님'));
                    $idx = $this->db->insert_id();
                }
                if ($res) {
                    if (@$files) {
                        for ($i=0; $i<count($files); $i++) {
                            $sql = "INSERT INTO file (board_type, file_path, board_idx) VALUES (?, ?, ?)";
                            $res = $this->db->query($sql, array('notice', $files[$i], $idx));
                        }
                    }
                    echo json_encode(array("return"=>true));
                } else {
                    echo json_encode(array('return'=>false));
                }
            }
        }

        public function notice_upload_exec() {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $max_file_size = 5 * 1024 * 1024;
            $upload_dir = "upload/files/";

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
                        'path' => "/".$upload_path
                    ];
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

    public function notice_list_exec($start, $end) {
        $sql = "SELECT * FROM notice limit $start, $end";
        $query = $this->db->query($sql);
        return $query;
    }

    public function notice_data_exec($idx = 1) {
        $sql = "SELECT * FROM notice WHERE idx = ?";
        $query = $this->db->query($sql, array($idx));
        $arr['notice'] = $query->row();        

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


}