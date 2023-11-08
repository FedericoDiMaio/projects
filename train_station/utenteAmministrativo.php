<!DOCTYPE html>
<html>
<head>
    <title>TrainStation profilo esercizio</title>
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

    // Verificare se il modulo è stato inviato
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    }
    ?>

    <header>
        <div class="logo">backoffice amministrativo</div>
        <nav>
            <ul>
                <li><a href="./out.php">logout</a></li>
            </ul>
        </nav>
    </header>

    <?php
    session_start();
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
    ?>
    <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
    <h3>calcolo della redditività di ciascun treno</h3>
</body>
</html>
