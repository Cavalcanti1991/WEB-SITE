<?php
session_start();

include("include/config.php");
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userNick = $_POST["userNick"];
    $password = $_POST["password"];

    // Consulta SQL para obter o usuário com base no USER_NICK
    $sql = "SELECT * FROM user WHERE USER_NICK = '$userNick'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['USER_PASSWORD'];

        // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
        if (password_verify($password, $hashedPassword)) {
            // Autenticação bem-sucedida, armazena os dados do usuário na sessão 'user'
            $_SESSION['user'] = $user;
            header("Location: profile.php");
            exit();
        } else {
            $error_message = "Nome de usuário ou senha incorretos.";
        }
    } else {
        $error_message = "Nome de usuário ou senha incorretos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    // Exibe a mensagem de erro, se houver
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="userNick">User Nick:</label>
        <input type="text" id="userNick" name="userNick" required><br><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
