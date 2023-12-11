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

    // Verifica se l'utente esiste già
    $query_verifica = $db->prepare('SELECT COUNT(*) FROM utenti_registrati WHERE email = :email');
    $query_verifica->bindParam(':email', $email, PDO::PARAM_STR);
    $query_verifica->execute();

    if ($query_verifica->fetchColumn()) {
        header('location: ./registrazioneErroreUtenteEsistente.html');
        exit();
    }

    
    $db->beginTransaction();

    try {
        
        $query_inserimento_utente = $db->prepare('INSERT INTO utenti_registrati (nome, cognome, data_di_nascita, codice_fiscale, email, password) VALUES (:nome, :cognome, :data_di_nascita, :codice_fiscale, :email, :password)');
        $query_inserimento_utente->bindParam(':nome', $nome, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':data_di_nascita', $data_di_nascita, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':codice_fiscale', $codice_fiscale, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':email', $email, PDO::PARAM_STR);
        $query_inserimento_utente->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $query_inserimento_utente->execute();

        
        $lastInsertedUserId = $db->lastInsertId();

        
        $query_inserimento_conto = $db->prepare('INSERT INTO conto_corrente (UserID, Saldo) VALUES (:UserID, 0.00)');
        $query_inserimento_conto->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_conto->execute();

        
        $numeroCarta = generaNumeroCarta(); 
        $query_inserimento_carta = $db->prepare('INSERT INTO carte_di_credito (UserID, NumeroCarta) VALUES (:UserID, :NumeroCarta)');
        $query_inserimento_carta->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_carta->bindParam(':NumeroCarta', $numeroCarta, PDO::PARAM_STR);
        $query_inserimento_carta->execute();

        
        $db->commit();

        header('location: ./registrazioneEffettuata.html');
        exit();
    } catch (PDOException $e) {
        
        $db->rollBack();
        header('location: ./registrazioneErrore.html');
        exit();
    }
}

function verificaCodiceFiscale($codice_fiscale) {
    return preg_match('/^[A-Z]{6}\d{2}[ABCDEHLMPRST]{1}\d{2}[A-Z]\d{3}[A-Z]$/', $codice_fiscale);
}

function generaNumeroCarta() {
    $numeroCarta = '4'; 
    
   
    for ($i = 0; $i < 15; $i++) {
        $numeroCarta .= rand(0, 9);
    }

    return $numeroCarta;
}
?>
