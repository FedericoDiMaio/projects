<?php

include "./connessionePDO.php";
$id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';

$email = $_POST['email'];
$password = $_POST['password'];

$q = $db->prepare("SELECT * FROM utente WHERE email = :email");
$q->bindParam(':email', $email, PDO::PARAM_STR);
$q->execute();
$q->setFetchMode(PDO::FETCH_ASSOC);
$rows = $q->rowCount();

if ($rows > 0) {
    while ($row = $q->fetch()) {
        if (password_verify($password, $row['password'])) {
            // Password corretta
            session_start();
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['cognome'] = $row['cognome'];

            if ($row['ruolo'] === 'registrato') {
                header("location: ./utenteRegistrato.php");
                exit;
            } elseif ($row['ruolo'] === 'amministrativo') {
                header("location: ./utenteAmministrativo.php");
                exit;
            } elseif ($row['ruolo'] === 'esercizio') {
                header("location: ./utenteComposizione.php");
                exit;
            } else {
                header("location: ./loginError.html");
                exit;
            }
        } else {
            
            header("location: ./loginError.html");
            exit;
        }
    }
} else {
    
    echo "Utente non trovato";
}
?>
