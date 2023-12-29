<!DOCTYPE html>
<html>

    <head>
        <title>TrainStation profilo amministrativo</title>
    </head>

        <body>

            <?php
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
                $stmt2 = $db->prepare($sql_query2);
                $stmt2->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt2->execute();
                $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                if ($result2) {
                    $saldoUtente = $result2['Saldo'];
                    echo "la redditività dei treni prenotati è: $saldoUtente EURO";
                } else {
                    echo "Utente non trovato o nessun saldo disponibile.";
                }
            ?>
            <li><a href="./out.php">logout</a></li>
        </body>

</html>