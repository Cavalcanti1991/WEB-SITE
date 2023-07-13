<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "roshal";

try {
    $conn = new mysqli($db_host, $db_user, $db_password);

    if ($conn->connect_error) {
        die("<br>Falha na conexão: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";

    if ($conn->query($sql) === true) {
        echo "O banco de dados 'roshal' foi criado com sucesso!";
    } else {
        echo "<br>Erro na criação do banco de dados 'roshal': " . $conn->error;
    }

    sleep(5); // Delay for 10 seconds

    $conn->select_db($db_name);

    $sql = "CREATE TABLE IF NOT EXISTS config (
        BRAND_ID INT(1) PRIMARY KEY AUTO_INCREMENT,
        BRAND_NAME VARCHAR(255),
        BRAND_ICON VARCHAR(255),
        BRAND_TELEGRAM VARCHAR(255),
        BRAND_FACEBOOK VARCHAR(255),
        BRAND_TWITTER VARCHAR(255),
        BRAND_DISCORD VARCHAR(255),
        BRAND_CFX VARCHAR(255),
        BRAND_TIKTOK VARCHAR(255),
        BRAND_SHOP VARCHAR(255),
        BRAND_TWITCH VARCHAR(255)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'config' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'config' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'config': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $sql = "CREATE TABLE IF NOT EXISTS user (
        USER_ID INT(255) PRIMARY KEY AUTO_INCREMENT,
        USER_NICK VARCHAR(20),
        USER_NAME VARCHAR(255),
        USER_AGE INT(3),
        USER_EMAIL VARCHAR(100),
        USER_PHONE VARCHAR(255),
        USER_PASSWORD INT(11),
        USER_QUESTIONS VARCHAR(255),
        USER_WL VARCHAR(255),
        USER_ADV INT(1),
        USER_GROUPS VARCHAR(255),
        USER_ICON VARCHAR(255),
        USER_DISCORDID INT(40)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'user' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'user' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'user': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $sql = "CREATE TABLE IF NOT EXISTS products (
        PRODUCT_ID INT(10) PRIMARY KEY AUTO_INCREMENT,
        PRODUCT_NAME VARCHAR(255),
        PRODUCT_DESCRIPTION VARCHAR(255),
        PRODUCT_ICON VARCHAR(255),
        PRODUCT_STOCK VARCHAR(255),
        PRODUCT_PRICE VARCHAR(255),
        PRODUCT_CATEGORIES VARCHAR(255)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'products' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'products' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'products': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $sql = "CREATE TABLE IF NOT EXISTS contact (
        CONTACT_ID INT(255) PRIMARY KEY AUTO_INCREMENT,
        CONTACT_NAME VARCHAR(255),
        CONTACT_DESCRIPTION VARCHAR(255),
        CONTACT_DATA VARCHAR(255)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'contact' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'contact' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'contact': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $sql = "CREATE TABLE IF NOT EXISTS changelog (
        CHANGELOG_ID INT(255) PRIMARY KEY AUTO_INCREMENT,
        CHANGELOG_CDS VARCHAR(255),
        CHANGELOG_DESCRIPTION VARCHAR(255),
        CHANGELOG_DATA VARCHAR(255)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'changelog' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'changelog' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'changelog': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $sql = "CREATE TABLE IF NOT EXISTS car (
        CAR_ID INT(255) PRIMARY KEY AUTO_INCREMENT,
        CAR_NAME VARCHAR(255),
        CAR_HASH VARCHAR(255),
        CAR_FOTO VARCHAR(255),
        CAR_SPAWN VARCHAR(255)
    )";

    if ($conn->query($sql) === true) {
        echo "<br>A tabela 'car' foi criada com sucesso!";
    } else {
        if ($conn->errno == 1050) {
            echo "<br>A tabela 'car' já existe. Pulando para a próxima etapa.";
        } else {
            echo "<br>Erro na criação da tabela 'car': " . $conn->error;
        }
    }

    sleep(5); // Delay for 10 seconds

    $conn->close();
} catch (PDOException $e) {
    echo "Erro na criação da tabela: " . $e->getMessage();
}
?>
