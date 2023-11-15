<?php

include "./connessionePDO.php";

$email = $_POST['email'];
$password = $_POST['password'];

$q = $db->prepare("SELECT * FROM utente WHERE email = :email");
$q->bindParam(':email', $email, PDO::PARAM_STR);
$q->execute();
$q->setFetchMode(PDO::FETCH_ASSOC); // fetchiamo e passiamo a rassegna tutte le righe
$rows = $q->rowCount(); // contiamo righe

if ($rows > 0) {
    while ($row = $q->fetch()) {
        session_start();
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['cognome'] = $row['cognome'];

        if ($row['ruolo'] === 'registrato' && $row['password'] === $password) {
            header("location: ./utenteRegistrato.php");
            exit;
        } else if ($row['ruolo'] === 'amministrativo' && $row['password'] === $password) {
            header("location: ./utenteAmministrativo.php");
            exit;
        } else if ($row['ruolo'] === 'esercizio' && $row['password'] === $password) {
            header("location: ./utenteComposizione.php");
            exit;
        } else {
            header("location: ./loginError.html");
            exit;
        }
    }
} else {
    echo "Utente non trovato";
}
