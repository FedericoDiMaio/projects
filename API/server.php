<?php
session_start();
include "./connessionePDO.php";
include "../pay_stream/connessionePDO2.php";
$id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';

if (isset($_POST['url_inviante'], $_POST['url_risposta'], $_POST['id_esercente'], $_POST['id_transazione'], $_POST['descrizione_bene'], $_POST['prezzo_transazione'])) {

    $urlInviante = $_POST['url_inviante'];
    $urlRisposta = $_POST['url_risposta'];
    $idEsercente = $_POST['id_esercente'];
    $idTransazione = $_POST['id_transazione'];
    $descrizioneBene = $_POST['descrizione_bene'];
    $prezzoTransazione = $_POST['prezzo_transazione'];
    

    $query = "INSERT INTO transazioni_m2m (TransazioneM2MID, URLInviante, URLRisposta, EsercenteID, Descrizione, PrezzoTransazione) 
              VALUES (:idTransazione, :urlInviante, :urlRisposta, :idEsercente, :descrizioneBene, :prezzoTransazione)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':idTransazione', $idTransazione, PDO::PARAM_INT);
    $stmt->bindParam(':urlInviante', $urlInviante, PDO::PARAM_STR);
    $stmt->bindParam(':urlRisposta', $urlRisposta, PDO::PARAM_STR);
    $stmt->bindParam(':idEsercente', $idEsercente, PDO::PARAM_INT);
    $stmt->bindParam(':descrizioneBene', $descrizioneBene, PDO::PARAM_STR);
    $stmt->bindParam(':prezzoTransazione', $prezzoTransazione, PDO::PARAM_STR);

    try {

    
    $queryUpdateSaldo = "UPDATE conto_corrente SET Saldo = Saldo + :prezzoTransazione WHERE UserID = :idEsercente";
    $stmtUpdateSaldo = $db2->prepare($queryUpdateSaldo);
    $stmtUpdateSaldo->bindParam(':prezzoTransazione', $prezzoTransazione, PDO::PARAM_STR);
    $stmtUpdateSaldo->bindParam(':idEsercente', $idEsercente, PDO::PARAM_INT);
    $stmtUpdateSaldo->execute();
    
    $queryUpdateSaldo = "UPDATE conto_corrente SET Saldo = Saldo - :prezzoTransazione WHERE UserID = :id_utente";
    $stmtUpdateSaldo = $db2->prepare($queryUpdateSaldo);
    $stmtUpdateSaldo->bindParam(':prezzoTransazione', $prezzoTransazione, PDO::PARAM_STR);
    $stmtUpdateSaldo->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);
    $stmtUpdateSaldo->execute();

        
        $query_registra_operazione_esercente = $db->prepare('INSERT INTO estratto_conto (UserID, entrate, causale) VALUES (:UserID, :entrate, :causale)');
        $query_registra_operazione_esercente->bindParam(':UserID', $idEsercente, PDO::PARAM_INT);
        $query_registra_operazione_esercente->bindParam(':entrate', $prezzoTransazione, PDO::PARAM_STR);
        $query_registra_operazione_esercente->bindValue(':causale', "Pagamento ricevuto da train station", PDO::PARAM_STR);
        $query_registra_operazione_esercente->execute();
    
       
        $query_registra_operazione_utente = $db->prepare('INSERT INTO estratto_conto (UserID, uscite, causale) VALUES (:UserID, :uscite, :causale)');
        $query_registra_operazione_utente->bindParam(':UserID', $id_utente, PDO::PARAM_INT);
        $query_registra_operazione_utente->bindParam(':uscite', $prezzoTransazione, PDO::PARAM_STR);
        $query_registra_operazione_utente->bindValue(':causale', "biglietto treno", PDO::PARAM_STR);
        $query_registra_operazione_utente->execute();

    


        $stmt->execute();
        http_response_code(200);
        echo "Pagamento effettuato con successo.";
        header("refresh:2;url=../train_station/utenteRegistrato.php");
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Errore durante il salvataggio della transazione: " . $stmt->errorInfo()[2];
    }

} else {
    http_response_code(400);
    echo "Dati mancanti nella richiesta POST.";
}
?>