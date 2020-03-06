<?php
$usuario = "root";
$senha = "root";
$banco_de_dados = "tony-veiculos";
$ip = "127.0.0.1"; 
$conexao = mysqli_connect($ip,$usuario,$senha);
mysqli_select_db($conexao,$banco_de_dados);
?>