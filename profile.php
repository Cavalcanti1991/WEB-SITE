<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Obtém os dados do usuário armazenados na sessão
$user = $_SESSION['user'];

// Função para obter a cor com base nos grupos de usuário
function getUserColor($user, $groupColors) {
    $userGroups = isset($user['groups']) ? $user['groups'] : array();

    foreach ($userGroups as $group => $value) {
        if ($value && isset($groupColors[$group])) {
            return $groupColors[$group];
        }
    }

    return 'default-color'; // cor padrão caso o usuário não tenha um grupo definido
}

// Função para obter as imagens dos grupos de usuário
function getGroupImages($user, $groupImages) {
    $userGroups = isset($user['groups']) ? $user['groups'] : array();
    $images = array();

    foreach ($userGroups as $group => $value) {
        if ($value && isset($groupImages[$group])) {
            $images[] = $groupImages[$group];
        }
    }

    return $images;
}

// Definição das cores para cada grupo de usuário
$groupColors = array(
    'CEO' => 'green',
    'DEV' => 'blue',
    'MECANICO' => 'red',
    'PARAMEDICO' => 'yellow',
    'MORADOR' => 'purple'
    // Adicione mais grupos e cores conforme necessário
);

// Definição das imagens para cada grupo de usuário
$groupImages = array(
    'CEO' => 'https://www.fm2s.com.br/storage/blog/images/o-que-e-um-ceo-qual-o-seu-papel-na-empresa.webp',
    'DEV' => 'https://solutis.com.br/wp-content/uploads/2020/12/dev-carreira.jpg',
    'MECANICO' => 'mecanico.png',
    'PARAMEDICO' => 'paramedico.png',
    'MORADOR' => 'morador.png'
    // Adicione mais grupos e imagens conforme necessário
);

// Obtém a cor do perfil com base nos grupos de usuário
$userColor = getUserColor($user, $groupColors);

// Obtém as imagens dos grupos de usuário
$groupImages = getGroupImages($user, $groupImages);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil do Usuário</title>
    <style>
        .profile {
            border: 2px solid <?php echo $userColor; ?>;
            padding: 10px;
        }
        .group-image {
            width: 50px;
            height: 50px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h2>Perfil do Usuário</h2>
    <div class="profile">
        <p><strong>ID:</strong> <?php echo $user['USER_ID']; ?></p>
        <p><strong>User Nick:</strong> <?php echo $user['USER_NICK']; ?></p>
        <p><strong>Nome:</strong> <?php echo $user['USER_NAME']; ?></p>
        <p><strong>Idade:</strong> <?php echo $user['USER_AGE']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['USER_EMAIL']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $user['USER_PHONE']; ?></p>
        <p><strong>Senha:</strong> <?php echo $user['USER_PASSWORD']; ?></p>
        <p><strong>Perguntas:</strong> <?php echo $user['USER_QUESTIONS']; ?></p>
        <p><strong>WL:</strong> <?php echo $user['USER_WL']; ?></p>
        <p><strong>ADV:</strong> <?php echo $user['USER_ADV']; ?></p>
        <p><strong>Permissões:</strong></p>
        <ul>
            <?php if (isset($user['USER_GROUPS'])) : ?>
                <?php $userGroups = json_decode($user['USER_GROUPS'], true); ?>
                <?php foreach ($userGroups as $group => $value) : ?>
                    <?php if ($value) : ?>
                        <li>
                            <?php if (isset($groupImages[$group])) : ?>
                                <img class="group-image" src="<?php echo $groupImages[$group]; ?>" alt="<?php echo $group; ?>">
                            <?php endif; ?>
                            <?php echo $group; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <p><strong>Ícone:</strong> <img src="<?php echo $user['USER_ICON']; ?>" alt="Ícone do usuário" width="100"></p>
        <p><strong>ID do Discord:</strong> <?php echo $user['USER_DISCORDID']; ?></p>
    </div>
</body>
</html>
