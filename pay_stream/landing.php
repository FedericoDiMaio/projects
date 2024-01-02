<!DOCTYPE html>
<html>

<head>
    <title>PayStream Home Page</title>
</head>

<body>
    <header>
        
    </header>

    <div>
    
        <h2>Benvenuto su PayStream!</h2>
        <h3>Termini e Condizioni </h3>
        <p>Prima di continuare, ti preghiamo di leggere attentamente e accettare i nostri Termini e Condizioni se sei già un utente registrato affettua la login.</p>
        
        <form action="./registrazioneUtente.html" method="POST">
            <input type="checkbox" id="accetta_condizioni" required>
            <label for="accetta_condizioni">Accetto i Termini e Condizioni</label>
            <br>
            <button type="submit" id="registrazione_button" disabled>Registrati</button>
            
        </form>
    </div><br>

    <form action="./loginCheck.php" method="POST">
        <?php
        session_start();
        include "./connessionePDO2.php";
        ?>

        <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-row">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-row">
            <input type="submit" value="Login">
        </div>

    </form><br>
    <a href="documentazione/termini e condizioni.pdf">Termini e Condizioni</a>


    <script>
        document.getElementById("accetta_condizioni").addEventListener("change", function () {
            document.getElementById("registrazione_button").disabled = !this.checked;
        });
    </script>
    

</body>

</html>
