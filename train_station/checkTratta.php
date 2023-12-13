<?php
session_start();
include "./connessionePDO.php";



$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
$stazione_partenza = $_SESSION['stazione_partenza'];
$stazione_destinazione = $_SESSION['stazione_destinazione'];
$costo_biglietto = $_SESSION['costo_biglietto'];
$data_partenza = $_SESSION['data_partenza'];
$orario_partenza = $_SESSION['orario_partenza'];
$somma_posizione_km = $_SESSION['somma_posizione_km'];
$tempo_di_percorrenza_hhmm = $_SESSION['tempo_di_percorrenza_hhmm'];
$tempo_di_arrivo = $_SESSION['tempo_di_arrivo'];
$data_partenza_formatted = $_SESSION['data_partenza_formatted'];
$orario_partenza_formatted = $_SESSION['orario_partenza_formatted'];

echo 'Stazione di partenza: ' . $stazione_partenza . '<br>';
echo 'Stazione di destinazione: ' . $stazione_destinazione . '<br>';
echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
echo 'Data di partenza: ' . $data_partenza . '<br>';
echo 'Orario di partenza: ' . $orario_partenza . '<br>';
echo 'Somma posizione km destinazione: ' . $somma_posizione_km . '<br>';
echo 'Tempo di percorrenza HH:MM = ' . $tempo_di_percorrenza_hhmm . '<br>';
echo 'Tempo di arrivo: ' . $tempo_di_arrivo . '<br>';
echo 'Data partenza: ' . $data_partenza_formatted . '<br>';
echo 'Orario partenza: ' . $orario_partenza_formatted . '<br>';

$orario_partenza = new DateTime();
$data_partenza = new DateTime();
$tempo_arrivo = new DateTime();
$tempo_percorrenza = new DateTime();

$stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, orario_partenza, data_partenza, tempo_arrivo, tempo_percorrenza) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :orario_partenza, :data_partenza, :tempo_arrivo, :tempo_percorrenza)");

$stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
$stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
$stmt->bindParam(':id_stazione_partenza', $stazione_partenza, PDO::PARAM_INT);
$stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione, PDO::PARAM_INT);
$stmt->bindParam(':orario_partenza', $orario_partenza->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->bindParam(':data_partenza', $data_partenza->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->bindParam(':tempo_arrivo', $tempo_arrivo->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->bindParam(':tempo_percorrenza', $tempo_percorrenza->format('Y-m-d H:i:s'), PDO::PARAM_STR);

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
