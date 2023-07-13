<?php
    include("../include/config.php");
?>
<!DOCTYPE html>
<html>
    <head>
    <link href='../style.css' rel='stylesheet'>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo $brandName?></title>
    <link rel="icon" href="<?php echo $brandIcon?>">
    </head>
    <body>
        <h2>Login</h2>
        <form method="POST" action="functions/login.php">
            <label for="username">Usuário:</label>
            <input type="text" name="username" required><br><br>
            <label for="password">Senha:</label>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Entrar">
        </form>
    </body>
</html>