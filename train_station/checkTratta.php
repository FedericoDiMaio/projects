<?php

        /*------------------------------
        CONNESIONE PDO
        -------------------------------*/

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "train_station";

        try {
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "ERRORE!: " . $e->getMessage() . "<br>";
            die();
        }

            session_start();

            $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
            $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
            $stazione_partenza_id = $_SESSION['stazione_partenza'];
            $stazione_destinazione_id = $_SESSION['stazione_destinazione'];
            $costo_biglietto = $_SESSION['costo_biglietto'];
            $data_partenza = $_SESSION['data_partenza'];
            $orario_partenza = $_SESSION['orario_partenza'];
            $somma_posizione_km = $_SESSION['somma_posizione_km'];
            $tempo_di_percorrenza_hhmm = $_SESSION['tempo_di_percorrenza_hhmm'];
            $tempo_di_arrivo = $_SESSION['tempo_di_arrivo'];
        
        echo 'nome: ' . htmlspecialchars($nome) . '<br>';
        echo 'cognome: ' . htmlspecialchars($cognome) . '<br>';
        echo 'stazione partenza: ' . htmlspecialchars($stazione_partenza_id) . '<br>';
        echo 'stazione destinazione: ' . htmlspecialchars($stazione_destinazione_id) . '<br>';
        echo 'costo biglietto: ' . htmlspecialchars($costo_biglietto) . '<br>';
        echo 'data partenza: ' . htmlspecialchars($data_partenza) . '<br>';
        echo 'orario partenza: ' . htmlspecialchars($orario_partenza) . '<br>';
        echo 'somma posizione km: ' . htmlspecialchars($somma_posizione_km) . '<br>';
        echo 'tempo di percorrenza hhmm: ' . htmlspecialchars($tempo_di_percorrenza_hhmm) . '<br>';
        echo 'tempo di arrivo: ' . htmlspecialchars($tempo_di_arrivo) . '<br>';

        try {
            
            $stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, data_partenza, orario_partenza, tempo_arrivo, tempo_percorrenza) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :data_partenza, :orario_partenza, :tempo_arrivo, :tempo_percorrenza)");
        
            $stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
            $stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
            $stmt->bindParam(':id_stazione_partenza', $stazione_partenza_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione_id, PDO::PARAM_INT);
            $stmt->bindParam(':data_partenza', $data_partenza, PDO::PARAM_STR);
            $stmt->bindParam(':orario_partenza', $orario_partenza, PDO::PARAM_STR);
            $stmt->bindParam(':tempo_arrivo', $tempo_di_arrivo, PDO::PARAM_STR);
            $stmt->bindParam(':tempo_percorrenza', $tempo_di_percorrenza_hhmm, PDO::PARAM_STR);
        
            $stmt->execute();
        
            echo "Inserimento nella tabella 'tratta' avvenuto con successo.";
        } catch (PDOException $e) {
            echo "Errore nell'inserimento nella tabella 'tratta': " . $e->getMessage();
        }
?>