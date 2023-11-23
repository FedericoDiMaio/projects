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


    <form action="./utenteRegistratoCheck.php" method="POST">
        <div class="form-group">
            <label for="conto_corrente">conto corrente</label>

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

        
    </form><br>

    <nav>
        <li><a href="./out.php"><button>Logout</button></a></li>
    </nav>
</body>

</html>