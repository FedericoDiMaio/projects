<?php
        #$servername = "localhost:3306";
        #$username = "f.dimaio";
        #$password = "g5PcpT04";
        #$dbname = "f_dimaio";
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
?>
