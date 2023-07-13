<?php

include("../../config.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if ($conn->connect_error) {
        die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
    }

    $query = "SELECT * FROM user WHERE USER_NAME = '$username' AND USER_PASSWORD = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nivel = $row['USER_PERM'];
        $username = $row['USER_NAME'];
        $adv = $row['USER_ADV'];
        $email = $row['USER_EMAIL'];
        $phone = $row['USER_PHONE'];
        $icon = $row['USER_ICON'];
        
        
        


        session_start();
        $_SESSION['USER_NAME'] = $username;
        $_SESSION['USER_ADV'] = $adv;
        $_SESSION['USER_EMAIL'] = $email;
        $_SESSION['USER_PHONE']= $phone;
        $_SESSION['USER_ICON'] = $icon;
        $_SESSION['USER_PERM'] = $nivel;
        header('Location: ../painel.php');
    } else {
        header('Location: ../index.php?error=1');
    }

    $conn->close();
} else {
    header('Location: ../index.php?error=2');
}