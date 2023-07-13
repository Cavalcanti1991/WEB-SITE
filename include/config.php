<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "roshal";

// Cria a conexão com o banco de dados
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    echo "Erro de conexão: " . $conn->connect_error;
    exit;
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

// Fecha a conexão
$conn->close();
?>