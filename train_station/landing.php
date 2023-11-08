<!DOCTYPE html>
<html>

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

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $selected_workstation = isset($_POST['workstation']) ? intval($_POST['workstation']) : null;
                $selected_direction = isset($_POST['direction']) ? $_POST['direction'] : null;
                $round_trip = isset($_POST['round_trip']) && $_POST['round_trip'] == 'yes';

                if (empty($selected_workstation) || empty($selected_direction)) {
                    echo 'Please select a station';
                    exit;
                }

                $sql = "SELECT * FROM stazione WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $selected_workstation, PDO::PARAM_INT);
                $stmt->execute();

                $workstation_data = $stmt->fetch(PDO::FETCH_ASSOC);

                echo 'Selected workstation: ' . htmlspecialchars($workstation_data['nome_stazione']) . '<br>';
                echo 'Selected direction: ' . htmlspecialchars($selected_direction) . '<br>';

                //  TODO Aggiungi il codice per ottenere e visualizzare $km_stazione
            }
        ?>
        
        <header>
            <div class="logo">TrainStation landing</div>
            <nav>
                <ul>
                    <li><a href="./login.html">Login</a></li>
                    <li><a href="./registrazione.html">Signup</a></li>
                </ul>
            </nav>
        </header>

            <form method="POST">
                <div class="form-group">
                    <label for="departure">Stazione di partenza</label>

                    <select name="workstation">

                        <?php
                            $sql = "SELECT * FROM stazione";
                            $result = $db->query($sql);

                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . intval($row["id"]) . '">' . htmlspecialchars($row["nome_stazione"]) . '</option>';
                                }
                            }
                        ?>

                    </select>

                </div>

                <div class="form-group">
                    <label for="destination">Stazione di destinazione</label>

                    <select name="destination">

                        <?php
                        // TODO Ripeti il codice simile per la stazione di destinazione
                        ?>

                    </select>

                </div>

                <div class="form-group">
                    <label for="depart-date">Data di partenza</label>
                    <input type="date" id="depart-date" name="depart-date" required>
                </div>

                <div class="form-group">
                    <label for="return-date">Data di ritorno</label>
                    <input type="date" id="return-date" name="return-date" required>
                </div>

                <button type="submit">Cerca treni</button>

            </form>
        
    </body>

</html>