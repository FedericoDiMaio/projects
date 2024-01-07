<!DOCTYPE html>
<html>

<head>
    <title>pay_stream profilo registrato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
</head>

<body>

    <?php
    session_start();
    include "./connessionePDO2.php";
        
        $userID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : '';
        $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
        $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
        
    ?>

    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome?></h1>
        <h2>Profilo registrato</h2>

    </header>


    <form action="./utenteRegistrato.php" method="POST">
        <div class="form-group">
            <label for="conto_corrente">Conto Corrente :</label>

            <select name="conto_corrente">

            <?php
                $sql_conto_corrente = "SELECT * FROM conto_corrente WHERE UserID = :userID";   
                $stmt_conto_corrente = $db2->prepare($sql_conto_corrente);
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
                $stmt_carte_di_credito = $db2->prepare($sql_carte_di_credito);
                $stmt_carte_di_credito->bindParam(':userID', $userID, PDO::PARAM_INT);
                $stmt_carte_di_credito->execute();
                $risultati_carte_di_credito = $stmt_carte_di_credito->fetchAll(PDO::FETCH_ASSOC);
                foreach ($risultati_carte_di_credito as $carte_di_credito) {
                    echo '<option value="' . htmlspecialchars($carte_di_credito['CartaID']) . '">' . 'Numero carta: ' . htmlspecialchars($carte_di_credito['NumeroCarta']) . '</option>';

                
                
            }
                
            ?>
            
            </select>
        </div><br>

        <form action="./utenteRegistrato.php" method="POST">
            <p style="display: inline-block; margin-right: 10px;">Per generare una nuova carta di credito:</p>
            <button type="submit" name="genera_carta">Genera Carta di credito</button>

            

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['genera_carta'])) {
                if (!empty($userID)) {
                    function generaNumeroCarta() {
                        $numeroCarta = '4';
                        for ($i = 0; $i < 15; $i++) {
                            $numeroCarta .= rand(0, 9);
                        }
                        return $numeroCarta;
                    }

                    try {
                        $numeroCarta = generaNumeroCarta();

                        $query_inserimento_carta = $db2->prepare('INSERT INTO carte_di_credito (UserID, NumeroCarta) VALUES (:UserID, :NumeroCarta)');
                        $query_inserimento_carta->bindParam(':UserID', $userID, PDO::PARAM_INT);
                        $query_inserimento_carta->bindParam(':NumeroCarta', $numeroCarta, PDO::PARAM_STR);
                        $query_inserimento_carta->execute();

                        
                    } catch (PDOException $e) {
                        echo "Errore durante l'inserimento della carta: " . $e->getMessage();
                    }
                } else {
                    echo "ID dell'utente non disponibile.";
                }
            }

        ?>
        </form>
    </form>


    <form action="./inserisciDenaroCheck.php" method="POST">
            
        <div style="display: inline-block;">
            <div class="form-group">
                <label for="inserisci_denaro">Inserisci Denaro:</label>
                <input type="text" name="inserisci_denaro" placeholder="esempio 10.00" required>
            </div>
        </div>

        <div style="display: inline-block;">
            <div class="form-group">
                <label for="causale">Causale:</label>
                <input type="text" name="causale" placeholder="Inserisci la causale" required>
                <button type="submit">Inserisci denaro</button>
            </div>
        </div>


        <?php
            if(!isset($_SESSION['UserID'])) {
                header("location: ./loginError.html");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                unset($_SESSION['importoDaInserire']);
                unset($_SESSION['causale']);
                
                if (isset($_POST['inserisci_denaro'])) {
                    $_SESSION['importoDaInserire'] = $_POST['inserisci_denaro'];
                    $_SESSION['causale'] = $_POST['causale'];
                        
                }
            }
        ?>
    </form>

    <form action="./inviaDenaroCheck.php" method="POST">
            
    <div style="display: inline-block;">
    <div class="form-group">
        <label for="invia_denaro_check">Invia denaro:</label>
        <input type="text" name="invia_denaro_check" placeholder="esempio 10.00" required>
       
    </div>
    </div>

    <div style="display: inline-block;">
        <div class="form-group">
        <label for="causale">Causale:</label>
        <input type="text" name="causale" placeholder="Inserisci la causale" required>
        <button type="submit">Invia denaro</button>
    </div>
    </div>

    
                <?php
                
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        unset($_SESSION['importoDaInviare']);
                        unset($_SESSION['causale']);
                    
                        if (isset($_POST['inserisci_denaro'])) {
                            $_SESSION['importoDaInviare'] = $_POST['invia_denaro_check'];
                            $_SESSION['causale'] = $_POST['causale'];
                        }
                    }
                ?>
    </form><br>

    


    <?php
            $query_select_estratto_conto = $db2->prepare('SELECT * FROM estratto_conto WHERE UserID = :userID');
            $query_select_estratto_conto->bindParam(':userID', $userID, PDO::PARAM_INT);
            $query_select_estratto_conto->execute();
            $estratto_conto_rows = $query_select_estratto_conto->fetchAll(PDO::FETCH_ASSOC);
            
            
            if (!empty($estratto_conto_rows)) {
                echo "<table border='1'>
                        <caption>Estratto Conto</caption>
                        <tr>
                            
                            
                            <th>Uscite</th>
                            <th>Entrate</th>
                            <th>Causale</th>
                        </tr>";
            
                foreach ($estratto_conto_rows as $row) {
                    echo "<tr>
                            
                            
                            <td>{$row['uscite']}</td>
                            <td>{$row['entrate']}</td>
                            <td>{$row['causale']}</td>
                        </tr>";
                }
            
                echo "</table>";
            } else {
                echo "Nessuna operazione effettuata sul tuo conto corrente.";
            }
            ?>
    <nav><br>
        <li><a href="./out.php"><button>Logout</button></a></li>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
</body>

</html>