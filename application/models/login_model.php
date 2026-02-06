<?php
    class Login_model extends CI_Model {

        public $id;
        public $password;

        public function __construct()
        {
                parent::__construct();
        }

        public function login_exec()
        {
                if (@$_POST['id'] && @$_POST['password']) {
                        $id = $_POST['id'];
                        $password = $_POST['password'];

                        if ($id == "admin" && $password == "password") {
                                echo json_encode(array('result'=>true));
                        } else {
                                echo json_encode(array('result'=>false));
                        }
                } else {

                }


        }

}