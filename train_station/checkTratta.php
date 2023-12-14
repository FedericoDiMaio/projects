<?php
session_start();
include "./connessionePDO.php";

$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
$id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';
$stazione_partenza = $_SESSION['stazione_partenza'];
$stazione_destinazione = $_SESSION['stazione_destinazione'];
$costo_biglietto = $_SESSION['costo_biglietto'];
$data_orario_partenza = $_SESSION['data_orario_partenza'];
$orario_partenza = $_SESSION['orario_partenza'];
$somma_posizione_km = $_SESSION['somma_posizione_km'];
$tempo_di_percorrenza_hhmm = $_SESSION['tempo_di_percorrenza_hhmm'];
$tempo_di_arrivo = $_SESSION['tempo_di_arrivo'];
$data_partenza_formatted = $_SESSION['data_partenza_formatted'];
$orario_partenza_formatted = $_SESSION['orario_partenza_formatted'];


$orario_partenza = new DateTime();
$data_orario_partenza = new DateTime();
$tempo_arrivo = new DateTime();
$tempo_percorrenza = new DateTime();

$stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, data_orario_partenza, id_utente) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :data_orario_partenza, :id_utente)");

$stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
$stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
$stmt->bindParam(':id_stazione_partenza', $stazione_partenza, PDO::PARAM_INT);
$stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione, PDO::PARAM_INT);
$stmt->bindParam(':data_orario_partenza', $data_orario_partenza->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);


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
