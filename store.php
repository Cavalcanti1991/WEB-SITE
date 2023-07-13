<?php
include("include/config.php");
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
function getProducts($conn, $category = null) {
    $query = "SELECT * FROM products";
    if ($category) {
        $query .= " WHERE PRODUCT_CATEGORIES LIKE '%$category%'";
    }
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}
function getCategories($conn) {
    $query = "SELECT DISTINCT PRODUCT_CATEGORIES FROM products";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $categories;
}
$categories = getCategories($conn);
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$products = getProducts($conn, $selectedCategory);
mysqli_close($conn);
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

    <?php include("include/header.php");?>

    <div class="store">
        <div>
            <h2>Produtos:</h2>
        </div>
        <div>
            <form method="get"><label for="category">Categorias:</label><?php foreach ($categories as $category): ?> <a
                    href="?category=<?php echo $category['PRODUCT_CATEGORIES']; ?>"
                    <?php if ($selectedCategory === $category['PRODUCT_CATEGORIES']) echo 'style="font-weight:500"'; ?>><?php echo ucfirst($category['PRODUCT_CATEGORIES']); ?></a>
                <?php endforeach; ?> <a href="?category=">Todas</a></form>
        </div>
    </div>
    <section style="padding: 50px 0px;min-height: 70vh;">
    <div class="cards">
        <?php 
        foreach ($products as $product): 
            echo '<div class="card">';
            echo '<img src="'. $product['PRODUCT_ICON'] .'">';
            echo '<h3>'. $product['PRODUCT_NAME'] .'</h3>';
            echo '<div class="flex">';
            echo '<div>Estoque: '. $product['PRODUCT_STOCK'] .'</div>';
            echo '<div>Descrição: ' . $product['PRODUCT_DESCRIPTION'] . '</div>';
            echo '</div>';
            echo '<div class="flex">';
            echo '<div><button><a href="?adicionar_carrinho=' . $product["PRODUCT_ID"] . '">Adicionar ao Carrinho</a></button></div>';
            echo '<div>Preço: R$'. $product['PRODUCT_PRICE'] .'</div>';
            echo '</div>';
            echo '</div>';
        endforeach;
        ?>
    </div>
    </section>
    <?php include("include/footer.php");?>

    <script src="script.js"></script>
</body>

</html>