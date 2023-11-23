<?php

include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_di_nascita = $_POST['data_di_nascita'];
    $codice_fiscale = $_POST['codice_fiscale'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se il codice fiscale è valido
    if (!verificaCodiceFiscale($codice_fiscale)) {
        header('location: ./registrazioneErroreCodiceFiscale.html');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query_verifica = $db->prepare('SELECT COUNT(*) FROM utenti_registrati WHERE email = :email');
    $query_verifica->bindParam(':email', $email, PDO::PARAM_STR);
    $query_verifica->execute();
    $utente_esiste = $query_verifica->fetchColumn();

    if ($utente_esiste) {
        header('location: ./registrazioneErroreUtenteEsistente.html');
        exit();
    }

    // Inizio della transazione
    $db->beginTransaction();

    try {
        // Inserimento dell'utente nella tabella utenti_registrati
        $query_inserimento_utente = $db->prepare('INSERT INTO utenti_registrati (nome, cognome, data_di_nascita, codice_fiscale, email, password) VALUES (:nome, :cognome, :data_di_nascita, :codice_fiscale, :email, :password)');
        $query_inserimento_utente->bindParam(':nome', $nome, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':data_di_nascita', $data_di_nascita, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':codice_fiscale', $codice_fiscale, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':email', $email, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $query_inserimento_utente->execute();

        // Ottieni l'ID dell'utente appena inserito
        $lastInsertedUserId = $db->lastInsertId();
        
        // Inserimento dell'utente nella tabella conto_corrente
        $query_inserimento_conto = $db->prepare('INSERT INTO conto_corrente (UserID, Saldo) VALUES (:UserID, 0.00)');
        $query_inserimento_conto->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_conto->execute();

        // Inserimento della carta di credito associata all'utente
        $numeroCarta = $_POST['numero_carta']; // Assumi che ci sia un campo numero_carta nel tuo modulo di registrazione
        $query_inserimento_carta = $db->prepare('INSERT INTO carte_di_credito (UserID, NumeroCarta) VALUES (:UserID, :NumeroCarta)');
        $query_inserimento_carta->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_carta->bindParam(':NumeroCarta', $numeroCarta, PDO::PARAM_STR);
        $query_inserimento_carta->execute();

        // Commit della transazione
        $db->commit();

        header('location: ./registrazioneEffettuata.html');
        exit();
    } catch (PDOException $e) {
        // Rollback della transazione in caso di errore
        $db->rollBack();
        header('location: ./registrazioneErrore.html');
        exit();
    }
}

function verificaCodiceFiscale($codice_fiscale) {

    return preg_match('/^[A-Z]{6}\d{2}[ABCDEHLMPRST]{1}\d{2}[A-Z]\d{3}[A-Z]$/', $codice_fiscale);
}
?>
