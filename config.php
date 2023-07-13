<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "roshal";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

$result = mysqli_query($conn, "SHOW DATABASES LIKE '$db_name'");
if (mysqli_num_rows($result) == 0) {
    header("Location: /install/");
}

if ($conn->connect_error) {
    echo "Erro de conexão: " . $conn->connect_error;
}

$sql = "SELECT * FROM config";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $brandName = $row['BRAND_NAME'];
    $brandIcon = $row['BRAND_ICON'];
    $brandTelegram = $row['BRAND_TELEGRAM'];
    $brandFacebook = $row['BRAND_FACEBOOK'];
    $brandTwitter = $row['BRAND_TWITTER'];
    $brandDiscord = $row['BRAND_DISCORD'];
    $brandCfx = $row['BRAND_CFX'];
    $brandTiktok = $row['BRAND_TIKTOK'];
    $brandShop = $row['BRAND_SHOP'];
    $brandTwitch = $row['BRAND_TWITCH'];
} else {
    echo "Nenhum resultado encontrado.";
}
?>