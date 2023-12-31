<?php
session_start();
include "./connessionePDO2.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = $db2->prepare("SELECT * FROM utenti_registrati WHERE email = :email");
    $q->bindParam(':email', $email, PDO::PARAM_STR);
    $q->execute();
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $q->rowCount();
    
    if ($rows > 0) {
        while ($row = $q->fetch()) {
            if (password_verify($password, $row['password'])) {
                
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cognome'] = $row['cognome'];

                if ($row['ruolo'] === 'registrato') {
                    header("location: ./utenteRegistrato.php");
                    exit;
                } elseif ($row['ruolo'] === 'esercente') {
                    header("location: ./esercente.php");
                    exit;
                } elseif ($row['ruolo'] === 'm2m') {
                    header("location: ./profiloM2M.php");
                    exit;
                } else {
                    header("location: ./loginError.html");
                    exit;
                }
            } else {
                
                header("location: ./loginError.html");
                exit;
            }
        }
    } else {
        
        header("location: ./loginError.html");
    }
?>
