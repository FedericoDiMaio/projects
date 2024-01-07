<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo Amministrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
</head>



<body>

    <?php

    include "./connessionePDO.php";

    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $locomotive_selezionate = isset($_POST['id_locomotiva']) ? (array) $_POST['id_locomotiva'] : array();

        if (empty($locomotive_selezionate)) {
            echo 'Seleziona almeno una locomotiva';
            exit;
        }

        echo 'Locomotive selezionate: ';
        foreach ($locomotive_selezionate as $locomotiva) {

            $sql_locomotiva = "SELECT * FROM locomotiva WHERE id_locomotiva = :id";
            $stmt_locomotiva_composizione = $db->prepare($sql_locomotiva);
            $stmt_locomotiva_composizione->bindValue(':id', $locomotiva, PDO::PARAM_INT);
            $stmt_locomotiva_composizione->execute();

            $dati_locomotiva = $stmt_locomotiva_composizione->fetch(PDO::FETCH_ASSOC);
        }
        echo '<br>';
        $carrozze_selezionate = isset($_POST['id_carrozza']) ? (array)$_POST['id_carrozza'] : array();

        if (empty($carrozze_selezionate)) {
            echo 'Seleziona almeno una carrozza';
            exit;
        }

        $numero_posti_totale = 0;
        echo 'Carrozze selezionate: ';
        foreach ($carrozze_selezionate as $carrozza) {

            $sql_carrozza = "SELECT * FROM carrozza WHERE id_carrozza = :id";
            $stmt_carrozza_composizione = $db->prepare($sql_carrozza);
            $stmt_carrozza_composizione->bindValue(':id', $carrozza, PDO::PARAM_INT);
            $stmt_carrozza_composizione->execute();

            $dati_carrozza = $stmt_carrozza_composizione->fetch(PDO::FETCH_ASSOC);
            $numero_posti_totale += intval($dati_carrozza['numero_posti']);
            echo htmlspecialchars($dati_carrozza['serie_carrozza']) . ' ' . htmlspecialchars($dati_carrozza['tipo_carrozza']) . ' ' . htmlspecialchars($dati_carrozza['numero_posti']) . ', ';
        }
        echo '<br>';


        $data_inizio_servizio = new DateTime($_POST["data_inizio_servizio"]);
        $data_fine_servizio = new DateTime($_POST["data_fine_servizio"]);
        $data_inizio_servizio_str = $data_inizio_servizio->format('Y-m-d 00:00:00');
        $data_fine_servizio_str = $data_fine_servizio->format('Y-m-d 00:00:00');

/*
        $sql_conta_treni = "SELECT COUNT(*) as conteggio FROM composizione_treno 
                        WHERE data_inizio_servizio = :data";
        $stmt_conta_treni = $db->prepare($sql_conta_treni);
        $stmt_conta_treni->bindValue(':data', $data_inizio_servizio_str, PDO::PARAM_STR);
        $stmt_conta_treni->execute();

        $conteggio_treni = $stmt_conta_treni->fetch(PDO::FETCH_ASSOC)['conteggio'];
        $max_treni_per_giorno = 2;

        if (in_array($data_inizio_servizio_str, [
            '2024-01-01',
            '2024-01-06',
            '2024-04-25',
            '2024-05-01',
            '2024-06-02',
            '2024-08-15',
            '2024-11-01',
            '2024-12-08',
            '2024-12-25',
            '2024-12-26',
        ])) {
            $max_treni_per_giorno = 4;
        }

        if ($conteggio_treni >= $max_treni_per_giorno) {
            header("location: ./composizioneTrenoError.html");
            exit;
        }
*/
        try {

            $query = $db->prepare("INSERT INTO composizione_treno (id_carrozze, id_locomotive, numero_posti_totale, data_inizio_servizio, data_fine_servizio) 
                                       VALUES (:id_carrozze, :id_locomotive, :numero_posti_totale, :data_inizio_servizio, :data_fine_servizio)");
            $id_carrozze = implode(',', $carrozze_selezionate);
            $id_locomotive = implode(',', $locomotive_selezionate);
            $query->bindParam(':id_carrozze', $id_carrozze, PDO::PARAM_STR);
            $query->bindParam(':id_locomotive', $id_locomotive, PDO::PARAM_STR);
            $query->bindParam(':numero_posti_totale', $numero_posti_totale, PDO::PARAM_INT);
            $query->bindParam(':data_inizio_servizio', $data_inizio_servizio_str, PDO::PARAM_STR);
            $query->bindParam(':data_fine_servizio', $data_fine_servizio_str, PDO::PARAM_STR);

            $query->execute();


            header("location: ./utenteComposizioneAmministrativoEffettuata.html");
            exit();
        } catch (PDOException $e) {
            echo 'Errore durante l\'inserimento nel database: ' . $e->getMessage();
            exit();
        }
    }



    ?>

    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
        <h2>Profilo Amministrativo</h2>

    </header>


    <form action="./utenteComposizioneAmministrativo.php" method="POST">


        <div class="form-group">
            <strong><label>Locomotive :</label></strong><br>

            <?php

            $sql = "SELECT * FROM locomotiva";
            $result = $db->query($sql);
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<label><input type="checkbox" name="id_locomotiva[]" value="' . intval($row["id_locomotiva"]) . '">' . htmlspecialchars($row["tipo_locomotiva"]) . '</label><br>';
                }
            }

            ?>
            <p></p>
        </div>

        <div class="form-group">
            <strong><label>Carrozze :</label></strong><br>

            <?php

            $sql = "SELECT * FROM carrozza";
            $result = $db->query($sql);
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<label><input type="checkbox" name="id_carrozza[]" value="' . intval($row["id_carrozza"]) . '">' . htmlspecialchars($row["serie_carrozza"] . ' - ' . $row["tipo_carrozza"] . ' - ' . $row["numero_posti"]) . '</label><br>';
                }
            }

            ?>
        <p></p>
        </div>

        <div class="form-group">
            <label for="data_inizio_servizio">Data inizio servizio</label>
            <input type="date" id="data_inizio_servizio" name="data_inizio_servizio" required>
        </div>

        <div class="form-group">
            <label for="data_fine_servizio">Data fine servizio</label>
            <input type="date" id="data_fine_servizio" name="data_fine_servizio" required>
        </div>

        <button type="submit">Componi treno</button>
        <p></p>


    </form>



    <form action="./utenteAmministrativoCheckDelete.php" method="POST">

        <label for="treni">Treni attivi</label>



        <select name="treni">

            <?php

            $sql = "SELECT ct.id_treno, ct.id_carrozze, ct.id_locomotive, ct.numero_posti_totale, ct.data_inizio_servizio, ct.data_fine_servizio
                            FROM composizione_treno ct;";



            $result = $db->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . intval($row["id_treno"]) . '"> '
                        . 'ID TRENO =  ' . htmlspecialchars($row["id_treno"])
                        . ', POSTI TOTALI = ' . htmlspecialchars($row["numero_posti_totale"])
                        . ', DATA INIZIO SERVIZIO = ' . htmlspecialchars($row["data_inizio_servizio"])
                        . ', DATA FINE SERVIZIO = ' . htmlspecialchars($row["data_fine_servizio"])
                        . '</option>';
                }
            }


            ?>

        </select><br>




        <button type="submit">Cancella treno</button><br>

    </form>
<p></p>

    <a href="./utenteAmministrativo.php"><button>profilo amministrativo</button></a><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
</body>

</html>