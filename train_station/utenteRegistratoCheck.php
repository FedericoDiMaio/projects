<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo registrato</title>
</head>




<body>

    <?php
    
    include "./connessionePDO.php";
    session_start();

    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stazione_partenza = isset($_POST['partenza']) ? intval($_POST['partenza']) : null;

        $sql_posizione_km_partenza = "SELECT posizione_km FROM stazione WHERE id_stazione = :id";
        $stmt_posizione_km_partenza = $db->prepare($sql_posizione_km_partenza);
        $stmt_posizione_km_partenza->bindValue(':id', $stazione_partenza, PDO::PARAM_INT);
        $stmt_posizione_km_partenza->execute();

        $dati_posizione_km_partenza = $stmt_posizione_km_partenza->fetch(PDO::FETCH_ASSOC);

        $sql_stazione_partenza = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_partenza = $db->prepare($sql_stazione_partenza);
        $stmt_stazione_partenza->bindValue(':id', $stazione_partenza, PDO::PARAM_INT);
        $stmt_stazione_partenza->execute();

        $dati_stazione_partenza = $stmt_stazione_partenza->fetch(PDO::FETCH_ASSOC);

        $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;

        $sql_posizione_km_destinazione = "SELECT posizione_km FROM stazione WHERE id_stazione = :id";
        $stmt_posizione_km_destinazione = $db->prepare($sql_posizione_km_destinazione);
        $stmt_posizione_km_destinazione->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_posizione_km_destinazione->execute();

        $dati_posizione_km_destinazione = $stmt_posizione_km_destinazione->fetch(PDO::FETCH_ASSOC);

        $sql_stazione_destinazione = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_destinazione = $db->prepare($sql_stazione_destinazione);
        $stmt_stazione_destinazione->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_stazione_destinazione->execute();

        $dati_stazione_destinazione = $stmt_stazione_destinazione->fetch(PDO::FETCH_ASSOC);

        $somma_posizione_km = $dati_posizione_km_destinazione['posizione_km'] - $dati_posizione_km_partenza['posizione_km'];

        $velocita_treno = 50;
        $tempo_di_percorrenza = $somma_posizione_km / $velocita_treno;

        $costo_km = 0.25;
        $costo_biglietto = $somma_posizione_km * $costo_km;

        $tempo_di_percorrenza_hhmm = sprintf('%02d:%02d', (int)($tempo_di_percorrenza * 60), ($tempo_di_percorrenza * 60) % 60);
    }

    
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
        }

        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
    

    $tempo_di_arrivo = clone $orarioPartenza;
    $tempo_di_arrivo->add(new DateInterval('PT' . (int)($tempo_di_percorrenza * 60) . 'M'));

    $tempo_di_arrivo_formatted = $tempo_di_arrivo->format('H:i:s');
    $orario_partenza_formatted = $orarioPartenza->format('H:i:s');
    $data_partenza_formatted = $dataPartenza ? $dataPartenza->format('Y-m-d') : null;

        //$tempo_di_percorrenza_formatted = $tempo_di_percorrenza_hhmm->format('H:i:s');
        echo 'Stazione di partenza: ' . htmlspecialchars($dati_stazione_partenza['id_stazione']) . '<br>';
        echo 'Stazione di destinazione: ' . htmlspecialchars($dati_stazione_destinazione['id_stazione']) . '<br>';
        echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
        echo 'Data di partenza: ' . ($dataPartenza ? htmlspecialchars($dataPartenza->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
        echo 'Orario di partenza: ' . ($orarioPartenza ? htmlspecialchars($orarioPartenza->format('H:i')) : 'Non ancora selezionato') . '<br>';
        echo 'somma posizione km destinazione: ' . $somma_posizione_km . '<br>';
        echo 'tempo di percorrenza HH:MM = ' . $tempo_di_percorrenza_hhmm . '<br>';
        echo 'Tempo di arrivo: ' . $tempo_di_arrivo->format('H:i') . '<br>';
        echo 'data partenza: ' . $data_partenza_formatted . '<br>';
        echo 'orario partenza: ' . $orario_partenza_formatted . '<br>';
        //echo 'tempo di arrivo' . $tempo_di_arrivo_formatted . '<br>';
        //$_SESSION['stazione_partenza'] = isset($dati_stazione_partenza['id_stazione']) ? htmlspecialchars($dati_stazione_partenza['id_stazione']) : '';
        //$_SESSION['stazione_destinazione'] = isset($dati_stazione_destinazione['id_stazione']) ? htmlspecialchars($dati_stazione_destinazione['id_stazione']) : '';
        //$_SESSION['costo_biglietto'] = isset($costo_biglietto) ? $costo_biglietto : '';
        //        $_SESSION['data_partenza'] = isset($dataPartenza) ? $dataPartenza->format('d-m-Y') : '';
        //        $_SESSION['orario_partenza'] = isset($orarioPartenza) ? $orarioPartenza->format('H:i') : '';
        //$_SESSION['somma_posizione_km'] = isset($somma_posizione_km) ? $somma_posizione_km : '';
        //        $_SESSION['tempo_di_percorrenza_hhmm'] = isset($tempo_di_percorrenza_hhmm) ? $tempo_di_percorrenza_hhmm : '';
  /*      //        $_SESSION['tempo_di_arrivo'] = isset($tempo_di_arrivo) ? $tempo_di_arrivo->format('H:i') : '';
    $stmt = $db->prepare("INSERT INTO tratta (distanza_km, costo_biglietto, id_stazione_partenza, id_stazione_arrivo, data_partenza, orario_partenza, tempo_arrivo, tempo_percorrenza) VALUES (:distanza_km, :costo_biglietto, :id_stazione_partenza, :id_stazione_arrivo, :data_partenza, :orario_partenza, :tempo_arrivo, :tempo_percorrenza)");

    $stmt->bindParam(':distanza_km', $somma_posizione_km, PDO::PARAM_STR);
    $stmt->bindParam(':costo_biglietto', $costo_biglietto, PDO::PARAM_STR);
    $stmt->bindParam(':id_stazione_partenza', $stazione_partenza, PDO::PARAM_INT);
    $stmt->bindParam(':id_stazione_arrivo', $stazione_destinazione, PDO::PARAM_INT);
    $stmt->bindParam(':data_partenza', $data_partenza_formatted, PDO::PARAM_STR);
    $stmt->bindParam(':orario_partenza', $orario_partenza_formatted, PDO::PARAM_STR);
    $stmt->bindParam(':tempo_arrivo', $tempo_di_arrivo_formatted, PDO::PARAM_STR);
    $stmt->bindParam(':tempo_percorrenza', $tempo_di_percorrenza_formatted, PDO::PARAM_STR);

try {
    $stmt->execute();

    $id_tratta = $db->lastInsertId();
    $_SESSION['id_tratta'] = $id_tratta;
    
    header('location: ./prenotazione.php');
    exit();
} catch (PDOException $e) {
    header('location: ./Errore.html');
    exit();
}
 */   
?>



    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
        <h2>Profilo registrato</h2>

    </header>

    <form action="./utenteRegistratoCheck.php" method="POST">

        <div class="form-group">
            <label for="partenza">Stazione di partenza</label>

            <select name="partenza">

                <?php

                $sql = "SELECT * FROM stazione";
                $result = $db->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_stazione"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                    }
                }

                ?>

            </select>

        </div>

        <div class="form-group">
            <label for="destinazione">Stazione di destinazione</label>

            <select name="destinazione">

                <?php

                $result = $db->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_stazione"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                    }
                }

                ?>


            </select>

        </div>

        <div class="form-group">
            <label for="data-partenza">Data di partenza</label>
            <input type="date" id="data-partenza" name="data-partenza" required>
        </div>


        <div class="form-group">
            <label for="orario-partenza">Orario di partenza</label>
            <input type="time" id="orario-partenza" name="orario-partenza" required>
        </div>

        <label for="treni">Treni disponibili</label>


        <select name="treni">

            <?php

            $dataPartenzaSelezionata = isset($_POST['data-partenza']) ? $_POST['data-partenza'] : null;

            if ($dataPartenzaSelezionata) {
                // Modifica la query SQL per cercare il treno in base alla data di partenza
                $sql = "SELECT * FROM composizione_treno WHERE data_inizio_servizio <= :dataPartenza AND data_fine_servizio >= :dataPartenza";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':dataPartenza', $dataPartenzaSelezionata);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_treno"]) . '">' . $row["id_treno"] . ' - ' . $row["data_inizio_servizio"] . ' a ' . $row["data_fine_servizio"] . '</option>';
                    }
                } else {
                    echo '<option value="-1">Nessun treno disponibile per la data di partenza selezionata</option>';
                }
            } else {

                echo '<option value="-1">Seleziona prima una data di partenza</option>';
            }
            ?>

        </select><br>


        <button type="submit">Cerca treni</button>





    </form>


    <form action="./checkTratta.php" method="POST">

        <button type="submit">prenota treno</button>

    </form>

    <nav>


        <a href="./out.php"><button>Logout</button></a>

    </nav>

</body>

</html>