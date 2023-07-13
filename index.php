<?php 
  include("include/config.php");
  include("include/pages.php");
  session_start();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <link href='style.css' rel='stylesheet'>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $brandName . ' - ' . (isset($_GET['page']) ? ucfirst($_GET['page']) : ucfirst('home'));?></title>
    <link rel="icon" href="<?php echo $brandIcon?>">
</head>
<body>
    <?php
    include("include/header.php");
    $pagina = (isset($_GET['page']) ? $_GET['page'] : 'home');
    echo $paginas[$pagina];
    if(!array_key_exists($pagina, $paginas)){
      $pagina = 'home';
    };
    include("include/footer.php");
    ?>
    <script src="script.js"></script>
</body>
</html>