<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrazione utente</title>
    
  </head>
  <body>
    <header>
      <h1>Registrazione utente</h1>
    </header>
    <form action="../login/utility/saveregistrazione.php" method="POST">
      <div class="form-row">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
      </div>
      <div class="form-row">
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required>
      </div>
      <div class="form-row">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-row">
        <label for="telefono">Numero di telefono:</label>
        <input type="tel" id="telefono" name="telefono" required>
      </div>
      <div class="form-row">
        <label for="residenza">Residenza:</label>
        <input type="text" id="residenza" name="residenza" required>
      </div>
      <div class="form-row">
        <label for="data_di_nascita">Data di nascita:</label>
        <input placeholder="yyyy-mm-dd" type="text" id="data_di_nascita" name="data_di_nascita" required>
      </div>
      <div class="form-row">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-row">
        <label for="conferma_password">Conferma password:</label>
      <input type="password" id="conferma_password" name="conferma_password" required>
    </div>
    
    <div class="form-row">
      <input type="submit" value="Registrati">
    </div>
  </form>
</body>
