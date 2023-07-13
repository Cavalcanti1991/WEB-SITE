<?php
include("include/config.php");

$db_name = "creative";

// Cria uma conexão com o banco de dados
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Verifica se houve algum erro na conexão
if (!$conn) {
    echo "Erro de conexão: " . mysqli_connect_error();
    exit;
}

// Consulta os discordIDs e whitelist na tabela summerz_accounts
$query = "SELECT discord, whitelist FROM summerz_accounts";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Erro ao consultar a tabela summerz_accounts: " . mysqli_error($conn);
    exit;
}

$discordIDs = array();
$whitelistStatus = array();

// Obtém os discordIDs e whitelist do resultado da consulta
while ($row = mysqli_fetch_assoc($result)) {
    $discordIDs[] = $row['discord'];
    $whitelistStatus[$row['discord']] = $row['whitelist'];
}

// Grupo específico no qual verificar a presença dos IDs
$grupoDiscord = "1091918395508805753";

// Token do bot do Discord
$botToken = "MTA4NDUzODgxOTU1NjE1OTU5OQ.G5Hdil.N5Ml4RQV5oqlV_D6nvLvy90H5eUoJ8TFhDp03E";

// Array para armazenar os usuários removidos
$usuariosRemovidos = array();
// Array para armazenar os usuários adicionados ao cargo
$usuariosAdicionados = array();

// Itera pelos IDs do Discord
foreach ($discordIDs as $discordID) {
    // Verifica a presença do ID no grupo do Discord
    $url = "https://discord.com/api/v9/guilds/{$grupoDiscord}/members/{$discordID}";
    $headers = array(
        'Authorization: Bot ' . $botToken,
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    // Exibe a resposta para depuração
    // echo "Resposta para o ID {$discordID}: " . $response . "<br>";

    // Atualiza a coluna "whitelist" no banco de dados
    if ($response === false) {
        echo "Erro ao fazer a verificação para o ID {$discordID}.";
    } else {
        $responseData = json_decode($response);
        if (isset($responseData->roles) && $whitelistStatus[$discordID] == 1) {
            echo "ID {$discordID} está no grupo do Discord e possui whitelist ativa.<br>";

            // Verifica se o usuário possui o cargo específico
            $roleID = "1093278131407818893";
            $hasRole = false;

            foreach ($responseData->roles as $role) {
                if ($role == $roleID) {
                    $hasRole = true;
                    break;
                }
            }

            if ($hasRole) {
                echo "ID {$discordID} possui o cargo com ID {$roleID}.<br>";
            } else {
                echo "ID {$discordID} não possui o cargo com ID {$roleID}. Adicionando o cargo.<br>";

                // Atualiza a coluna "whitelist" para 0
                $updateSql = "UPDATE summerz_accounts SET whitelist = 1 WHERE discord = '$discordID'";
                $result = mysqli_query($conn, $updateSql);

                if ($result) {
                    echo "Whitelist atualizada com sucesso para o ID {$discordID}.<br>";

                    // Armazena o usuário adicionado
                    $usuariosAdicionados[] = $discordID;

                    // Adicionar o cargo ao usuário
                    $addRoleURL = "https://discord.com/api/v9/guilds/{$grupoDiscord}/members/{$discordID}/roles/{$roleID}";
                    $addRoleHeaders = array(
                        'Authorization: Bot ' . $botToken,
                        'Content-Type: application/json'
                    );

                    $addRoleCurl = curl_init();
                    curl_setopt($addRoleCurl, CURLOPT_URL, $addRoleURL);
                    curl_setopt($addRoleCurl, CURLOPT_HTTPHEADER, $addRoleHeaders);
                    curl_setopt($addRoleCurl, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($addRoleCurl, CURLOPT_RETURNTRANSFER, true);
                    $addRoleResponse = curl_exec($addRoleCurl);
                    curl_close($addRoleCurl);

                    if ($addRoleResponse === false) {
                        echo "Erro ao adicionar o cargo para o ID {$discordID}.";
                    } else {
                        echo "Cargo adicionado com sucesso para o ID {$discordID}.<br>";
                    }
                } else {
                    echo "Erro ao atualizar a whitelist para o ID {$discordID}.";
                }
            }
        } else {
            echo "ID {$discordID} não está no grupo do Discord ou não possui whitelist ativa. Ignorando verificação do cargo.<br>";
        }
    }
}

// Envia a webhook para informar os usuários removidos e adicionados
if (!empty($usuariosRemovidos) || !empty($usuariosAdicionados)) {
    $mensagem = "Atualização de usuários no grupo do Discord:\n";

    if (!empty($usuariosRemovidos)) {
        $mensagem .= "Usuários removidos:\n";
        foreach ($usuariosRemovidos as $usuario) {
            $mensagem .= "<@{$usuario}>\n";
        }
    }

    if (!empty($usuariosAdicionados)) {
        $mensagem .= "Usuários adicionados:\n";
        foreach ($usuariosAdicionados as $usuario) {
            $mensagem .= "<@{$usuario}>\n";
        }
    }

    $webhookURL = "https://discord.com/api/webhooks/1125637338396119042/shnmdo1wncrrKkyK_UhztBLOO3w8V5kzj-T9osEGf5lYHy1PMY1Kfi8HePBxgUio-BfB";

    $webhookData = array(
        'username' => $brandName,
        'avatar_url' => $brandIcon,
        'content' => $mensagem
    );

    $webhookJSON = json_encode($webhookData);

    $webhookCurl = curl_init($webhookURL);
    curl_setopt($webhookCurl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($webhookCurl, CURLOPT_POSTFIELDS, $webhookJSON);
    curl_setopt($webhookCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($webhookCurl, CURLOPT_RETURNTRANSFER, true);
    $webhookResponse = curl_exec($webhookCurl);
    curl_close($webhookCurl);

    if ($webhookResponse === false) {
        echo "Erro ao enviar a webhook.";
    } else {
        echo "Webhook enviada com sucesso.";
    }
}

// Fecha a conexão
mysqli_close($conn);
?>