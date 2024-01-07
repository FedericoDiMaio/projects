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

            <?php
                $userID = 1;
                $sql_query2 = "SELECT Saldo FROM conto_corrente WHERE UserID = :userID";
                $stmt2 = $db2->prepare($sql_query2);
                $stmt2->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt2->execute();
                $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                if ($result2) {
                    $saldoUtente = $result2['Saldo'];
                    echo "<span style='font-size: 30px;'>La redditività dei treni prenotati è: $saldoUtente EURO</span>";
                } else {
                    echo "<span style='font-size: 20px;'>Utente non trovato o nessun saldo disponibile.</span>";
                }
            ?>
            


            
            


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
                

            
        </body>

</html>