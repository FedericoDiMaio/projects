<!DOCTYPE html>
<html>

    <head>
        <title>TrainStation profilo amministrativo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
    </head>

        <body>

            <?php
                include "../pay_stream/connessionePDO2.php";
                include "./connessionePDO.php";
                session_start();
                
                $nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
                $cognome = isset($_SESSION['cognome']) ? $_SESSION['cognome'] : '';
            ?>

            <header>
                <h1>Benvenuto <?php echo $nome . ' ' . $cognome; ?></h1>
                <h2>Profilo Amministrativo</h2>
            </header>


            <form action="./utenteAmministrativoCheckDelete.php" method="POST">
<p></p>
<p></p>
<label for="treni" style="font-size: 20px;">Treni Attivi</label>


<select name="treni">

    <?php

    $sql = "SELECT ct.id_treno, ct.id_carrozze, ct.id_locomotive, ct.numero_posti_totale, ct.data_inizio_servizio, ct.data_fine_servizio
                    FROM composizione_treno ct;";



    $result = $db->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . intval($row["id_treno"]) . '"> '
                . 'ID TRENO =  ' . htmlspecialchars($row["id_treno"])
                . ', POSTI TOTALI = ' . htmlspecialchars($row["numero_posti_totale"])
                . ', DATA INIZIO SERVIZIO = ' . htmlspecialchars($row["data_inizio_servizio"])
                . ', DATA FINE SERVIZIO = ' . htmlspecialchars($row["data_fine_servizio"])
                . '</option>';
        }
    }


    ?>

</select><br>
<p></p>




<button type="button" onclick="location.href='./utenteComposizioneAmministrativo.php';">Aggiungi treno</button><br>

</form>


            <button type="button" onclick="location.href='./utenteAmministrativoRedittività.php';">visualizza rendita treni</button><br>
<p></p>
            <button type="button" onclick="location.href='./out.php';">Logout</button>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
                

            
        </body>

</html>