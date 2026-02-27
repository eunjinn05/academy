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