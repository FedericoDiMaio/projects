<?php
session_start();
include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $importoDaInserire = isset($_POST['inserisci_denaro']) ? $_POST['inserisci_denaro'] : '';
    $importoDaInserire = filter_var($importoDaInserire, FILTER_VALIDATE_FLOAT);

    

    if ($importoDaInserire === false || $importoDaInserire <= 0) {
        header('location: ./erroreInserimentoDenaro.html');
        exit();
    }

    $db->beginTransaction();

    try {
        $query_aggiorna_saldo = $db->prepare('UPDATE conto_corrente SET Saldo = Saldo + :importoDaInserire WHERE UserID = :UserID');
        $query_aggiorna_saldo->bindParam(':importoDaInserire', $importoDaInserire, PDO::PARAM_STR);
        $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
        $query_aggiorna_saldo->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $query_aggiorna_saldo->execute();

 
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
