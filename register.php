<?php
session_start();

include("include/config.php");
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário de registro foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST["userName"];
    $userAge = $_POST["userAge"];
    $userEmail = $_POST["userEmail"];
    $userPhone = $_POST["userPhone"];
    $userPassword = $_POST["userPassword"];
    $userIcon = $_FILES["userIcon"]["name"];
    $userDiscordID = $_POST["userDiscordID"];
    $userNick = $_POST["userNick"];

    // Hash da senha usando password_hash()
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Verifica se já existe um usuário com o mesmo nome de usuário, email, Discord ID ou User Nick
    $checkQuery = "SELECT * FROM user WHERE USER_NAME = '$userName' OR USER_EMAIL = '$userEmail' OR USER_DISCORDID = '$userDiscordID' OR USER_NICK = '$userNick'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "Nome de usuário, email, Discord ID ou User Nick já existente. Por favor, escolha outro.";
    } else {
        // Move o arquivo de imagem para o diretório desejado
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . basename($_FILES["userIcon"]["name"]);
        move_uploaded_file($_FILES["userIcon"]["tmp_name"], $targetFilePath);

        // Insere os dados na tabela
        $sql = "INSERT INTO user (USER_NAME, USER_AGE, USER_EMAIL, USER_PHONE, USER_PASSWORD, USER_ICON, USER_DISCORDID, USER_NICK)
            VALUES ('$userName', '$userAge', '$userEmail', '$userPhone', '$hashedPassword', 'uploads/$userIcon', '$userDiscordID', '$userNick')";

        if ($conn->query($sql) === TRUE) {
            $userId = $conn->insert_id;

            // Consulta para obter todas as informações do usuário recém-criado
            $userInfoQuery = "SELECT * FROM user WHERE USER_ID = '$userId'";
            $userInfoResult = $conn->query($userInfoQuery);

            if ($userInfoResult->num_rows == 1) {
                $userInfo = $userInfoResult->fetch_assoc();

                // Armazena os dados do usuário na sessão 'user'
                $_SESSION['user'] = $userInfo;
                
                echo "Registro inserido com sucesso!";
                // Redireciona para a página de perfil ou outra página de sua escolha
                header("Location: profile.php");
                exit();
            }
        } else {
            echo "Erro ao inserir o registro: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="userName" placeholder="Nome completo" required><br><br>
        <input type="number" name="userAge" placeholder="Idade" required><br><br>
        <input type="email" name="userEmail" placeholder="Email" required><br><br>
        <input type="text" name="userPhone" placeholder="Telefone" required><br><br>
        <input type="password" name="userPassword" placeholder="Senha" required><br><br>
        <input type="file" name="userIcon" accept="image/jpeg, image/png, image/gif" required><br><br>
        <input type="text" name="userDiscordID" placeholder="ID do Discord" required><br><br>
        <input type="text" name="userNick" placeholder="Nick do Usuário" required><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
