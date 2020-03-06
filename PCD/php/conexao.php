<?php
$usuario = "placafipe";
$senha = "8l61AARI4lu7ZIpK";
$banco_de_dados = "consulta_fipe";
$ip = "api.crmtony.com.br"; 
$conn = mysqli_connect($ip,$usuario,$senha);
mysqli_select_db($conn,$banco_de_dados);
?>