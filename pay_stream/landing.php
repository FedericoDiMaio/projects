<!DOCTYPE html>
<html>

    <head>
        <title>PayStream home page</title>
    </head>

    <header>
        <H1>PayStream Home Page</H1>
    </header>
    <?php
    session_start();
    ?>
    <body>
        <header>
        <h1>login</h1>
        </header>
 
        

        <form action="./loginCheck.php" method="POST">
            
            <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            </div>
        
            <div class="form-row">
            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>
            </div>
        
            <div class="form-row">
            <input type="submit" value="Login">
            </div>
            
            
        </form>
        <a href="./registrazioneUtente.html"><button>Registrati</button></a><br>
    
    
    </body>
</html>











  


