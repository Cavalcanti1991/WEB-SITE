<?php
include("config.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Obtém os dados do usuário armazenados na sessão
$user = $_SESSION['user'];

// Obtém o USER_DISCORDID do usuário
$userDiscordID = $user['USER_DISCORDID'];

// Array com as perguntas
$questions = array(
    "Informe com poucas palavras qual seria o rumo do seu personagem",
    "Explique com suas palavras o que é roleplay",
    "Você leu as diretrizes e regras da cidade",
    "Cite uma regra que você acha boa ou negativa e explique o porquê",
    "Qual era o tipo de personagem que você já criou em outras cidades",
    "Quando você acha que é bom sair do personagem",
    "Qual é o seu plano para o primeiro dia na cidade",
    "Qual é a história do seu personagem? (SEM PLAGIO)",
    "Pontos positivos e negativos do seu personagem",
    "Você compreende que se for uma pessoa tóxica poderá acarretar em um banimento?",
    "Por que você deveria ser aprovado na nossa cidade?",
    "Escreva um texto de 5 (cinco) linhas sobre você!",
    "Por que nós deveríamos liberar para a $brandName",
    "Fale no mínimo 2 (dois) defeitos seus"
);

// Função para randomizar as perguntas
function shuffleQuestions($questions) {
    shuffle($questions);
    return $questions;
}

// Função para processar as respostas
function processAnswers($userDiscordID, $questions, $answers, $conn) {
    // Converte as perguntas e respostas em um array associativo
    $data = array_combine($questions, $answers);

    // Converte o array em formato JSON
    $jsonData = json_encode($data);

    // Escapa caracteres especiais para uso em consultas SQL
    $jsonData = $conn->real_escape_string($jsonData);

    // Verifica se já existe um registro de perguntas e respostas para o usuário
    $sql = "SELECT * FROM user WHERE USER_DISCORDID = '$userDiscordID'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Já existe um registro, então atualiza as perguntas e respostas
        $sql = "UPDATE user SET USER_QUESTIONS = '$jsonData' WHERE USER_DISCORDID = '$userDiscordID'";
    } else {
        // Não existe um registro, então insere um novo registro
        $sql = "INSERT INTO user (USER_DISCORDID, USER_QUESTIONS) VALUES ('$userDiscordID', '$jsonData')";
    }

    $result = $conn->query($sql);

    if ($result) {
        // Redireciona para a página inicial
        header("Location: index.php");
        exit();
    } else {
        // Caso haja um erro na atualização do banco de dados
        echo "Erro ao armazenar as perguntas e respostas no banco de dados: " . $conn->error;
    }
}

// Conexão com o banco de dados
include("include/config.php");
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa as respostas
    processAnswers($userDiscordID, $questions, $_POST['answers'], $conn);
}

// Randomiza as perguntas
$questions = shuffleQuestions($questions);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Perguntas</title>
</head>
<body>
    <h2>Formulário de Perguntas</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php 
        foreach ($questions as $question) {
            ?>
            <label for="<?php echo $question; ?>"><?php echo $question; ?>:</label>
            <input type="text" id="<?php echo $question; ?>" name="answers[]" required><br><br>
            <?php
        } 
        ?>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
