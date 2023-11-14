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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['treni'])) {
        $id_treno = $_POST['treni'];

        try {
            // Elimina i record dalla tabella `carrozza_treno`
            $delete_carrozza_treno = $db->prepare("DELETE FROM carrozza_treno WHERE id_treno = :id_treno");
            $delete_carrozza_treno->bindParam(':id_treno', $id_treno, PDO::PARAM_INT);
            $delete_carrozza_treno->execute();

            // Elimina il treno dalla tabella `treno`
            $delete_treno = $db->prepare("DELETE FROM treno WHERE id_treno = :id_treno");
            $delete_treno->bindParam(':id_treno', $id_treno, PDO::PARAM_INT);
            $delete_treno->execute();

            // Reindirizza a una pagina HTML
            header("Location: ./utenteComposizioneDelete.html");
            exit();
        } catch (PDOException $e) {
            echo 'Errore durante l\'eliminazione dal database: ' . $e->getMessage();
        }
    } 

}

?>
