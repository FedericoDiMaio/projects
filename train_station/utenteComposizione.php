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

                    $data_inizio_servizio = new DateTime($_POST["data_inizio_servizio"]);
                    $data_fine_servizio = new DateTime($_POST["data_fine_servizio"]);


                }

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
            <label for="data_inizio_servizio">Data inizio servizio</label>
            <input type="date" id="data_inizio_servizio" name="data_inizio_servizio" required>
        </div>

        <div class="form-group">
            <label for="data_fine_servizio">Data fine servizio</label>
            <input type="date" id="data_fine_servizio" name="data_fine_servizio" required>
        </div>

        <button type="submit">Componi treno</button>



    </form>



    <form action="./utenteComposizioneCheckDelete.php" method="POST">

    <label for="treni">Treni disponibili</label>



    <select name="treni">
        
            <?php

                $sql = "SELECT ct.id_treno, ct.id_carrozza, ct.id_locomotiva, ct.numero_posti_totale, ct.data_inizio_servizio, ct.data_fine_servizio,
                        c.serie_carrozza, c.tipo_carrozza, l.tipo_locomotiva
                        FROM carrozza_treno ct
                        JOIN carrozza c ON ct.id_carrozza = c.id_carrozza
                        JOIN locomotiva l ON ct.id_locomotiva = l.id_locomotiva";

                $result = $db->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_treno"]) . '">'
                            . 'ID TRENO =  ' . htmlspecialchars($row["id_treno"])
                            . ', CARROZZA = ' . htmlspecialchars($row["serie_carrozza"])
                            . ', TIPO CARROZZA = ' . htmlspecialchars($row["tipo_carrozza"])
                            . ', LOCOMOTIVA =  ' . htmlspecialchars($row["tipo_locomotiva"])
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

    <a href="./out.php"><button>Logout</button></a><br>

</body>

</html>