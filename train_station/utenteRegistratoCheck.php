<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo registrato</title>
</head>




<body>

    <?php
    session_start();
    include "./connessionePDO.php";
    

    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
    $id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';
    



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

    $_SESSION['stazione_partenza'] = htmlspecialchars($dati_stazione_partenza['id_stazione']);
    $_SESSION['stazione_destinazione'] = htmlspecialchars($dati_stazione_destinazione['id_stazione']);
    $_SESSION['costo_biglietto'] = $costo_biglietto;
    $_SESSION['data_partenza'] = $dataPartenza ? $dataPartenza->format('d-m-Y') : 'Non ancora selezionata';
    $_SESSION['orario_partenza'] = $orarioPartenza ? $orarioPartenza->format('H:i') : 'Non ancora selezionato';
    $_SESSION['somma_posizione_km'] = $somma_posizione_km;
    $_SESSION['tempo_di_percorrenza_hhmm'] = $tempo_di_percorrenza_hhmm;
    $_SESSION['tempo_di_arrivo'] = $tempo_di_arrivo->format('H:i');
    $_SESSION['data_partenza_formatted'] = $data_partenza_formatted;
    $_SESSION['orario_partenza_formatted'] = $orario_partenza_formatted;

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
    <?php
      
if (isset($_SESSION['id_utente'])) {
    $id_utente = $_SESSION['id_utente'];

    
    $sql_tratte_utente = "
        SELECT tratta.*, stazione_partenza.nome_stazione AS partenza, stazione_arrivo.nome_stazione AS arrivo
        FROM tratta
        INNER JOIN stazione AS stazione_partenza ON tratta.id_stazione_partenza = stazione_partenza.id_stazione
        INNER JOIN stazione AS stazione_arrivo ON tratta.id_stazione_arrivo = stazione_arrivo.id_stazione
        WHERE tratta.id_utente = :id_utente
    ";

    $stmt_tratte_utente = $db->prepare($sql_tratte_utente);
    $stmt_tratte_utente->bindParam(':id_utente', $id_utente, PDO::PARAM_INT);
    $stmt_tratte_utente->execute();

    
    echo "<h3>biglietti prenotati</h3>";

    if ($stmt_tratte_utente->rowCount() > 0) {
        while ($row = $stmt_tratte_utente->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "Data e Orario Partenza: " . $row['data_orario_partenza'] . "<br>";
            echo "Partenza: " . $row['partenza'] . "<br>";
            echo "Arrivo: " . $row['arrivo'] . "<br>";
            echo "Distanza: " . number_format($row['distanza_km'], 1) . " km<br>";
            echo "Costo Biglietto: " . number_format($row['costo_biglietto'], 1) . " $<br>";
            echo "</p>";
        }
    } else {
        echo "Nessun biglietto trovato per l'utente";
    }
} else {
    echo "ID utente non disponibile nella sessione.";
}
    ?>
</body>

</html>