<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo esercente</title>
</head>

<body>

    <?php
        session_start();
        include "./connessionePDO.php";
        

        $userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
        $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
        $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
        $carte_di_credito = isset($_SESSION['carte_di_credito']) ? $_SESSION['carte_di_credito'] : '';
        $numeroCarta = isset($_SESSION['NumeroCarta']) ? $_SESSION['NumeroCarta'] : '';
        
    ?>

    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome?></h1>
        <h2>Profilo Esercente</h2>

    </header>


    <form action="./utenteRegistrato.php" method="POST">
        <div class="form-group">
            <label for="conto_corrente">Conto Corrente :</label>

            <select name="conto_corrente">

            <?php
                $sql_conto_corrente = "SELECT * FROM conto_corrente WHERE UserID = :userID";   
                $stmt_conto_corrente = $db->prepare($sql_conto_corrente);
                $stmt_conto_corrente->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt_conto_corrente->execute();
                $risultati_conto_corrente = $stmt_conto_corrente->fetchAll(PDO::FETCH_ASSOC);
                foreach ($risultati_conto_corrente as $conto_corrente) {
                    echo '<option value="' . htmlspecialchars($conto_corrente['ContoID']) . '">' . 'Saldo: ' . htmlspecialchars($conto_corrente['Saldo']) . '</option>';
                }
            ?>


            </select>

        </div>

        <div class = "form-group">
            <label for="carte_di_credito">Carte :</label>

            <select name="carte_di_credito">

            <?php
                $sql_carte_di_credito = "SELECT * FROM carte_di_credito WHERE UserID = :userID";   
                $stmt_carte_di_credito = $db->prepare($sql_carte_di_credito);
                $stmt_carte_di_credito->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt_carte_di_credito->execute();
                $risultati_carte_di_credito = $stmt_carte_di_credito->fetchAll(PDO::FETCH_ASSOC);
                foreach ($risultati_carte_di_credito as $carte_di_credito) {
                    echo '<option value="' . htmlspecialchars($carte_di_credito['CartaID']) . '">' . 'Numero carta: ' . htmlspecialchars($carte_di_credito['NumeroCarta']) . '</option>';

                echo $_SESSION['NumeroCarta'];
                
            }
                
            ?>
            <?php
            
            ?>
            </select>
        </div>
    </form><br>


    <form action="./inserisciDenaroCheck.php" method="POST">
            
        <div class="form-group">
            <label for="inserisci_denaro">Inserisci Denaro:</label>
            <input type="text" name="inserisci_denaro" placeholder="esempio 10.00" required>
            <button type="submit">Inserisci Denaro</button>
        </div>

            <?php
            
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    unset($_SESSION['importoDaInserire']);
                
                    if (isset($_POST['inserisci_denaro'])) {
                        $_SESSION['importoDaInserire'] = $_POST['inserisci_denaro'];
                        
                    }
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
                        <th>Esercente ID</th>
                        <th>Descrizione</th>
                        <th>Prezzo Transazione</th>
                    </tr>";

            
            foreach ($risultati_transazioni as $row) {
                echo "<tr>
                        <td>{$row['TransazioneM2MID']}</td>
                        <td>{$row['URLInviante']}</td>
                        <td>{$row['URLRisposta']}</td>
                        <td>{$row['EsercenteID']}</td>
                        <td>{$row['Descrizione']}</td>
                        <td>{$row['PrezzoTransazione']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Nessun risultato trovato";
        }
            ?>
    </form>
    
    <nav><br>
        <li><a href="./out.php"><button>Logout</button></a></li>
    </nav>
</body>

</html>