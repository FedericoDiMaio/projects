<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiamata al Servizio</title>
</head>
<body>
    <h1>Chiamata al Servizio</h1>

    <form method="post" action="server.php">
        <label for="urlInviante">URL Inviante:</label>
        <input type="text" name="url_inviante" id="urlInviante" value="https://localhost/progetti_bdc/projects/pay_stream/client.php" required><br>

        <label for="urlRisposta">URL Risposta:</label>
        <input type="text" name="url_risposta" id="urlRisposta" value="https://localhost/progetti_bdc/projects/pay_stream/server.php" required><br>

        <label for="idEsercente">ID Esercente:</label>
        <input type="text" name="id_esercente" id="idEsercente" value="1" required><br>

        <label for="idTransazione">ID Transazione:</label>
        <input type="text" name="id_transazione" id="idTransazione" value="1" required><br>

        <label for="descrizioneBene">Descrizione Bene:</label>
        <input type="text" name="descrizione_bene" id="descrizioneBene" value="caricamento denaro" required><br>

        <label for="prezzoTransazione">Prezzo Transazione:</label>
        <input type="text" name="prezzo_transazione" id="prezzoTransazione" value="34.00" required><br>

        <button type="submit">Invia Richiesta</button>
    </form>

    <?php
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $urlInviante = $_POST['url_inviante'];
            $urlRisposta = $_POST['url_risposta'];
            $idEsercente = $_POST['id_esercente'];
            $idTransazione = $_POST['id_transazione'];
            $descrizioneBene = $_POST['descrizione_bene'];
            $prezzoTransazione = $_POST['prezzo_transazione'];

            
            $ch = curl_init($urlInviante);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'url_inviante' => $urlInviante,
                'url_risposta' => $urlRisposta,
                'id_esercente' => $idEsercente,
                'id_transazione' => $idTransazione,
                'descrizione_bene' => $descrizioneBene,
                'prezzo_transazione' => $prezzoTransazione,
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            
            $response = curl_exec($ch);

            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode === 200) {
                echo '<p>Transazione avvenuta con successo!</p>';
            } else {
                echo '<p>Errore durante la transazione. Codice HTTP: ' . $httpCode . '</p>';
            }

            
            curl_close($ch);
        }
    ?>
</body>
</html>
