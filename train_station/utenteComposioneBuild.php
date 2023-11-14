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

    $id_carrozze = $_SESSION['id_carrozza'];
    $id_locomotive = $_SESSION['id_locomotiva'];

    $_SESSION['id_carrozza'] = isset($_POST['carrozza']) ? $_POST['carrozza'] : 'array()';
    $_SESSION['id_locomotiva'] = isset($_POST['locomotiva']) ? $_POST['locomotiva'] : 'array()';
    
    $sql_carrozze = "SELECT id_carrozza, numero_posti FROM carrozza WHERE id_carrozza IN (" . implode(',', array_fill(0, count($id_carrozze), '?')) . ")";
    $stmt_carrozze = $db->prepare($sql_carrozze);
    $stmt_carrozze->execute($id_carrozze);
    $dati_carrozze = $stmt_carrozze->fetchAll(PDO::FETCH_ASSOC);

    $numero_posti_totale = array_sum(array_column($dati_carrozze, 'numero_posti'));



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data_inizio_servizio = $_POST['data_inizio_servizio'];
        $data_fine_servizio = $_POST['data_fine_servizio'];
    }

    echo 'data inizio servizio: ' . htmlspecialchars($data_inizio_servizio) . '<br>';
    echo 'data fine servizio: ' . htmlspecialchars($data_fine_servizio) . '<br>';
    echo 'numero posti totali: ' . htmlspecialchars($numero_posti_totale) . '<br>';
    echo 'id locomotiva: ' . htmlspecialchars(implode(', ', $id_locomotive)) . '<br>';
    echo 'id carrozza: ' . htmlspecialchars(implode(', ', $id_carrozze)) . '<br>';
    


     try {
        $query = $db->prepare("INSERT INTO carrozza_treno (id_carrozza, id_locomotiva, numero_posti_totale, data_inizio_servizio, data_fine_servizio) 
                               VALUES (:id_carrozza, :id_locomotiva, :numero_posti_totale, :data_inizio_servizio, :data_fine_servizio)");

        $query->bindParam(':id_carrozza', $id_carrozze, PDO::PARAM_INT); 
        $query->bindParam(':id_locomotiva', $id_locomotive, PDO::PARAM_INT); 


        $query->bindParam(':numero_posti_totale', $numero_posti_totale, PDO::PARAM_INT);
        $query->bindParam(':data_inizio_servizio', $data_inizio_servizio, PDO::PARAM_STR);
        $query->bindParam(':data_fine_servizio', $data_fine_servizio, PDO::PARAM_STR);

        $query->execute();

        // Redirect alla pagina specificata dopo l'inserimento
        header("location: ./utenteComposizioneEffettuata.html");
        exit();
    } catch (PDOException $e) {
        echo 'Errore durante l\'inserimento nel database: ' . $e->getMessage();
        exit();
    }


    ?>
