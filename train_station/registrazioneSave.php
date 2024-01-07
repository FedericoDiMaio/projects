<?php

include "./connessionePDO.php";
include "../pay_stream/connessionePDO2.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_di_nascita = $_POST['data_di_nascita'];
    $codice_fiscale = $_POST['codice_fiscale'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conferma_password = $_POST["conferma_password"];

    if ($password != $conferma_password) {
        echo "Le password non coincidono riprova ad effettuare la registrazione";
        exit();
    }
    function verificaCodiceFiscale($codice_fiscale) {
        return preg_match('/^[A-Z]{6}\d{2}[ABCDEHLMPRST]{1}\d{2}[A-Z]\d{3}[A-Z]$/', $codice_fiscale);
    }

    if (!verificaCodiceFiscale($codice_fiscale)) {
        header('location: ./registrazioneErroreCodiceFiscale.html');
        exit();
    }
    

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $query_verifica = $db->prepare('SELECT COUNT(*) FROM utenti_registrati_train WHERE email = :email');
    $query_verifica->bindParam(':email', $email, PDO::PARAM_STR);
    $query_verifica->execute();
    $utente_esiste = $query_verifica->fetchColumn();

    if ($utente_esiste) {

        header('location: ./registrazioneErroreUtenteEsistente.html');
        exit();
    }


    $query_inserimento = $db->prepare('INSERT INTO utenti_registrati_train (nome, cognome, data_di_nascita, codice_fiscale, email, password) VALUES (:nome, :cognome, :data_di_nascita, :codice_fiscale, :email, :password)');
    $query_inserimento->bindParam(':nome', $nome, PDO::PARAM_STR);
    $query_inserimento->bindParam(':cognome', $cognome, PDO::PARAM_STR);
    $query_inserimento->bindParam(':data_di_nascita', $data_di_nascita, PDO::PARAM_STR);
    $query_inserimento->bindParam(':codice_fiscale', $codice_fiscale, PDO::PARAM_STR);
    $query_inserimento->bindParam(':email', $email, PDO::PARAM_STR);
    $query_inserimento->bindParam(':password', $hashed_password, PDO::PARAM_STR);

    $query_inserimento_pay = $db2->prepare('INSERT INTO utenti_registrati (nome, cognome, data_di_nascita, codice_fiscale, email, password) VALUES (:nome, :cognome, :data_di_nascita, :codice_fiscale, :email, :password)');
    $query_inserimento_pay->bindParam(':nome', $nome, PDO::PARAM_STR);
    $query_inserimento_pay->bindParam(':cognome', $cognome, PDO::PARAM_STR);
    $query_inserimento_pay->bindParam(':data_di_nascita', $data_di_nascita, PDO::PARAM_STR);
    $query_inserimento_pay->bindParam(':codice_fiscale', $codice_fiscale, PDO::PARAM_STR);
    $query_inserimento_pay->bindParam(':email', $email, PDO::PARAM_STR);
    $query_inserimento_pay->bindParam(':password', $hashed_password, PDO::PARAM_STR);

 

    try {
        $query_inserimento->execute();
        $query_inserimento_pay->execute();
    
        
        $lastInsertedUserId = $db2->lastInsertId();
    
        $query_inserimento_conto = $db2->prepare('INSERT INTO conto_corrente (UserID, Saldo) VALUES (:UserID, 0.00)');
        $query_inserimento_conto->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_conto->execute();

        function generaNumeroCarta() {
            $numeroCarta = '4'; 
            
           
            for ($i = 0; $i < 15; $i++) {
                $numeroCarta .= rand(0, 9);
            }
        
            return $numeroCarta;
        }
        
        $numeroCarta = generaNumeroCarta(); 
    
        
        $query_inserimento_carta = $db2->prepare('INSERT INTO carte_di_credito (UserID, NumeroCarta) VALUES (:UserID, :NumeroCarta)');
        $query_inserimento_carta->bindParam(':UserID', $lastInsertedUserId, PDO::PARAM_INT);
        $query_inserimento_carta->bindParam(':NumeroCarta', $numeroCarta, PDO::PARAM_STR);
        $query_inserimento_carta->execute();
    
        header('location: ./registrazioneEffettuata.html');
        exit();
    } catch (PDOException $e) {
        header('location: ./registrazioneErrore.html');
        exit();
    }
    
}
?>
