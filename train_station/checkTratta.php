<?php
session_start();
include "./connessionePDO.php";

$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
$id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';
$stazione_partenza = $_SESSION['stazione_partenza'];
$stazione_destinazione = $_SESSION['stazione_destinazione'];
$costo_biglietto = $_SESSION['costo_biglietto'];
//$data_orario_partenza = $_SESSION['data_orario_partenza'];
$orario_partenza = $_SESSION['orario_partenza'];
$somma_posizione_km = $_SESSION['somma_posizione_km'];
$tempo_di_percorrenza_hhmm = $_SESSION['tempo_di_percorrenza_hhmm'];
$tempo_di_arrivo = $_SESSION['tempo_di_arrivo'];
$data_partenza_formatted = $_SESSION['data_partenza_formatted'];
$orario_partenza_formatted = $_SESSION['orario_partenza_formatted'];
$id_treno_selezionato = $_SESSION['id_treno_selezionato'];

echo "id". $id_utente;
echo "somma posizione km".$somma_posizione_km;
echo "stazione partenza".$stazione_partenza;
echo "stazione destinazione".$stazione_destinazione;
echo "costo biglietto".$costo_biglietto;

if (!empty($id_treno_selezionato)) {
    try {
        // Prepare and execute the query
        $query = "SELECT numero_posti_totale FROM composizione_treno WHERE id_treno = :id_treno";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_treno', $id_treno_selezionato, PDO::PARAM_INT);
        $stmt->execute();

        // Recupera il risultato
    $numero_posti_totale = $stmt->fetchColumn();

    // Salva il risultato in una variabile di sessione
    $_SESSION['numero_posti_totale'] = $numero_posti_totale;

    // Verifica se esistono posti disponibili non ancora assegnati
    if (!isset($_SESSION['posti_assegnati'])) {
        $_SESSION['posti_assegnati'] = array();
    }

    // Assegna un posto in maniera automatica
    do {
        $posto_assegnato = rand(1, $_SESSION['numero_posti_totale']);
    } while (in_array($posto_assegnato, $_SESSION['posti_assegnati']));
    
    $_SESSION['posto_assegnato'] = $posto_assegnato;
    // Aggiungi il posto assegnato all'array dei posti assegnati
    $_SESSION['posti_assegnati'][] = $posto_assegnato;

    } catch (PDOException $e) {
        header('location: ./Errore1.html');
        exit();
    }
}


$orario_partenza = new DateTime();
$data_orario_partenza = new DateTime();
$tempo_arrivo = new DateTime();
$tempo_percorrenza = new DateTime();

echo "data orario partenza".$data_orario_partenza->format('Y-m-d H:i:s');
echo "posto assegnato".$posto_assegnato;

$stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, data_orario_partenza, id_utente, posto) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :data_orario_partenza, :id_utente, :posto)");

$stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
$stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
$stmt->bindParam(':id_stazione_partenza', $stazione_partenza, PDO::PARAM_INT);
$stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione, PDO::PARAM_INT);
$stmt->bindParam(':data_orario_partenza', $data_orario_partenza->format('Y-m-d H:i:s'), PDO::PARAM_STR);
$stmt->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);
$stmt->bindParam(':posto', $posto_assegnato, PDO::PARAM_INT);



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
