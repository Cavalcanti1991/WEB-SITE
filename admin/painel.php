<?php
  include("../include/config.php");
  session_start();

  if (isset($_SESSION['USER_PERM']) >= "3") {

}else {
    header('Location: index.php?error=4');
}

?>
<!doctype html>
<html lang="pt-br">
  <head>

    <link href='../style.css' rel='stylesheet'>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php echo $brandName?></title>
    <link rel="icon" href="<?php echo $brandIcon?>">

  </head>
    <body>
      <div style="display: flex;position:fixed;top:0;left:0px;">
        <?php include("header");?>
        <div style="overflow-y: scroll;max-height: 100vh;padding: 20px;width: calc(75vw - 80px);">
        
          

        </div>
      </div>
      <script src="../script.js"></script>
    </body>
</html>