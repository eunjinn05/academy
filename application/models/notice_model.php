<?php
    class Notice_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function notice_write_exec()
        {
            $title = $_POST['title'];
            $content = $_POST['content'];

            if (@$title && @$content) {
                $sql = "INSERT INTO notice (title, content) VALUES (?, ?)";
                $this->db->query($sql, array($title, $content));
            }

            
        }

}