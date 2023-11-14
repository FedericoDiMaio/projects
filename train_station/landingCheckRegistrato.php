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
    
        if (empty($stazione_partenza)) {
            echo 'Seleziona una stazione';
            exit;
        }
        // Query per ottenere tutti i dati della stazione selezionata

        $sql_stazione_partenza = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_partenza = $db->prepare($sql_stazione_partenza);
        $stmt_stazione_partenza->bindValue(':id', $stazione_partenza, PDO::PARAM_INT);
        $stmt_stazione_partenza->execute();

        $dati_stazione_partenza = $stmt_stazione_partenza->fetch(PDO::FETCH_ASSOC);

        echo 'Stazione di partenza: ' . htmlspecialchars($dati_stazione_partenza['nome_stazione']) . '<br>';
    
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;

        if (empty($stazione_destinazione)) {
            echo 'Seleziona una stazione';
            exit;
        }

        // Query per ottenere la posizione_km della stazione selezionata
        $sql_posizione_km_destinazione = "SELECT posizone_km FROM stazione WHERE id_stazione = :id";
        $stmt_posizione_km_destinazione = $db->prepare($sql_posizione_km_destinazione);
        $stmt_posizione_km_destinazione->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_posizione_km_destinazione->execute();

        $dati_posizione_km_destinazione = $stmt_posizione_km_destinazione->fetch(PDO::FETCH_ASSOC);

        // Calcola la somma dei campi posizione_km delle due stazioni selezionate
        $somma_posizione_km_destinazione = floatval($dati_posizione_km_destinazione['posizone_km']);


        // Query per ottenere tutti i dati della stazione selezionata
        $sql_stazione_destinazione = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_destinazion = $db->prepare($sql_stazione_destinazione);
        $stmt_stazione_destinazion->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_stazione_destinazion->execute();

        $dati_stazione_destinazione = $stmt_stazione_destinazion->fetch(PDO::FETCH_ASSOC);


        echo 'Stazione di destinazione: ' . htmlspecialchars($dati_stazione_destinazione['nome_stazione']) . '<br>';

        // Moltiplica la somma dei km per 0,25 cent di euro
        $costo_km = 0.25;
        $costo_biglietto = $somma_posizione_km_destinazione * $costo_km;

        // Stampa il costo del biglietto 
        echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
    }

    $dataPartenza = null;
    $orarioPartenza = null;



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
            
        }
    }


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
    }

    echo 'Data di partenza: ' . ($dataPartenza ? htmlspecialchars($dataPartenza->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
    echo 'Orario di partenza: ' . ($orarioPartenza ? htmlspecialchars($orarioPartenza->format('H:i')) : 'Non ancora selezionato') . '<br>';
  
    
    ?>



    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
        <h2>Profilo registrato</h2>

    </header>
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


    <form action="./prenotazioneTreno.html" method="POST">

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
        <button type="submit">prenota treno</button>

    </form>

        <nav>
    
           
            <a href="./out.php"><button>Logout</button></a>

        </nav>

</body>

</html>