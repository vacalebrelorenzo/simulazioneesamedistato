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

        public function get_station_location()
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT nome, longitudine, latitudine FROM stazione";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->execute();

            $result = $stmt->get_result();

            $arr = array();
            
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $arr[] = $row;
                }
            }

            return array("status" => "ok", "vettore" => $arr);
        }

        private function controlloPresenzaUsername($usn)
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
            $stmt->close();
            $conn->close();

            $row = $result->fetch_assoc();

            if($result->num_rows > 0)
                return array("numRis" => $result->num_rows, "idUtente" => $row["codice_identificativo"]);
            else
                return array("numRis" => $result->num_rows, "idUtente" => "-1");
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

            if ($stmt->execute())
                $status = array("status" => "ok", "information" => "Registrazione avvenuta con successo!");
            else 
                $status = array("status" => "error", "information" => "Non è stato possibile creare la smart card!");
            
            $stmt->close();
            $conn->close();

            return $status;
        }

        public function checkAddUsername($usn, $psw, $email)
        {
            $status = "";

            $info = $this->controlloPresenzaUsername($usn);
            if($info["numRis"] === 0)
                $status = $this->inserimentoUtente($usn, $psw, $email);
            else
                $status = array("status"=> "error", "information" => "Username già in uso");
        
            return $status;
        }

        private function inserimentoUtente($usn, $psw, $email)
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
                $stmt->close();
                $conn->close();

                $info = $this->controlloPresenzaUsername($usn);
                $status = $this->creaTessera($info["idUtente"]);
            } 
            else 
            {
                $stmt->close();
                $conn->close();
                $status = array("status" => "error", "information" => "Non è stato possibile inserire l'utente nel db");
            }

            return $status;
        }

        public function effettuaLogin($usn, $psw)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT password, isAdmin FROM clienti WHERE username = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $usn);

            $stmt->execute();

            $result = $stmt->get_result();

            $msg = "";
            $stato = "";
            $isAdmin = "";

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hash = $row['password'];
                
                if (password_verify($psw, $hash)) {
                    $msg = "Accesso consentito!";
                    $isAdmin = $row["isAdmin"];
                    $stato = "ok";
                } else {
                    $msg = "Username o password errati.";
                    $isAdmin = "No";
                    $stato = "error";
                }
            } else {
                $msg = "Username o password errati.";
                $stato = "error";
            }

            $stmt->close();
            $conn->close();

            return array("status" => $stato, "information" => $msg, "isAdmin" => $isAdmin);
        }

        public function addAddress($usn, $city,$via,$cap,$numCiv)
        {
            $info = $this->controlloPresenzaUsername($usn);

            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO indirizzi (citta, via, numero_civico, cap, codice_cliente) VALUES (?, ?, ?, ?,?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("ssssi", $city, $via, $numCiv, $cap,$info["idUtente"]);

            $status = "";

            if($stmt->execute())
                $status = array("status"=> "ok", "information" => "Indirizzo inserito con successo!");
            else
                $status = array("status"=> "error", "information" => "Non è stato possibile aggiungere l'indirizzo!");

            $stmt->close();
            $conn->close();    
            
            return $status;
        }

        private function addStationWithoutUser($citta,$via,$cap,$numCiv)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO indirizzi (citta, via, numero_civico, cap) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("ssss", $citta, $via, $numCiv, $cap);

            $status = "";

            if($stmt->execute())
                $status = array("status" => "ok", "information" => "Indirizzo inserito con successo!");
            else
                $status = array("status" => "error", "information" => "Indirizzo non inserito");

            $stmt->close();
            $conn->close();    

            return $status;
        }

        private function trovaIdIndirizzo($citta,$via,$cap,$numCiv)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT ID, citta, via, numero_civico, cap FROM indirizzi WHERE citta = ? AND via = ? AND numero_civico = ? AND cap = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("ssss", $citta, $via, $numCiv, $cap);

            $status = "";
            $id = "";

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["ID"];
                $status = array("status"=> "ok", "id_indirizzo"=>$id);
            }
            else
                $status = array("status"=> "error", "id_indirizzo"=> "-1");

            $stmt->close();
            $conn->close();

            return $status;
        }

        private function creaStation($nome,$lat, $long,$numSlot,$id_indirizzo)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO stazione (nome, longitudine , latitudine, num_slot, num_bici_disp, id_indirizzo ) VALUES (?, ?, ?, ? ,? ,?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("sssiii", $nome,$long,$lat,$numSlot,$numSlot,$id_indirizzo);

            $status = "";

            if($stmt->execute())
                $status = array("status" => "ok", "information" => "Stazione inserita con successo!");
            else
                $status = array("status" => "error", "information" => "Stazione non inserita");

            $stmt->close();
            $conn->close();    

            return $status;
        }
        public function stationManagement($nome,$lat, $long,$numSlot,$citta,$via,$cap,$numCiv)
        {
            $status = $this->addStationWithoutUser($citta,$via,$cap,$numCiv);

            if($status["status"] === "ok")
            {
                $vett = $this->trovaIdIndirizzo($citta,$via,$cap,$numCiv);

                if($vett["status"] === "ok"){
                    $status2 = $this->creaStation($nome,$lat, $long,$numSlot,$vett["id_indirizzo"]);
                    return $status2;
                }
                else
                    return $vett;
            }
            else
                return $status;
        }
    }

?>