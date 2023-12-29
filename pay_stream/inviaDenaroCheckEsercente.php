<?php
session_start();
include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $importoDaInviare = isset($_POST['invia_denaro_check']) ? $_POST['invia_denaro_check'] : '';
    $importoDaInviare = filter_var($importoDaInviare, FILTER_VALIDATE_FLOAT);

    $causale = isset($_POST['causale']) ? $_POST['causale'] : '';

    if ($importoDaInviare === false || $importoDaInviare <= 0) {
        header('location: ./erroreInserimentoDenaro.html');
        exit();
    }

    $db->beginTransaction();

    try {
        $query_aggiorna_saldo = $db->prepare('UPDATE conto_corrente SET Saldo = Saldo - :invia_denaro_check WHERE UserID = :UserID');
        $query_aggiorna_saldo->bindParam(':invia_denaro_check', $importoDaInviare, PDO::PARAM_STR);
        $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
        $query_aggiorna_saldo->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $query_aggiorna_saldo->execute();

        $query_registra_operazione = $db->prepare('INSERT INTO estratto_conto (UserID, uscite, causale) VALUES (:UserID, :uscite, :causale)');
        $query_registra_operazione->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $query_registra_operazione->bindParam(':uscite', $importoDaInviare, PDO::PARAM_STR);
        $query_registra_operazione->bindParam(':causale', $causale, PDO::PARAM_STR);
        $query_registra_operazione->execute();

        $db->commit();

        header('location: ./esercente.php');
        exit();
    } catch (PDOException $e) {
        $db->rollBack();
        header('location: ./erroreInserimentoDenaro.html');
        exit();
    }
}
?>
