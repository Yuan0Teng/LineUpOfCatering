<?php

    class LinkToDatabase {
        public $servername = "192.168.9.128";
        public $username   = "root";
        public $password   = "yuanteng";
        public $database   = "line_up";

        public function link() {
            $conn = new mysqli($this->servername, $this->username, $this->password,$this->database);
            if ($conn->connect_error) {
                die("Connection failed:" . $conn->connect_error);
            }
            return $conn;
        }
    }

?>