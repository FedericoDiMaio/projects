<!DOCTYPE html>
<html>

<head>
    <title>TrainStation prenotazione tickets</title>
</head>

<body>

    <?php
    session_start();
    include "./connessionePDO.php";

    $id_tratta = isset($_SESSION['id_tratta']) ? $_SESSION['id_tratta'] : null;
    $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';

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

            

        ?>

        <br><button type="submit">effettua pagamento</button>

    </form>
    
</body>

</html>