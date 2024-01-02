<!DOCTYPE html>
<html>

<head>
    <title>TrainStation prenotazione tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
</head>

<body>

    <?php
    session_start();
    include "./connessionePDO.php";
    $id_utente = isset($_SESSION['id_utente']) ? $_SESSION['id_utente'] : '';

    
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
    $id_tratta = isset($_SESSION['id_tratta']) ? $_SESSION['id_tratta'] : '';

    ?>

    <header>

        <h1><?php echo $nome . ' ' . $cognome; ?></h1>
        <h2>Prenotazione ticket</h2>

    </header>

    <form action="../API/client.php" method="POST">

        <?php

            if ($id_tratta) {
                $sql_tratta = "SELECT * FROM tratta WHERE id_tratta = :id";
                $stmt_tratta = $db->prepare($sql_tratta);
                $stmt_tratta->bindParam(':id', $id_tratta, PDO::PARAM_INT);
                $stmt_tratta->execute();
                $result_tratta = $stmt_tratta->fetch(PDO::FETCH_ASSOC);

                
                $nome_stazione_partenza = '';
                $nome_stazione_arrivo = '';

                if ($result_tratta) {
                    foreach ($result_tratta as $key => $value) {
                        switch ($key) {
                            case 'costo_biglietto':
                                echo '<strong>' . str_replace('_', ' ', $key) . ':</strong> ' . number_format($value, 2, '.', '') . ' $<br>';
                                break;
                            case 'id_stazione_partenza':
                            case 'id_stazione_arrivo':
                                $sql_stazione = "SELECT nome_stazione FROM stazione WHERE id_stazione = :id";
                                $stmt_stazione = $db->prepare($sql_stazione);
                                $stmt_stazione->bindParam(':id', $value, PDO::PARAM_INT);
                                $stmt_stazione->execute();
                                $result_stazione = $stmt_stazione->fetch(PDO::FETCH_ASSOC);

                                
                                ${'nome_' . str_replace(['id_', '_stazione'], ['', ''], $key)} = $result_stazione ? $result_stazione['nome_stazione'] : 'Sconosciuta';

                                echo '<strong>' . str_replace(['id_', '_stazione'], ['', ''], $key) . ':</strong> ' . ${'nome_' . str_replace(['id_', '_stazione'], ['', ''], $key)} . '<br>';
                                break;
                            case 'data_orario_partenza':

                                echo '<strong>' . str_replace(['_', 'partenza', 'arrivo'], [' ', ' partenza', ' arrivo'], $key) . ':</strong> ' . $value . '<br>';
                                break;
                            default:
                                break;
                        }
                    }
                } else {
                    echo 'Tratta non trovata.';
                }
            } else {
                echo 'ID tratta non presente in sessione.';
            }

            
            $_SESSION['costo_biglietto_format'] = number_format($result_tratta['costo_biglietto'], 2, '.', '') . ' $';
            $_SESSION['partenza'] = $nome_stazione_partenza;
            $_SESSION['arrivo'] = $nome_stazione_arrivo;
            $_SESSION['data_partenza_format'] = $result_tratta['data_orario_partenza'];
            $_SESSION['causale'] = "biglietto treno";

            

        ?>

        <br><button type="submit">effettua pagamento</button>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
</body>

</html>