<!DOCTYPE html>
<html>
    <head>
        <title>TrainStation</title>
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

    // Verificare se il modulo è stato inviato
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recuperare la postazione di lavoro selezionata, la direzione e il viaggio di andata e ritorno dai dati POST
        $selected_station = isset($_POST['station']) ? intval($_POST['station']) : null;
        //$selected_direction = isset($_POST['direction']) ? $_POST['direction'] : null;
        //$round_trip = isset($_POST['round_trip']) && $_POST['round_trip'] == 'yes';

        // Validare i dati inviati
        if (empty($selected_station)) {
            echo 'Please select a station';
            exit;
        }
    }
    ?>

<header>
    <div class="logo">TrainStation</div>
    <nav>
        <ul>
            <li><a href="./out.php">Logout</a></li>
        </ul>
    </nav>
</header>

    <?php
    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
    ?>

    <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
    <form method="POST">
        <div class="form-group">
            <label for="departure">Stazione di partenza</label>

            <?php
            $sql = "SELECT * FROM stazione";
            $result = $db->query($sql);

            // Controllare se sono state restituite postazioni di lavoro
            if ($result->rowCount() > 0) {
                echo '<select name="workstation">';
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . intval($row["id"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                }
                echo '</select>';
            }
            ?>
    </div>
    <div class="form-group">
        <label for="destination">Stazione di destinazione</label>

        <?php
        // Ripeti il processo per la stazione di destinazione
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            echo '<select name="destination">';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . intval($row["id"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
            }
            echo '</select>';
        }
        ?>

    </div>
    <div class="form-group">
        <label for="depart-date">Data di partenza</label>
        <input type="date" id="depart-date" name="depart-date" required>
    </div>
    <div class="form-group">
        <label for="return-date">Data di ritorno</label>
        <input type="date" id="return-date" name="return-date" required>
    </div>
    <button type="submit">Cerca treni</button>
</form>

</body>
</html>
