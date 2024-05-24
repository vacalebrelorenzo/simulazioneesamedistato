<?php 
    //classe per gestire tutto ciò che riguarda il db
    class DBManagement {
        private $hostname;
        private $username;
        private $password;
        private $database;

        //costruttore
        public function __construct()
        {
            $this->hostname = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->database = "noleggiobici";
        }

        //get posizione delle stazioni
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

        //controllo se l'username inserito da un utente nuovo è uguale ad un username già presente nel db
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

        //creazione tessera (inserimento nel db)
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

        //metodo generale per aggiunta nuovo utente al db
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

        //inserimento vero e proprio di un utente nel db
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

        //login
        public function effettuaLogin($usn, $psw)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT codice_identificativo, password, isAdmin FROM clienti WHERE username = ?";
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
            $id = "";
            $pass = "";

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $hash = $row['password'];
                
                if (password_verify($psw, $hash)) {
                    $msg = "Accesso consentito!";
                    $isAdmin = $row["isAdmin"];
                    $pass = $psw;
                    $id = $row["codice_identificativo"];
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

            return array("status" => $stato, "id_user" => $id,"information" => $msg, "isAdmin" => $isAdmin, "password" => $pass);
        }

        //aggiunta indirizzo al db
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
                $status = array("status"=> "error", "information" => "Non è stato possibile aggiungere l'indirizzo");

            $stmt->close();
            $conn->close();    
            
            return $status;
        }

        //aggiunta nuovo indirizzo senza associarlo ad un utente
        private function addAddressWithoutUser($citta,$via,$cap,$numCiv)
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

        //ottenimento id di un indirizzo date le caratteristiche
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

        //crea stazione nuova
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

        //gestione generale di una stazione
        public function stationManagement($nome,$lat, $long,$numSlot,$citta,$via,$cap,$numCiv)
        {
            $status = $this->addAddressWithoutUser($citta,$via,$cap,$numCiv);

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

        //ottenimento id di una stazione date le caratteristiche
        private function trovaIdStazione($n)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT ID FROM stazione WHERE nome = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $n);

            $status = "";
            $id = "";

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["ID"];
                $status = array("status"=> "ok", "id_stazione"=>$id);
            }
            else
                $status = array("status"=> "error", "id_stazione"=> "-1");

            $stmt->close();
            $conn->close();

            return $status;
        }

        //rimozione di una stazione dato il nome
        public function rimuoviStazione($nome)
        {
            $status2 = $this->trovaIdStazione($nome);

            if($status2['status'] === "ok")
            {
                $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }

                $sql = "DELETE FROM stazione WHERE ID = ?";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Errore nella preparazione della query: " . $conn->error);
                }

                $stmt->bind_param("i", $status2["id_stazione"]);

                $status = "";

                if($stmt->execute())
                    $status = array("status" => "ok", "information" => "Stazione rimossa con successo!");
                else
                    $status = array("status" => "error", "information" => "Non è stato possibile rimuovere la stazione");

                $stmt->close();
                $conn->close();

                return $status;
            }
            else
                return array("status" => "error", "information" => "Non è stata trovata alcuna stazione");
        }

        //modifica numero di slot di una stazione
        public function modificaSlot($nomeStazione, $newSlot)
        {
            $status2 = $this->trovaIdStazione($nomeStazione);

            if($status2['status'] === "ok")
            {
                $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }

                $sql = "UPDATE `stazione` SET `num_slot` = $newSlot WHERE ID = ?";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Errore nella preparazione della query: " . $conn->error);
                }

                $stmt->bind_param("i", $status2["id_stazione"]);

                $status = "";

                if($stmt->execute())
                    $status = array("status" => "ok", "information" => "Numero slot modificato con successo!");
                else
                    $status = array("status" => "error", "information" => "Non è stato possibile modificare il numero degli slot");

                $stmt->close();
                $conn->close();

                return $status;
            }
            else
                return array("status" => "error", "information" => "Non è stata trovata alcuna stazione");
        }

        //aggiunta nuova bici al db
        public function aggiungiBici($nomeStazione, $km)
        {
            $status2 = $this->trovaIdStazione($nomeStazione);

            if($status2['status'] === "ok")
            {
                $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }

                $sql = "INSERT INTO bici (km_totali, isRented, id_stazione) VALUES (?, ?, ?)";

                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Errore nella preparazione della query: " . $conn->error);
                }

                $isRented = 0;

                $stmt->bind_param("iii", $km, $isRented, $status2["id_stazione"]);

                $status = "";

                if($stmt->execute())
                    $status = array("status"=> "ok", "information" => "Bici inserita con successo!");
                else
                    $status = array("status"=> "error", "information" => "Non è stato possibile aggiungere la bici");

                $stmt->close();
                $conn->close();    
                
                return $status;
            }
            else
                return array("status" => "error", "information" => "Non è stata trovata alcuna stazione");
        }

        //rimozione bici dal db
        public function eliminaBici($id_bici)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "DELETE FROM bici WHERE codice_identificativo = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("i", $id_bici);

            $status = "";

            if($stmt->execute())
                $status = array("status" => "ok", "information" => "Bici rimossa con successo!");
            else
                $status = array("status" => "error", "information" => "Non è stato possibile rimuovere la bici");

            $stmt->close();
            $conn->close();

            return $status;
        }

        //controllo se un utente ha una carta di credito associata
        private function checkPresenzaCarta($idUtente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT ID FROM carte_credito WHERE codice_cliente = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $idUtente);

            $stmt->execute();

            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();

            if($result->num_rows > 0)
                return "true";
            else
                return "false";

        }

        //ottenimento di tutte le info di un utente
        public function getInfoUtente($us, $pass)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT codice_identificativo, password, email FROM clienti WHERE username = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $us);
            $stmt->execute();

            $result = $stmt->get_result();

            $infoCarta = "";

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hash = $row['password'];
                
                if (password_verify($pass, $hash)) {
                    $status = $this->checkPresenzaCarta($row["codice_identificativo"]);

                    if ($status === "true") {
                        $infoCarta = $this->getInfoCarta($row["codice_identificativo"]);
                        $infoUtente = array("status" => "ok", "username" => $us, "password" => $row['password'], "email" => $row['email'], "infoCarta" => $infoCarta);
                    } else {
                        $infoUtente = array("status" => "error", "username" => $us, "password" => $row['password'], "email" => $row['email']);
                    }
                } 
                else 
                {
                    $infoUtente = array("status" => "error", "username" => $us, "information" => $pass);
                }
            } 
            else 
            {
                $infoUtente = array("status" => "error", "username" => $us, "information" => "credenziali errate");
            }

            $stmt->close();
            $conn->close();

            return $infoUtente;

        }

        //get informazioni di una determinata carta di credito
        private function getInfoCarta($idUtente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT nome, cognome, numero FROM carte_credito WHERE codice_cliente = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("s", $idUtente);

            $stmt->execute();

            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();

            $row = $result->fetch_assoc();

            if($result->num_rows > 0)
                return array("nome" => $row["nome"], "cognome" => $row["cognome"], "numero"=> $row["numero"]);
            else
                return array("status" => "error", "information" => "non è stata trovata alcuna carta di credito");
        }

        //creazione nuova carta
        private function creaCarta($nome, $cognome, $nCarta, $id_utente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO carte_credito (nome,cognome,numero,codice_cliente) VALUES (?, ?, ?,?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("sssi", $nome, $cognome, $nCarta, $id_utente);

            $status = "";

            if($stmt->execute())
                $status = array("status"=> "ok", "information" => "Carta inserita con successo!");
            else
                $status = array("status"=> "error", "information" => "Non è stato possibile aggiungere la carta");

            $stmt->close();
            $conn->close();    
            
            return $status;
        }

        //aggiornamento carta già esistente
        private function updateCarta($nome, $cognome, $nCarta, $id_utente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "UPDATE `carte_credito` SET nome = ?, cognome = ?, numero = ? WHERE codice_cliente = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("sssi", $nome, $cognome, $nCarta, $id_utente);

            $status = "";

            if ($stmt->execute()) {
                $status = array("status" => "ok", "information" => "Carta modificata con successo!");
            } else {
                $status = array("status" => "error", "information" => "Non è stato possibile modificare la carta");
            }

            $stmt->close();
            $conn->close();

            return $status;
        }

        //update generale info di un utente
        public function updateInfoUtente($us, $email, $nome, $cognome, $nCarta, $id_utente,$presCarta, $password)
        {
            $statusCarta = "";

            //se la carta non è presente la creo
            if($presCarta == "false")
                $statusCarta = $this->creaCarta($nome, $cognome, $nCarta, $id_utente);
            else if ($presCarta == "true")
                $statusCarta = $this->updateCarta($nome, $cognome, $nCarta, $id_utente);
        
            if($statusCarta["status"] === "ok")
            {
                $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        
                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }
        
                //se l'utente ha aggiornato la password faccio update
                if($password != "")
                {
                    $pswHash = password_hash($password, PASSWORD_BCRYPT);
        
                    $sql = "UPDATE `clienti` SET username = ?, password = ?, email = ? WHERE codice_identificativo = ?";
                    $stmt = $conn->prepare($sql);
            
                    if (!$stmt) {
                        die("Errore nella preparazione della query: " . $conn->error);
                    }
            
                    $stmt->bind_param("sssi", $us, $pswHash, $email, $id_utente);
                }
                else //altrimenti no
                {
                    $sql = "UPDATE `clienti` SET username = ?, email = ? WHERE codice_identificativo = ?";
                    $stmt = $conn->prepare($sql);
            
                    if (!$stmt) {
                        die("Errore nella preparazione della query: " . $conn->error);
                    }
            
                    $stmt->bind_param("ssi", $us, $email, $id_utente);
                }
        
                $status = "";
        
                if($stmt->execute())
                    $status = array("status" => "ok", "information" => "Informazioni modificate con successo!", "password" => $password);
                else
                    $status = array("status" => "error", "information" => "Non è stato possibile modificare le informazioni dell'utente");
        
                $stmt->close();
                $conn->close();
        
                return $status;
            }
        }

        //aggiunta richiesta utente di voler una nuova smart card nel db
        private function aggiungiRichiestaNuovaSC($id, $us)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "INSERT INTO richieste_blocco (id_utente, username) VALUES (?,?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("is", $id, $us);

            $status = "";

            if($stmt->execute())
                $status = array("status"=> "ok", "information" => "Richiesta inserita con successo!");
            else
                $status = array("status"=> "error", "information" => "Non è stato possibile effettuare la richiesta");

            $stmt->close();
            $conn->close();    
            
            return $status;
        }

        //blocco della smart card di un utente (rimozione dal db)
        public function bloccaSmartCard($us)
        {
            $vett = $this->controlloPresenzaUsername($us);
            $id_utente = $vett["idUtente"];

            if($id_utente != "-1")
            {
                $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }

                $sql = "DELETE FROM smart_cards WHERE codice_cliente = ?";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    die("Errore nella preparazione della query: " . $conn->error);
                }

                $stmt->bind_param("i", $id_utente);

                $status = "";
                $status3 = "";

                if($stmt->execute())
                {
                    $status = $this->aggiungiRichiestaNuovaSC($id_utente, $us);
                    if($status["status"] ==="ok")
                        $status3 = array("status" => "ok", "information" => "Smart card bloccata con successo!", "username" => $us);
                    else
                        $status3 = array("status" => "error", "information" => "Non è stato possibile bloccare la smart card", "username" => $us);
                }   
                else
                    $status3 = array("status" => "error", "information" => "Non è stato possibile bloccare la smart card","username" => "undefined");

                $stmt->close();
                $conn->close();

                return $status3;
            }

        }

        //prendo tutte le richieste di bloccare la propria carta
        public function getRichiesteBlocco()
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM richieste_blocco";
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

        //rimozione richiesta effettuata da un utente
        private function rimuoviRichiesta($id_utente)
        {
            $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            $sql = "DELETE FROM richieste_blocco WHERE id_utente = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            $stmt->bind_param("i", $id_utente);

            $status = "";

            if($stmt->execute())
                $status = array("status" => "ok", "information" => "Bici rimossa con successo!");
            else
                $status = array("status" => "error", "information" => "Non è stato possibile rimuovere la bici");

            $stmt->close();
            $conn->close();

            return $status;
        }

        //gestione creazione (rigenerazione) nuova smart card per l'utente
        public function gestioneNuovaSC($id_utente)
        {
            $status2 = $this->rimuoviRichiesta($id_utente);
            if($status2["status"] === "ok")
            {
                $status = $this->creaTessera($id_utente);
                if($status["status"] === "ok")
                    $status = array("status" => "ok", "information" => "Rigenerazione smart card avvenuta con successo!");
            
            }
            else
                $status = array("status" => "ok", "information" => "Non è stato possibile rimuovere la richiesta di blocco carta");
            return $status;
        }
    }
?>