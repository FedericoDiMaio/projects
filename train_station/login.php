<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>login utente</title>
    
  </head>
  <body>
    <header>
      <h1>login</h1>
    </header>
 
    <form action="./utility/checklogin.php" method="POST">
      
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
  
</body>
</html

