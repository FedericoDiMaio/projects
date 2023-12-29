<?php
    include "./connessionePDO.php";


    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = $db->prepare("SELECT * FROM utenti_registrati_tr WHERE email = :email");
    $q->bindParam(':email', $email, PDO::PARAM_STR);
    $q->execute();
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $q->rowCount();

    if ($rows > 0) {
        while ($row = $q->fetch()) {
            if (password_verify($password, $row['password'])) {

                session_start();
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cognome'] = $row['cognome'];

                if ($row['ruolo'] === 'registrato') {
                    header("location: ./utenteRegistrato.php");
                    exit;
                } elseif ($row['ruolo'] === 'amministrativo') {
                    header("location: ./utenteAmministrativo.php");
                    exit;
                } elseif ($row['ruolo'] === 'esercizio') {
                    header("location: ./utenteComposizione.php");
                    exit;
                } else {
                    header("location: ./loginErrore.html");
                    exit;
                }
            } else {
                header("location: ./loginErrore.html");
                exit;
            }
        }
    } else {

        header("location: ./loginErrore.html");
    }
?>
```
