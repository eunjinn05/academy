<?php
    class Assignment_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
        }

        public function assignment_write_exec()
        {
            $category = @$_POST['category'];
            $assignment_date = @$_POST['assignment_date'];
            $content = @$_POST['content'];
            $files = @$_POST['files'];
            $idx = @$_POST['idx'];
            $original_name = @$_POST['original_name'];

            if (@$content) {
                if (@$idx) {
                    $sql = "DELETE FROM file WHERE board_type = ? AND board_idx = ?";
                    $res = $this->db->query($sql, array('assignment', $idx));

                    $sql = "UPDATE assignment SET assignment_date = ?, category = ?, content = ? WHERE idx = ?";
                    $res = $this->db->query($sql, array($assignment_date, $category, $content, $idx));
                } else {
                    $sql = "INSERT INTO assignment (assignment_date, category, content) VALUES (?, ?, ?)";
                    $res = $this->db->query($sql, array($assignment_date, $category, $content));
                    $idx = $this->db->insert_id();
                }
                if ($res) {
                    if (@$files) {
                        for ($i=0; $i<count($files); $i++) {
                            $sql = "INSERT INTO file (board_type, file_path, original_name, board_idx) VALUES (?, ?, ?, ?)";
                            $res = $this->db->query($sql, array('assignment', $files[$i], $original_name[$i], $idx));
                        }
                    }
                    echo json_encode(array("return"=>true));
                } else {
                    echo json_encode(array('return'=>false));
                }
            }

        }

        public function assignment_data_exec($assignment_date, $category, $type = "view") {
            
            $arr['category'] = $category;
            if ($type == "view") {
                $sql = "SELECT category FROM assignment WHERE assignment_date = ?";
                $arr['category_arr'] = $this->db->query($sql, array($assignment_date))->result_array();
                $arr['category'] = @$arr['category_arr'][0]['category'];
                if ($category == "") {
                    $category = $arr['category'];
                }
            }
            

            $sql = "SELECT * FROM assignment WHERE assignment_date = ? AND category = ?";
            $query = $this->db->query($sql, array($assignment_date, $category));
            $arr['assignment'] = $query->row();

            if (!$arr['assignment'] && $type == 'view') {
                echo "<script>alert('해당 날짜의 숙제가 없습니다! 야호!'); history.back(); </script>";

            }

            if (!$assignment_date) {
                echo "<script>alert('잘못된 경로입니다.'); history.back(); </script>";
            } else {
                $sql2 = "SELECT * FROM file WHERE board_type = 'assignment' AND board_idx = ?";
                $arr['files'] = $this->db->query($sql2, array(@$arr['assignment']->idx))->result_array();

                return $arr;
            }

        }
        
        public function assignment_delete_exec()
        {
            $idx = @$_POST['idx'];

            $sql = "DELETE FROM file WHERE board_type = ? AND board_idx = ?";
            $res = $this->db->query($sql, array('assignment', $idx));
            
            $sql = "DELETE FROM assignment WHERE idx = ?";
            $res = $this->db->query($sql, array($idx));
                
            if ($res) {
                echo json_encode(array('result'=>true));
            } else {
                echo json_encode(array('result'=>false));
            }
        }
    }

?>