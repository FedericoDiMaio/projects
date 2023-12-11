<!DOCTYPE html>
<html>

<head>
    <title>TrainStation profilo registrato</title>
</head>

<body>

    <?php
        session_start();
 
        include "./connessionePDO.php";
        

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
                }
            ?>
            
            </select>
        </div>
    </form><br>


        <form action="./inserisciDenaroCheck.php" method="POST">
            

            
            <div class="form-group">
                <label for="inserisci_denaro">Inserisci Denaro:</label>
                <input type="number" name="inserisci_denaro" placeholder="Importo da inserire" required>
                <button type="submit">Inserisci Denaro</button>
            </div>

            <?php
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                unset($_SESSION['importoDaInserire']);
            
                if (isset($_POST['inserisci_denaro'])) {
                    $_SESSION['importoDaInserire'] = $_POST['inserisci_denaro'];
                    
                }
            }
        ?>
        </form>
    
    <nav>
        <li><a href="./out.php"><button>Logout</button></a></li>
    </nav>
</body>

</html>