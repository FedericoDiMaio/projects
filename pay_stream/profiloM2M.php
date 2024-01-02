<!DOCTYPE html>
<html>

<head>
    <title>pay_stream profilo M2M</title>
</head>

<body>

    <?php
        
        include "./connessionePDO.php";
        session_start();
        
        $userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
        $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
        $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
        
        
    ?>

    <header>

        
        <h2>Profilo M2M</h2>
        <h3>in questa sezione puoi vedere le transazioni avvenute da train station al profilo esercente chiamato</h3>

    </header>
            <?php
            if(!isset($_SESSION['UserID'])) {
                header("location: ./loginError.html");
                exit;
            }
                

                $sql_transazioni = "SELECT * FROM transazioni_m2m";
                $stmt_transazioni = $db->prepare($sql_transazioni);
                $stmt_transazioni->execute();
                $risultati_transazioni = $stmt_transazioni->fetchAll(PDO::FETCH_ASSOC);

        
                if ($stmt_transazioni->rowCount() > 0) {
            
            echo "<table border='1'>
            <caption>TRANSAZIONI</caption>
                    <tr>
                        <th>ID Transazione</th>
                        <th>URL Inviante</th>
                        <th>URL Risposta</th>
                        <th>Descrizione</th>
                        <th>Prezzo Transazione</th>
                    </tr>";

            
            foreach ($risultati_transazioni as $row) {
                echo "<tr>
                        <td>{$row['TransazioneM2MID']}</td>
                        <td>{$row['URLInviante']}</td>
                        <td>{$row['URLRisposta']}</td>
                        <td>{$row['Descrizione']}</td>
                        <td>{$row['PrezzoTransazione']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nessuna transazione presente";
        }
            ?>
 
    
    <nav><br>
        <li><a href="./out.php"><button>Logout</button></a></li>
    </nav>
</body>

</html>