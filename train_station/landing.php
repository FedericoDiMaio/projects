<!DOCTYPE html>
<html>

<head>
    <title>Train Station home page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	
</head>

<header>
    <H1>Train Station Home Page</H1>
</header>


<body>

    <?php

    include "./connessionePDO.php";
    session_start();
    


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stazione_partenza = isset($_POST['partenza']) ? intval($_POST['partenza']) : null;
        $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;

               


        
        $sql_stazioni = "SELECT * FROM stazione WHERE id_stazione IN (:id_partenza, :id_destinazione)";
        $stmt_stazioni = $db->prepare($sql_stazioni);
        $stmt_stazioni->bindValue(':id_partenza', $stazione_partenza, PDO::PARAM_INT);
        $stmt_stazioni->bindValue(':id_destinazione', $stazione_destinazione, PDO::PARAM_INT);
        $stmt_stazioni->execute();
    
        
        $risultati_stazioni = $stmt_stazioni->fetchAll(PDO::FETCH_ASSOC);
    
        
        foreach ($risultati_stazioni as $stazione) {
            if ($stazione['id_stazione'] == $stazione_partenza) {

            } elseif ($stazione['id_stazione'] == $stazione_destinazione) {

            }
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["data-partenza"])) {
            $dataPartenza = new DateTime($_POST["data-partenza"]);
        }

        if (isset($_POST["orario-partenza"])) {
            $orarioPartenza = new DateTime($_POST["orario-partenza"]);
        }
    }

    ?>

    <form action="./landingCheck.php" method="POST" onsubmit="return validateForm()">

    <script>
    function validateForm() {
        var partenzaSelect = document.getElementsByName("partenza")[0];
        var destinazioneSelect = document.getElementsByName("destinazione")[0];

        var partenzaValue = partenzaSelect.value;
        var destinazioneValue = destinazioneSelect.value;

        
        if (partenzaValue === destinazioneValue) {
            alert("La stazione di partenza non può essere uguale a quella di destinazione.");
            return false; 
        }

        return true; 
    }
    </script>

        <div class="form-group">
            <label for="partenza">Stazione di partenza</label>

            <select name="partenza">

                <?php
         
                $sql = "SELECT * FROM stazione";
                $result = $db->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_stazione"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                    }
                }

                ?>

            </select>

        </div>

        <div class="form-group">
            <label for="destinazione">Stazione di destinazione</label>

            <select name="destinazione">

                <?php

                $result = $db->query($sql);

                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . intval($row["id_stazione"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                    }
                }
            
                ?>


            </select>

        </div>

        <div class="form-group">
            <label for="data-partenza">Data di partenza</label>
            <input type="date" id="data-partenza" name="data-partenza" required>
        </div>



        <div class="form-group">
            <label for="orario-partenza">Orario di partenza</label>
            <input type="time" id="orario-partenza" name="orario-partenza" required>
        </div>

        

            <button type="submit">Cerca treni</button>
        
    

        


    </form>





    <nav>

        <a href="./login.html"><button>Login</button></a> <br>
        
        <a href="./registrazione.html"><button>registrazione</button></a> <br>
        <p></p>
        <a href="../"><button>projects</button></a>

    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
</body>

</html>