<?php

/*------------------------------
CONNESSIONE PDO
-------------------------------*/

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'train_station';

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print 'ERRORE!: ' . $e->getMessage() . '<br>';
    die();
}

/*------------------------------
REGISTRAZIONE UTENTE DA PAGINA DI REGISTRAZIONE
-------------------------------*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $query_verifica = $db->prepare('SELECT COUNT(*) FROM utente WHERE email = :email');
    $query_verifica->bindParam(':email', $email, PDO::PARAM_STR);
    $query_verifica->execute();
    $utente_esiste = $query_verifica->fetchColumn();

    if ($utente_esiste) {
        
        header('location: ./registrazioneErroreUtenteEsistente.html');
        exit();
    }

    
    $query_inserimento = $db->prepare('INSERT INTO utente (nome, cognome, email, password) VALUES (:nome, :cognome, :email, :password)');
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
