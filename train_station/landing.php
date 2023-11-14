<!DOCTYPE html>
<html>

<head>
    <title>TrainStation home page</title>
</head>

<header>
    <H1>TrainStation Home Page</H1>
</header>


<body>

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

        session_start();

        

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stazione_partenza = isset($_POST['partenza']) ? intval($_POST['partenza']) : null;

            $sql_stazione_partenza = "SELECT * FROM stazione WHERE id_stazione = :id";
            $stmt_stazione_partenza = $db->prepare($sql_stazione_partenza);
            $stmt_stazione_partenza->bindValue(':id', $stazione_partenza, PDO::PARAM_INT);
            $stmt_stazione_partenza->execute();
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stazione_destinazione = isset($_POST['destinazione']) ? intval($_POST['destinazione']) : null;

            $sql_stazione_destinazione = "SELECT * FROM stazione WHERE id_stazione = :id";
            $stmt_stazione_destinazion = $db->prepare($sql_stazione_destinazione);
            $stmt_stazione_destinazion->bindValue(':id', $stazione_destinazione, PDO::PARAM_INT);
            $stmt_stazione_destinazion->execute();


        }
        
        



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["data-partenza"])) {
                $dataPartenza = new DateTime($_POST["data-partenza"]);
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["orario-partenza"])) {
                $orarioPartenza = new DateTime($_POST["orario-partenza"]);
            }
        }





    ?>

    <form action="./landingCheck.php" method="POST">

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


    <form action="./loginNonEffettuato.html" method="POST">

        <button type="submit">prenota treno</button>

    </form>


    <nav>

        <a href="./login.html"><button>Login</button></a> <br>
        <a href="./registrazione.html"><button>Signup</button></a>

    </nav>

</body>

</html>