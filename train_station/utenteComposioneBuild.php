<?php

    /*------------------------------
    CONNESIONE PDO
    -------------------------------*/

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "train_station";

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "ERRORE!: " . $e->getMessage() . "<br>";
        die();
    }

    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';

    $_SESSION['id_carrozza'] = isset($_POST['carrozza']) ? $_POST['carrozza'] : '';
    $_SESSION['id_locomotiva'] = isset($_POST['locomotiva']) ? $_POST['locomotiva'] : '';
    
    

    $nome_carrozza = isset($_SESSION['id_carrozza']) ? $_SESSION['id_carrozza'] : '';
    $nome_locomotiva = isset($_SESSION['id_locomotiva']) ? $_SESSION['id_locomotiva'] : '';
    $dati_carrozza_originale = $nome_carrozza;


    $sql_carrozza = "SELECT serie_carrozza FROM carrozza WHERE id_carrozza = :id_carrozza";
    $stmt_carrozza = $db->prepare($sql_carrozza);
    $stmt_carrozza->bindParam(':id_carrozza', $nome_carrozza, PDO::PARAM_STR);
    $stmt_carrozza->execute();
    $dati_carrozza = $stmt_carrozza->fetch(PDO::FETCH_ASSOC);
    $nome_carrozza = $dati_carrozza['serie_carrozza'];

    $sql_locomotiva = "SELECT tipo_locomotiva FROM locomotiva WHERE id_locomotiva = :id_locomotiva";
    $stmt_locomotiva = $db->prepare($sql_locomotiva);
    $stmt_locomotiva->bindParam(':id_locomotiva', $nome_locomotiva, PDO::PARAM_STR);
    $stmt_locomotiva->execute();
    $dati_locomotiva = $stmt_locomotiva->fetch(PDO::FETCH_ASSOC);
    $nome_locomotiva = $dati_locomotiva['tipo_locomotiva'];

    $sql_posti_carrozza = "SELECT numero_posti FROM carrozza WHERE id_carrozza = :id_carrozza";
    $stmt_posti_carrozza = $db->prepare($sql_posti_carrozza);
    $stmt_posti_carrozza->bindParam(':id_carrozza', $dati_carrozza_originale, PDO::PARAM_STR);
    $stmt_posti_carrozza->execute();
    $dati_posti_carrozza = $stmt_posti_carrozza->fetch(PDO::FETCH_ASSOC);
    $numero_posti_carrozza = $dati_posti_carrozza['numero_posti'];



    /*------------------------------
    SALVA COMPOSIZIONE TRENO
    -------------------------------*/


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data_p = $_POST['data-partenza'];
        $data_a = $_POST['data-ritorno'];
        $orario_p = $_POST['orario-partenza'];
        $orario_a = $_POST['orario-arrivo'];

        echo 'nome: ' . htmlspecialchars($nome) . '<br>';
        echo 'cognome: ' . htmlspecialchars($cognome) . '<br>';
        echo 'nome_locomotiva: ' . htmlspecialchars($nome_locomotiva) . '<br>';
        echo 'nome_carrozza: ' . htmlspecialchars($nome_carrozza) . '<br>';
        echo 'numero_posti_carrozza: ' . htmlspecialchars($numero_posti_carrozza) . '<br>';
        echo 'Data di partenza: ' . htmlspecialchars($_POST['data-partenza']) . '<br>';
        echo 'Data di ritorno: ' . htmlspecialchars($_POST['data-ritorno']) . '<br>';
        echo 'orario-partenza: ' . htmlspecialchars($_POST['orario-partenza']) . '<br>';
        echo 'orario-arrivo: ' . htmlspecialchars($_POST['orario-arrivo']) . '<br>';






        $nome_carrozza = isset($_POST['carrozza']) ? $_POST['carrozza'] : null;
        $nome_locomotiva = isset($_POST['locomotiva']) ? $_POST['locomotiva'] : null;
        
        // Check if either nome_carrozza or nome_locomotiva is empty
        if (empty($nome_carrozza) || empty($nome_locomotiva)) {
            echo 'Nome carrozza e nome locomotiva sono obbligatori';
            exit;
        }

    //    try {
    //        // Insert into treno table
    //        $query = $db->prepare("INSERT INTO treno (nome_treno) VALUES (:nome_treno)");
    //        $nome_treno = $nome_carrozza . ' ' . $nome_locomotiva . ' ' . $data_a . ' ' . $data_p . ' ' . $orario_p . ' ' . $orario_a;
    //        $query->bindParam(':nome_treno', $nome_treno, PDO::PARAM_STR);
    //        $query->execute();
        
            // Redirect to the specified page after successful insertion
    //        header("location: ./utenteComposizioneEffettuata.html");
    //        exit();
    //    } catch (PDOException $e) {
    //        echo 'Errore durante l\'inserimento nel database: ' . $e->getMessage();
    //        exit();
    //    }
    }


?>
