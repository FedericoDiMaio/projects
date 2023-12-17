<?php

    $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "pay_stream";

            try {
                $conn2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "ERRORE!: " . $e->getMessage() . "<br>";
                die();
            }
?>
