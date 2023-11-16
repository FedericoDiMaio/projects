<!DOCTYPE html>
<html>

<head>
    <title>TrainStation home page</title>
</head>

<header>
    <H1>TrainStation Home Page</H1>
</header>


<body>

    <?php

    include "./connessionePDO.php";

    session_start();



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
        $stmt_stazione_destinazion = $db->prepare($sql_stazione_destinazione);
        $stmt_stazione_destinazion->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_stazione_destinazion->execute();

        $dati_stazione_destinazione = $stmt_stazione_destinazion->fetch(PDO::FETCH_ASSOC);

        $somma_posizione_km = $dati_posizione_km_destinazione['posizione_km'] - $dati_posizione_km_partenza['posizione_km'];

        $velocità_treno = 50;
        $tempo_di_percorrenza = $somma_posizione_km / $velocità_treno;

        $costo_km = 0.25;
        $costo_biglietto = $somma_posizione_km * $costo_km;
        $tempo_di_percorrenza_hhmm = sprintf('%02d:%02d', (int) ($tempo_di_percorrenza * 60), ($tempo_di_percorrenza * 60) % 60);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
        }

        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
    }

    $tempo_di_arrivo = clone $orarioPartenza;
    $tempo_di_arrivo->add(new DateInterval('PT' . (int)($tempo_di_percorrenza * 60) . 'M'));


    //    echo 'Stazione di partenza: ' . htmlspecialchars($dati_stazione_partenza['nome_stazione']) . '<br>';
    //    echo 'Stazione di destinazione: ' . htmlspecialchars($dati_stazione_destinazione['nome_stazione']) . '<br>';
    //    echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
    //    echo 'Data di partenza: ' . ($dataPartenza ? htmlspecialchars($dataPartenza->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
    echo 'Orario di partenza: ' . ($orarioPartenza ? htmlspecialchars($orarioPartenza->format('H:i')) : 'Non ancora selezionato') . '<br>';
    //    echo 'somma posizione km destinazione: ' . $somma_posizione_km . '<br>';
    echo 'tempo di percorrenza HH:MM = ' . $tempo_di_percorrenza_hhmm . '<br>';
    echo 'Tempo di arrivo: ' . $tempo_di_arrivo->format('H:i') . '<br>';
    ?>





    <form action="./landingCheck.php" method="POST">

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




        <button type="submit">Cerca treni</button>



    </form>


    <form action="./loginNonEffettuato.html" method="POST">

        <label for="treni">Treni disponibili</label>

        <select name="treni">

            <?php

            $dataPartenzaSelezionata = isset($_POST['data-partenza']) ? $_POST['data-partenza'] : null;

            if ($dataPartenzaSelezionata) {
                //cerco il treno in base alla data di partenza
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

        <button type="submit">prenota treno</button>

    </form>

    <nav>

        <a href="./login.html"><button>Login</button></a> <br>
        <a href="./registrazione.html"><button>Signup</button></a>

    </nav>

</body>

</html>