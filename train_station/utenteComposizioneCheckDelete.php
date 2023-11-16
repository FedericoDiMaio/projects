<?php

include "./connessionePDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['treni'])) {
        $id_treno = $_POST['treni'];

        try {
            
            $delete_carrozza_treno = $db->prepare("DELETE FROM composizione_treno WHERE id_treno = :id_treno");
            $delete_carrozza_treno->bindParam(':id_treno', $id_treno, PDO::PARAM_INT);
            $delete_carrozza_treno->execute();

            
            $delete_treno = $db->prepare("DELETE FROM treno WHERE id_treno = :id_treno");
            $delete_treno->bindParam(':id_treno', $id_treno, PDO::PARAM_INT);
            $delete_treno->execute();

            
            header("Location: ./utenteComposizioneDelete.html");
            exit();
        } catch (PDOException $e) {
            echo 'Errore durante l\'eliminazione dal database: ' . $e->getMessage();
        }
    }
}
