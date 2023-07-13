<?php
include("include/config.php");

$db_name = "creative";
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

$query = "UPDATE summerz_accounts SET whitelist = 0";
$result = $conn->query($query);

if ($result === TRUE) {
    echo "Foi removido todas as whitelist's com sucesso";
} else {
    echo "Erro ao atualizar o campo 'whitelist': " . $conn->error;
}

$conn->close();
?>