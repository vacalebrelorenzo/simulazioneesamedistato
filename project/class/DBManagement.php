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

        private function creaTessera($id_utente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO smart_cards (codice_cliente) VALUES (?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("i", $id_utente);

            $status = "";

            if ($stmt->execute()) {
                $status = "ok";
            } else {
                $status = "error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();

            return $status;
        }

        public function checkUsername($usn)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT codice_identificativo FROM clienti WHERE username = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $usn);

            $stmt->execute();

            $result = $stmt->get_result();

            $status = "";

            if($result->num_rows === 0)
                $status = "ok";
            else 
                $status = "exist";
            
            $stmt->close();
            $conn->close();

            return $status;
        }

        public function trovaUtente($usn)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT codice_identificativo, password FROM clienti WHERE username = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $usn);

            $stmt->execute();

            $result = $stmt->get_result();

            $status = "";

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $statoCreazioneTessera = $this->creaTessera($row['codice_identificativo']);
                $status = $statoCreazioneTessera;
            } 
            else
                $status = "error:" . $stmt->error;

            $stmt->close();
            $conn->close();

            return $status;
        }

        public function inserimentoUtente($usn, $psw, $email)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO clienti (username, password, email, isAdmin) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $isAdmin = 0; 

            $pswHash = password_hash($psw, PASSWORD_BCRYPT);
            $stmt->bind_param("sssi", $usn, $pswHash, $email, $isAdmin);

            $status = "";
            if ($stmt->execute()) {
                $status = "ok";
            } else {
                $status = "error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();

            return $status;
        }

        public function effettuaLogin($usn, $psw)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT password FROM clienti WHERE username = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $usn);

            $stmt->execute();

            $result = $stmt->get_result();

            $msg = "";
            $stato = "";

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hash = $row['password'];
                
                if (password_verify($psw, $hash)) {
                    $msg = "Accesso consentito!";
                    $stato = "ok";
                } else {
                    $msg = "Username o password errati.";
                    $stato = "error";
                }
            } else {
                $msg = "Username o password errati.";
                $stato = "error";
            }

            $stmt->close();
            $conn->close();

            return array("status" => $stato, "information" => $msg);
        }
    }
?>