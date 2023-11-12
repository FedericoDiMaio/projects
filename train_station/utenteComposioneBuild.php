<?php

    /*------------------------------
    CONNESIONE PDO
    -------------------------------*/

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "train_station";

    try {
        $db = new PDO("mysql:=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "ERRORE!: " . $e->getMessage() . "<br>";
        die();
    }

    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';

    /*------------------------------
    SALVA COMPOSIZIONE TRENO
    -------------------------------*/


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome_carrozza = isset($_POST['nome_carrozza']) ? $_POST['nome_carrozza'] : null;
        $nome_locomotiva = isset($_POST['nome_locomotiva']) ? $_POST['nome_locomotiva'] : null;

        // Check if either nome_carrozza or nome_locomotiva is empty
        if (empty($nome_carrozza) || empty($nome_locomotiva)) {
            echo 'Nome carrozza e nome locomotiva sono obbligatori';
            exit;
        }

        try {
            // Insert into treno table
            $query = $db->prepare("INSERT INTO treno (nome_carrozza, nome_locomotiva) VALUES (:nome_treno)");
            $query->bindParam(':nome_carrozza', $nome_carrozza, PDO::PARAM_STR);
            $query->bindParam(':nome_locomotiva', $nome_locomotiva, PDO::PARAM_STR);
            $query->execute();

            // Redirect to the specified page after successful insertion
            header("location: ../../composizione_treno/eserciziocomposizione.php");
            exit();
        } catch (PDOException $e) {
            echo 'Errore durante l\'inserimento nel database: ' . $e->getMessage();
            exit();
        }
    }


?>
