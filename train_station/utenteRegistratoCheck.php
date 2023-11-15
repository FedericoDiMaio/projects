<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo registrato</title>
</head>




<body>

    <?php

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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stazione_partenza = isset($_POST['partenza']) ? intval($_POST['partenza']) : null;
            $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;
        
            
            $dati_posizione_km_partenza = fetchStazioneData($db, $stazione_partenza);
            $dati_posizione_km_destinazione = fetchStazioneData($db, $stazione_destinazione);
        
            
            $somma_posizione_km = $dati_posizione_km_destinazione['posizione_km'] - $dati_posizione_km_partenza['posizione_km'];
            $velocita_treno = 50;
            $tempo_di_percorrenza = $somma_posizione_km / $velocita_treno;
        
            
            $costo_km = 0.25;
            $costo_biglietto = $somma_posizione_km * $costo_km;
        
            
            $tempo_di_percorrenza_hhmm = sprintf('%02d:%02d', (int)($tempo_di_percorrenza * 60), ($tempo_di_percorrenza * 60) % 60);
        }
        
        
        function fetchStazioneData($db, $stazione_id)
        {
            $sql_posizione_km = "SELECT posizione_km FROM stazione WHERE id_stazione = :id";
            $stmt_posizione_km = $db->prepare($sql_posizione_km);
            $stmt_posizione_km->bindValue(':id', $stazione_id, PDO::PARAM_INT);
            $stmt_posizione_km->execute();
        
            return $stmt_posizione_km->fetch(PDO::FETCH_ASSOC);
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


        //echo 'Stazione di partenza: ' . htmlspecialchars($dati_stazione_partenza['id_stazione']) . '<br>';
        //echo 'Stazione di destinazione: ' . htmlspecialchars($dati_stazione_destinazione['id_stazione']) . '<br>';
        //     echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
        //     echo 'Data di partenza: ' . ($dataPartenza ? htmlspecialchars($dataPartenza->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
        //     echo 'Orario di partenza: ' . ($orarioPartenza ? htmlspecialchars($orarioPartenza->format('H:i')) : 'Non ancora selezionato') . '<br>';
        //     echo 'somma posizione km destinazione: ' . $somma_posizione_km . '<br>';
        //     echo 'tempo di percorrenza HH:MM = ' . $tempo_di_percorrenza_hhmm . '<br>';
        //     echo 'Tempo di arrivo: ' . $tempo_di_arrivo->format('H:i') . '<br>';


//       $_SESSION['stazione_partenza'] = isset($dati_stazione_partenza['id_stazione']) ? htmlspecialchars($dati_stazione_partenza['id_stazione']) : '';
//       $_SESSION['stazione_destinazione'] = isset($dati_stazione_destinazione['id_stazione']) ? htmlspecialchars($dati_stazione_destinazione['id_stazione']) : '';
//       $_SESSION['costo_biglietto'] = isset($costo_biglietto) ? $costo_biglietto : '';
//        $_SESSION['data_partenza'] = isset($dataPartenza) ? $dataPartenza->format('d-m-Y') : '';
//        $_SESSION['orario_partenza'] = isset($orarioPartenza) ? $orarioPartenza->format('H:i') : '';
//        $_SESSION['somma_posizione_km'] = isset($somma_posizione_km) ? $somma_posizione_km : '';
//        $_SESSION['tempo_di_percorrenza_hhmm'] = isset($tempo_di_percorrenza_hhmm) ? $tempo_di_percorrenza_hhmm : '';
//        $_SESSION['tempo_di_arrivo'] = isset($tempo_di_arrivo) ? $tempo_di_arrivo->format('H:i') : '';

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
                        $sql = "SELECT * FROM carrozza_treno WHERE data_inizio_servizio <= :dataPartenza AND data_fine_servizio >= :dataPartenza";
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