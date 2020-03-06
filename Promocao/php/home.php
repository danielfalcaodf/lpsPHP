<?php
require "conexao.php";

$processo = @$_POST['processo'];


switch($processo){
	
	case "salvar":
		$nome      = @$_POST['nome'];
		$telefones = @$_POST['telefones'];
		
		$SQL_insert = "INSERT INTO nomes (NOM_NOME) VALUES ('".$nome."')";
		$SQL_query  = mysqli_query($conexao,$SQL_insert) or die(json_encode(array("resp" => "Falha ao salvar os dados: ".mysqli_error($conexao))));
		
		$cod = getCodigo('nomes','NOM',$conexao);
		$telefones = explode(";",$telefones);
		foreach($telefones as $numeros){
			$SQL_insert = "INSERT INTO telefones (NOM_CODIGO,TEL_NUMERO) VALUES ('".$cod."','".$numeros."')";
			$SQL_query  = mysqli_query($conexao,$SQL_insert) or die(json_encode(array("resp" => "Falha ao salvar os dados: ".mysqli_error($conexao))));
		}
		
		$resp["resp"] = "Os dados foram salvos com sucesso";
		print json_encode($resp);
	break;
}

function getCodigo($tabela,$trig,$conexao){
	
	$select = "SELECT ".$trig."_CODIGO FROM ".$tabela." ORDER BY ".$trig."_CODIGO DESC LIMIT 1";
	$query = mysqli_query($conexao,$select);
	$cod = mysqli_fetch_array($query);
	
	return $cod[$trig."_CODIGO"];
}

?>