<?php 
    class DBManagement {
        private $hostname;
        private $username;
        private $password;
        private $database;

        public function __construct()
        {
            $this->hostname = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->database = "noleggiobici";
        }

        public function inserimentoUtente()
        {

            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO clienti (username, password, email, isAdmin, codice_bici) VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $username = "lv";
            $password = md5("1234");
            $email = "lorenzo@gmail.com";
            $isAdmin = 1;
            $codice_bici = "";

            $stmt->bind_param("sssii", $username, $password, $email, $isAdmin, $codice_bici);

            $status = "";

            if ($stmt->execute())
                $status = "ok";
            else 
                $status = "error";

            $stmt->close();
            $conn->close();

            return $status;
        }


        
    }
?>