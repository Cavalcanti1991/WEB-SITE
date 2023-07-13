<?php
session_start();

if(isset($_SESSION['user'])){
    if($_SESSION['permission'] >= 2){
        header("Location: painel.php");
    }else{
        echo "ERRO > SEM PERMISSÃO" . "<br>" . "AVISO PAINEL > USUARIO SEM CREDENCIAL LOGOU NA PAGINA ADMIN + INFOS";
    }
}else{
    header("Location: login.php");
}
?>