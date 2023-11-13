<!DOCTYPE html>
<html>

    <head>
        <title>TrainStation profilo esercizio</title>
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
                $locomotive = isset($_POST['locomotiva']) ? $_POST['locomotiva'] : array();
        
                if (empty($locomotive)) {
                    echo 'Seleziona almeno una locomotiva';
                    exit;
                }
        
                echo 'Locomotive selezionate: ';
                foreach ($locomotive as $locomotiva) {
                    // Query per ottenere tutti i dati della locomotiva selezionata
                    $sql_locomotiva = "SELECT * FROM locomotiva WHERE id_locomotiva = :id";
                    $stmt_locomotiva_composizione = $db->prepare($sql_locomotiva);
                    $stmt_locomotiva_composizione->bindValue(':id', $locomotiva, PDO::PARAM_INT);
                    $stmt_locomotiva_composizione->execute();
        
                    $dati_locomotiva = $stmt_locomotiva_composizione->fetch(PDO::FETCH_ASSOC);
        
                    echo htmlspecialchars($dati_locomotiva['tipo_locomotiva']) . ', ';
                }
                echo '<br>';
            }


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $carrozza = isset($_POST['carrozza']) ? intval($_POST['carrozza']) : null;

                if (empty($carrozza)) {
                    echo 'Seleziona almeno una carrozza';
                    exit;
                }

                // Query per ottenere tutti i dati della carrozza selezionata
                echo 'Carrozze selezionate: ';
                foreach ($carrozze as $carrozza) {
                    // Query per ottenere tutti i dati della carrozza selezionata
                    $sql_carrozza = "SELECT * FROM carrozza WHERE id_carrozza = :id";
                    $stmt_carrozza_composizione = $db->prepare($sql_carrozza);
                    $stmt_carrozza_composizione->bindValue(':id', $carrozza, PDO::PARAM_INT);
                    $stmt_carrozza_composizione->execute();
        
                    $dati_carrozza = $stmt_carrozza_composizione->fetch(PDO::FETCH_ASSOC);
        
                    echo htmlspecialchars($dati_carrozza['serie_carrozza']) . ' ' . htmlspecialchars($dati_carrozza['tipo_carrozza']) . ' ' . htmlspecialchars($dati_carrozza['numero_posti']) . ', ';
                }
                echo '<br>';


                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $dataPartenza = new DateTime($_POST["data-partenza"]);
                    $dataRitorno = new DateTime($_POST["data-ritorno"]);

                    //   $festivo = isFestivo($dataPartenza) || isFestivo($dataRitorno);
                    //   $feriale = isFeriale($dataPartenza) && isFeriale($dataRitorno);

                    //   if ($festivo || $feriale) {
                    //       echo "Le date rispettano le condizioni specificate.";
                    //   } else {
                    //       echo "Le date non rispettano le condizioni specificate.";
                    //   }
                }
                //  function isFestivo($data)
                //  {
                //      return true;
                //  }
                //  function isFeriale($data)
                //  {
                //      return true;
                //  }
                $sql_select = "SELECT nome_treno FROM treno";
                $stmt_select = $db->prepare($sql_select);
                $stmt_select->execute();
                $risultati = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

                if ($risultati) {
                    foreach ($risultati as $row) {
                        echo '<option value="' . htmlspecialchars($row["nome_treno"]) . '">' . htmlspecialchars($row["nome_treno"]) . '</option>';
                    }
                } else {
                    echo 'Nessun risultato';
                }

                echo 'treni disponibili: ' . htmlspecialchars($dati_treno['nome_treno']) . '<br>';
            }

        ?>

        <header>

            <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
            <h2>Profilo esercizio</h2>

        </header>


    <form action="./utenteComposioneBuild.php" method="POST">


        <div class="form-group">
            <strong><label>Locomotive :</label></strong><br>

            <?php

                $sql = "SELECT * FROM locomotiva";
                $result = $db->query($sql);
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<label><input type="checkbox" name="locomotiva[]" value="' . intval($row["id_locomotiva"]) . '">' . htmlspecialchars($row["tipo_locomotiva"]) . '</label><br>';
                    }
                }

            ?>
        </div>

        <div class="form-group">
            <strong><label>Carrozze :</label></strong><br> 

            <?php

                $sql = "SELECT * FROM carrozza";
                $result = $db->query($sql);
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<label><input type="checkbox" name="carrozza[]" value="' . intval($row["id_carrozza"]) . '">' . htmlspecialchars($row["serie_carrozza"] . ' - ' . $row["tipo_carrozza"] . ' - ' . $row["numero_posti"]) . '</label><br>';
                    }
                }
                
            ?>

        </div>

        <div class="form-group">
            <label for="data-partenza">Data di partenza</label>
            <input type="date" id="data-partenza" name="data-partenza" required>
        </div>

        <div class="form-group">
            <label for="data-ritorno">Data di ritorno</label>
            <input type="date" id="data-ritorno" name="data-ritorno" required>
        </div>

        <div class="form-group">
            <label for="orario-partenza">Orario di partenza</label>
            <input type="time" id="orario-partenza" name="orario-partenza" required>
        </div>

        <div class="form-group">
            <label for="orario-arrivo">Orario di arrivo</label>
            <input type="time" id="orario-arrivo" name="orario-arrivo" required>
        </div>

        <button type="submit">Componi treno</button>



    </form>



    <form action="./utenteComposizioneCheckDelete.php" method="POST">

        <label for="treni">treni disponibili</label>

        <select name="treni">

            <?php

            $sql = "SELECT * FROM treno";
            $result = $db->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . intval($row["id_treno"]) . '">' . htmlspecialchars($row["nome_treno"]) . '</option>';
                }
            }

            ?>

        </select><br>

        <button type="submit">Cancella treno</button><br>

    </form>

    <a href="./out.php"><button>Logout</button></a><br>

</body>

</html>