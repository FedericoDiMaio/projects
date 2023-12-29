<?php

include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conferma_password = $_POST["conferma_password"];

    if ($password != $conferma_password) {
        echo "Le password non coincidono riprova ad effettuare la registrazione";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $query_verifica = $db->prepare('SELECT COUNT(*) FROM utenti_registrati_tr WHERE email = :email');
    $query_verifica->bindParam(':email', $email, PDO::PARAM_STR);
    $query_verifica->execute();
    $utente_esiste = $query_verifica->fetchColumn();

    if ($utente_esiste) {

        header('location: ./registrazioneErroreUtenteEsistente.html');
        exit();
    }


    $query_inserimento = $db->prepare('INSERT INTO utenti_registrati_tr (nome, cognome, email, password) VALUES (:nome, :cognome, :email, :password)');
    $query_inserimento->bindParam(':nome', $nome, PDO::PARAM_STR);
    $query_inserimento->bindParam(':cognome', $cognome, PDO::PARAM_STR);
    $query_inserimento->bindParam(':email', $email, PDO::PARAM_STR);
    $query_inserimento->bindParam(':password', $hashed_password, PDO::PARAM_STR);

    try {
        $query_inserimento->execute();
        header('location: ./registrazioneEffettuata.html');
        exit();
    } catch (PDOException $e) {
        header('location: ./registrazioneErrore.html');
        exit();
    }
}
?>
