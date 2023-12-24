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
    
    if (!empty($nome) && !empty($cognome)) {
        
        $sql_utente = "SELECT id_utente FROM utente WHERE nome = :nome AND cognome = :cognome";
        $stmt_utente = $db->prepare($sql_utente);
        $stmt_utente->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_utente->bindParam(':cognome', $cognome, PDO::PARAM_STR);
        $stmt_utente->execute();
    
        
        $result_utente = $stmt_utente->fetch(PDO::FETCH_ASSOC);
        $id_utente = $result_utente ? $result_utente['id_utente'] : 'Sconosciuto';
        $_SESSION['id_utente'] = $id_utente;
    }
        
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stazione_partenza = isset($_POST['partenza']) ? intval($_POST['partenza']) : null;

        $sql_stazione_partenza = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_partenza = $db->prepare($sql_stazione_partenza);
        $stmt_stazione_partenza->bindValue(':id', $stazione_partenza, PDO::PARAM_INT);
        $stmt_stazione_partenza->execute();

        $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;

        $sql_stazione_destinazione = "SELECT * FROM stazione WHERE id_stazione = :id";
        $stmt_stazione_destinazion = $db->prepare($sql_stazione_destinazione);
        $stmt_stazione_destinazion->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_stazione_destinazion->execute();
    }

    
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
        }

        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
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



        <button type="submit">Cerca treni</button>


    </form>
    <nav>
        <li><a href="./out.php"><button>Logout</button></a></li>
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