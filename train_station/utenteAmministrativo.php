<!DOCTYPE html>
<html>

    <head>
        <title>TrainStation profilo amministrativo</title>
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

    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';

    ?>

    <header>

        <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
        <h2>Profilo Amministrativo</h2>

    </header>
    
    <li><a href="./out.php">logout</a></li>
</body>
</html>
