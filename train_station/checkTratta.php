<?php

    include "./connessionePDO.php";

            session_start();

            $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
            $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
            $stazione_partenza = $_SESSION['stazione_partenza'];
            $stazione_destinazione = $_SESSION['stazione_destinazione'];
            $costo_biglietto = $_SESSION['costo_biglietto'];
            $data_partenza_formatted = $_SESSION['data_partenza'];
            $orario_partenza_formatted = $_SESSION['orario_partenza'];
            $somma_posizione_km = $_SESSION['somma_posizione_km'];
            $tempo_di_percorrenza_formatted = $_SESSION['tempo_di_percorrenza_hhmm'];
            $tempo_di_arrivo_formatted = $_SESSION['tempo_di_arrivo'];
  /*      
        echo 'nome: ' . htmlspecialchars($nome) . '<br>';
        echo 'cognome: ' . htmlspecialchars($cognome) . '<br>';
        echo 'stazione partenza: ' . htmlspecialchars($stazione_partenza) . '<br>';
        echo 'stazione destinazione: ' . htmlspecialchars($stazione_destinazione) . '<br>';
        echo 'costo biglietto: ' . htmlspecialchars($costo_biglietto) . '<br>';
        echo 'data partenza: ' . htmlspecialchars($data_partenza) . '<br>';
        echo 'orario partenza: ' . htmlspecialchars($orario_partenza) . '<br>';
        echo 'somma posizione km: ' . htmlspecialchars($somma_posizione_km) . '<br>';
        echo 'tempo di percorrenza hhmm: ' . htmlspecialchars($tempo_di_percorrenza_hhmm) . '<br>';
        echo 'tempo di arrivo: ' . htmlspecialchars($tempo_di_arrivo) . '<br>';
*/

            
            $stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, data_partenza, orario_partenza, tempo_arrivo, tempo_percorrenza) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :data_partenza, :orario_partenza, :tempo_arrivo, :tempo_percorrenza)");

            $stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
            $stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
            $stmt->bindParam(':id_stazione_partenza', $stazione_partenza, PDO::PARAM_INT);
            $stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione, PDO::PARAM_INT);
            $stmt->bindParam(':data_partenza', $data_partenza_formatted, PDO::PARAM_STR);
            $stmt->bindParam(':orario_partenza', $orario_partenza_formatted, PDO::PARAM_STR);
            $stmt->bindParam(':tempo_arrivo', $tempo_di_arrivo_formatted, PDO::PARAM_STR);
            $stmt->bindParam(':tempo_percorrenza', $tempo_di_percorrenza_formatted, PDO::PARAM_STR);

        try {
            $stmt->execute();

            $id_tratta = $db->lastInsertId();
            $_SESSION['id_tratta'] = $id_tratta;
            
            header('location: ./prenotazione.php');
            exit();
        } catch (PDOException $e) {
            header('location: ./Errore.html');
            exit();
        }

    



?>
