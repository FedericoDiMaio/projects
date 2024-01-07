<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chiamata al Servizio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
</head>

<?php
session_start();
$id_tratta = isset($_SESSION['id_tratta']) ? $_SESSION['id_tratta'] : null;
$id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';

$costo_biglietto_format = $_SESSION['costo_biglietto_format'];

include "./connessionePDO.php";
    // Controlla se il modulo è stato inviato
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Dati da inviare al servizio
        $urlInviante = isset($_POST['url_inviante']) ? $_POST['url_inviante'] : '';
        $urlRisposta = isset($_POST['url_risposta']) ? $_POST['url_risposta'] : '';
        $idEsercente = isset($_POST['id_esercente']) ? $_POST['id_esercente'] : '';
        $idTransazione = isset($_POST['id_transazione']) ? $_POST['id_transazione'] : '';
        $descrizioneBene = isset($_POST['descrizione_bene']) ? $_POST['descrizione_bene'] : '';
        $prezzoTransazione = isset($_POST['prezzo_transazione']) ? $_POST['prezzo_transazione'] : '';

        // Configura la richiesta POST con cURL
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

        // Esegui la richiesta
        $response = curl_exec($ch);

        // Verifica se la risposta è un codice 200
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 200) {
            echo '<p>Transazione avvenuta con successo!</p>';
        } else {

        }

        // Chiudi la connessione cURL
        curl_close($ch);
    }


    ?>
<body>
    <h1>Chiamata al Servizio</h1>

    <form method="post" action="server.php">

        <label for="urlInviante">URL Inviante:</label>
        <input type="text" name="url_inviante" id="urlInviante" value = "https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/client.php" required><br>

        <label for="urlRisposta">URL Risposta:</label>
        <input type="text" name="url_risposta" id="urlRisposta" value = "https://webstudenti.unimarconi.it/f.dimaio/projects/train_station/server.php" required><br>

        <label for="idEsercente">ID Esercente:</label>
        <input type="text" name="id_esercente" id="idEsercente" value = "1" required><br>

        <label for="idTransazione">ID Transazione:</label>
        <input type="text" name="id_transazione" id="idTransazione" value="<?php echo bin2hex(random_bytes(8)); ?>" required><br>


        <label for="descrizioneBene">Descrizione Bene:</label>
        <input type="text" name="descrizione_bene" id="descrizioneBene" value = "biglietto treno" required><br>

        <label for="prezzoTransazione">Prezzo Transazione:</label>
        <input type="text" name="prezzo_transazione" id="prezzoTransazione" value ="<?php echo $costo_biglietto_format?>" required><br>

        <button type="submit">Invia Richiesta</button>

    </form>


</body>
</html>