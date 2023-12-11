<?php
include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $urlInviante = $data['url_inviante'];
    $urlRisposta = $data['url_risposta'];
    $idEsercente = $data['id_esercente'];
    $idTransazione = $data['id_transazione'];
    $descrizioneBene = $data['descrizione_bene'];
    $prezzoTransazione = $data['prezzo_transazione'];

    // Esempio di logica di business per la gestione della transazione
    $esitoTransazione = effettuaTransazione($idEsercente, $idTransazione, $prezzoTransazione);

    // Aggiornamento del saldo nella tabella conto_corrente
    $saldoAggiornato = aggiornaSaldo($idEsercente, $prezzoTransazione);

    if ($saldoAggiornato) {
        // Risposta al chiamante
        $response = array(
            'url_inviante' => $urlInviante,
            'id_transazione' => $idTransazione,
            'esito_transazione' => $esitoTransazione
        );

        // Invia la risposta
        echo json_encode($response);
    } else {
        // Errore nell'aggiornamento del saldo
        echo json_encode(array('error' => 'Errore durante l\'aggiornamento del saldo.'));
    }
}

// Funzione di esempio per la gestione della transazione
function effettuaTransazione($idEsercente, $idTransazione, $prezzoTransazione) {
    // Implementa qui la logica di business per la gestione della transazione
    // Ad esempio, verifica l'id esercente, l'id transazione, il prezzo, ecc.
    
    // Restituisce un esito di transazione di esempio
    return 'okok';
}

// Funzione per l'aggiornamento del saldo nella tabella conto_corrente
function aggiornaSaldo($idEsercente, $prezzoTransazione) {
    global $conn;

    // Esegue l'aggiornamento del saldo
    $sql = "UPDATE conto_corrente SET Saldo = Saldo - $prezzoTransazione WHERE UserID = $idEsercente";

    return $conn->query($sql);
}

$conn->close();
?>
