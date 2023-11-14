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


        

        // Moltiplica la somma dei km per 0,25 cent di euro
        $costo_km = 0.25;
        $costo_biglietto = $somma_posizione_km_destinazione * $costo_km;

        
    }

    $dataPartenza = null;
    $dataRitorno = null;
    $orarioPartenza = null;
    $orarioArrivo = null;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
            
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["data-ritorno"])) {
            $dataRitorno = new DateTime($_POST["data-ritorno"]);
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["orario-arrivo"])) {
            $orarioArrivo = new DateTime($_POST["orario-arrivo"]);
        }
    }
    
    //echo 'Stazione di partenza: ' . htmlspecialchars($dati_stazione_partenza['nome_stazione']) . '<br>';
    //echo 'Stazione di destinazione: ' . htmlspecialchars($dati_stazione_destinazione['nome_stazione']) . '<br>';
    //echo 'Costo del biglietto: ' . $costo_biglietto . ' euro' . '<br>';
    //echo 'Data di partenza: ' . ($dataPartenza ? htmlspecialchars($dataPartenza->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
    //echo 'Data di ritorno: ' . ($dataRitorno ? htmlspecialchars($dataRitorno->format('d-m-Y')) : 'Non ancora selezionata') . '<br>';
    //echo 'Orario di partenza: ' . ($orarioPartenza ? htmlspecialchars($orarioPartenza->format('H:i')) : 'Non ancora selezionato') . '<br>';
    //echo 'Orario di arrivo: ' . ($orarioArrivo ? htmlspecialchars($orarioArrivo->format('H:i')) : 'Non ancora selezionato') . '<br>';
    
    
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

        

        <button type="submit">prenota treno</button>

    </form>

        <nav>
    
            <a href="./login.html"><button>Login</button></a> <br>
            <a href="./registrazione.html"><button>Signup</button></a>

        </nav>

</body>

</html>