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

session_start();
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
?>

<header>
    <div class="logo">backoffice di esercizio</div>
    <nav>
        <ul>
            <li><a href="./out.php">logout</a></li>
        </ul>
    </nav>
</header>

<h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
<h3>i treni composti sono : </h3>

<?php
// Esegui la query per ottenere i valori desiderati
$sql = "SELECT * FROM treno";
$result = $db->query($sql);
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="card">';
        echo '<div class="card-image">';
        echo '</div>';
        echo '<div class="card-content">';
        // Mostra i valori ottenuti nel codice HTML
        echo '<h2 class="card-title">id treno: ' . $row['id_treno'] .'</h2>';
        echo '<p class="card-description"></p>';
        echo '<p class="card-description"></p>';
        echo '<a href="#" class="btn btn-primary">modifica</a>';
        echo '</div>';
        echo '</div>';
    }
}
?>

</body>
</html>
