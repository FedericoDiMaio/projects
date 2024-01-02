<!DOCTYPE html>
<html>

    <head>
        <title>TrainStation profilo amministrativo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
    </head>

        <body>

            <?php
                include "../pay_stream/connessionePDO2.php";
                include "./connessionePDO.php";
                session_start();
                
                $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
                $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
            ?>

            <header>
                <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
                <h2>Profilo Amministrativo</h2>
            </header>

            <?php
                $userID = 1;
                $sql_query2 = "SELECT Saldo FROM conto_corrente WHERE UserID = :userID";
                $stmt2 = $db2->prepare($sql_query2);
                $stmt2->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt2->execute();
                $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                if ($result2) {
                    $saldoUtente = $result2['Saldo'];
                    echo "<span style='font-size: 20px;'>La redditività dei treni prenotati è: $saldoUtente EURO</span>";
                } else {
                    echo "<span style='font-size: 20px;'>Utente non trovato o nessun saldo disponibile.</span>";
                }
            ?>
            <form action="./utenteComposizioneCheckDelete.php" method="POST">

            <p></p>
<label for="treni">Treni disponibili</label>

<select name="treni">

    <?php

    $sql = "SELECT ct.id_treno, ct.id_carrozze, ct.id_locomotive, ct.numero_posti_totale, ct.data_inizio_servizio, ct.data_fine_servizio
                    FROM composizione_treno ct;";



    $result = $db->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . intval($row["id_treno"]) . '"> '
                . 'ID TRENO =  ' . htmlspecialchars($row["id_treno"])
                . ', POSTI TOTALI = ' . htmlspecialchars($row["numero_posti_totale"])
                . ', DATA INIZIO SERVIZIO = ' . htmlspecialchars($row["data_inizio_servizio"])
                . ', DATA FINE SERVIZIO = ' . htmlspecialchars($row["data_fine_servizio"])
                . '</option>';
        }
    }


    ?>

</select><br>
<p></p>



<button type="submit">Cancella treno</button><br>

</form>


            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="location.href='./out.php';">Logout</button>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
                

            
        </body>

</html>