<?php
session_start();
require "conexao.php";

$processo = $_POST['processo'];

switch ($processo) {

	case 'FIPE':

		$placa = $_POST['placa'];

		try {
		   	
		   	if($placa != ""){
				$veiculo = json_decode(file_get_contents('http://179.145.7.20:4695/server/sinesp.php?placa='.$placa));

			    if (@$veiculo->{'error'} == "") {
				
					$carro_modelo = explode('/',$veiculo->{'marca'})[1];
					$carro_modelo = deParaModelos($conn,$carro_modelo);
					$carro_marca  = explode('/',$veiculo->{'marca'})[0];
					$carro_marca  = deParaMarcas($conn,$carro_marca);
					if($carro_marca == "VARIOS"){
						$carro_marca = explode(' ',$carro_modelo)[0];
						$carro_marca = deParaMarcas($conn,$carro_marca);
					}
					$carro_ano    = $veiculo->{'anoModelo'};
				}

				$SQL = "SELECT * FROM sinesp_carros WHERE nome_sinesp = '$carro_modelo'";
				$QRY = mysqli_query($conn,$SQL);
			
				if(mysqli_num_rows($QRY) > 0){

					$car = mysqli_fetch_array($QRY);

					$SQL2 = "SELECT * FROM veiculo_completo WHERE tipo = '".$car['tipo_veiculo']."' AND marca_id = '".$car['id_marca']."' AND modelo_id = '".$car['id_modelo']."' AND anomod = '".$veiculo->{'anoModelo'}."' LIMIT 1";
					$QRY2 = mysqli_query($conn,$SQL2);
					$info_final = mysqli_fetch_array($QRY2);

					$resp = array();
					$resp['cod']         = 0;
					$resp['marca']       = $car['marca'];
					$resp['modelo']      = $car['modelo'];
					$resp['ano']         = $veiculo->{'anoModelo'};
					$resp['valor']       = "R$ ".number_format($info_final['valor'],2,',','.');
					$resp['combustivel'] = $info_final['comb'];
				}
				else{

					$tipo_veiculo = "1";

					setor_marca:
					$SQL2   = "SELECT marca,marca_id FROM veiculo_completo WHERE tipo = $tipo_veiculo GROUP BY marca ";
					$QRY2   = mysqli_query($conn,$SQL2);
					
					$id_marca = "";
					while ($marcas = mysqli_fetch_array($QRY2)){
						if(strtoupper($marcas['marca']) == strtoupper($carro_marca)){
							$id_marca = $marcas['marca_id'];
							break;
						}
					}
					
					if($id_marca != "")$id_marca_aux = $id_marca;

					if($id_marca == ""){

						if($tipo_veiculo < 3){
							$tipo_veiculo++;
							goto setor_marca;
						}

						if($id_marca_aux == ""){
							$resp['cod'] = 1;
							$resp['msg']   = "Marca do carro não encontrada cadastrada (".$carro_marca.")";
						}
						else{
							$resp['cod'] = 1;
							$resp['msg']   = "Carro não encontrado na FIPE ($carro_modelo - Ano: $carro_ano)";
							print json_encode($resp);
							exit;
						}
						
						print json_encode($resp);
						exit;
					}
					
					if($placa != ""){
						$SQL3   = "SELECT modelo AS 'Label',modelo_id AS 'Value',comb,comb_cod,valor FROM veiculo_completo WHERE tipo = $tipo_veiculo AND anomod = '$carro_ano' AND marca_id = '$id_marca' ";
					}

					$QRY3   = mysqli_query($conn,$SQL3);
					$carros = array();
					while($aux_carros = mysqli_fetch_array($QRY3)){ 
							array_push($carros,$aux_carros);
					}
					$carros = encontraCarroID($conn,$carros,$carro_modelo);

					if(empty($carros)){	

						if($tipo_veiculo < 3){
							$tipo_veiculo++;
							goto setor_marca;
						}

						$resp['cod'] = 1;
						$resp['msg'] = "Carro não encontrado na FIPE ($carro_modelo - Ano: $carro_ano)";
						print json_encode($resp);
						exit;
					}
				
					if(count($carros) == 1){

						$idmodelo_fipe = $carros[0][1];
						$modelo_fipe   = $carros[0][0];
						$combus_fipe   = $carro_ano.'-'.$carros[0][3];

						$resp = array();
						$resp['cod']         	 = 0;
						$resp['marca']       	 = $carro_marca;
						$resp['modelo']       	 = $modelo_fipe;
						$resp['ano']         	 = $carro_ano;
						$resp['valor']       	 = "R$ ".number_format($carros[0][4],2,',','.');
						$resp['combustivel'] 	 = $carros[0][2];
					}
					else{
						$resp['cod'] = 2;
						$resp['carros']        = $carros;
						$resp['carro_ano']     = $carro_ano;
						$resp['carro_marca']   = $carro_marca;
						$resp['carro_idmarca'] = $id_marca;
						$resp['tipo_veiculo']  = $tipo_veiculo;
					}
				}
			}
			else{
				$carro_id = $_POST['id'];
				
				$SSQL  = "SELECT * FROM veiculo_completo WHERE id = '$carro_id' ";
				$query = mysqli_query($conn,$SSQL);
				$carro = mysqli_fetch_array($query);

				$resp = array();
				$resp['cod']         	 = 0;
				$resp['marca']       	 = $carro['marca'];
				$resp['modelo']       	 = $carro['modelo'];
				$resp['ano']         	 = $carro['anomod'];
				$resp['valor']       	 = number_format($carro['valor'],2,',','.');
				$resp['combustivel'] 	 = $carro['comb'];


			}

			
		}
		catch (\Exception $e) {
		    $resp['cod'] = 1;
		    $resp['msg']   = $e->getMessage();
		}
		if(isset($conn)){
			mysqli_close($conn);
		}
		print json_encode($resp);

	break;
	
	case 'modelos':

		if($_POST['marca'] == "GM - Chevrolet"){
			$sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'GM - Chevrolet' and anomod = '".$_POST['ano']."'
					group by modelo";
		}
		else if ($_POST['marca'] == "Fiat"){
			 $sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'Fiat' and anomod = '".$_POST['ano']."'
					group by modelo";
		}
		else if($_POST['marca'] == "Ford"){
			$sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'Ford' and anomod = '".$_POST['ano']."'
					group by modelo";
		}
		else if($_POST['marca'] == "Hyundai"){
			$sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'Hyundai' and anomod = '".$_POST['ano']."'
					group by modelo";
		}
	    else if( $_POST['marca'] == "Renault"){
			$sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'Renault' and anomod = '".$_POST['ano']."'
					group by modelo";
	    }
		else if($_POST['marca'] == "VW - VolksWagen"){
			$sql = "select id,modelo from veiculo_completo where veiculo_completo.marca = 'VW - VolksWagen' and anomod = '".$_POST['ano']."'
					group by modelo";
		}

		$query = mysqli_query($conn,$sql);
		$options = "<option value='' disabled selected>Modelo</option>";
		while($modelo = mysqli_fetch_array($query)){
			$options.= "<option value='".$modelo['id']."'>".$modelo['modelo']."</option>";
		}
		mysqli_close($conn);
		print $options;
	break;

	case "cotacao":

		//CRM RODRIGO

		// $resp['A'] = "A";
		print json_encode($_POST);

	break; 
}

function encontraCarroID($conn,$carros,$busca,$index = 0){ 
	$aux_busca = explode(' ',$busca);
	$matchs    = 0;
	$id 	   = "";
	$encontrados = array();
	
	foreach ($carros as $i => $carro) {
		if(isset($aux_busca[$index])){
			$carro[0] = deParaModelos($conn,$carro[0]);

			$carro[0]  = tirarAcentos($carro[0]);
			$aux_busca[$index] = tirarAcentos($aux_busca[$index]);
			if(strpos(mb_strtoupper($carro[0]),mb_strtoupper($aux_busca[$index])) !== false){
				$aux_matchs = 0;
				foreach ($aux_busca as $j => $aux) {
					if(strpos(str_replace('.','',mb_strtoupper($carro[0])),str_replace('.','',mb_strtoupper($aux))) !== false){
						$aux_matchs++;				
					}
				}
				if($aux_matchs > $matchs){
					$encontrados = array();
					array_push($encontrados,array($carro[0],$carro[1],$carro[2],$carro[3],$carro[4]));
					$matchs = $aux_matchs;
				}
				else if($aux_matchs == $matchs){
					array_push($encontrados,array($carro[0],$carro[1],$carro[2],$carro[3],$carro[4]));
				}
			}
		}
	}
	if(empty($encontrados) && $index < 2)
		return encontraCarroID($conn,$carros,$busca,++$index);
	else
		return $encontrados;
}

function encontraAnos($anos,$busca){
	$encontrados = array();
	foreach ($anos as $i => $ano){
		if (substr($ano->{'Value'},0,4) == $busca){
			array_push($encontrados,$ano->{'Value'});
		}
	}
	return $encontrados;
}	

function deParaMarcas($conn,$marca){

	$SQL   = "SELECT para from depara_marcas WHERE de = '$marca' ";
	$QRY   = mysqli_query($conn,$SQL);
	if(mysqli_num_rows($QRY) > 0){
		$marca = mysqli_fetch_array($QRY);
		return utf8_encode($marca['para']);
	}
	else
		return $marca;
}

function deParaModelos($conn,$modelo){

	$SQL   = "SELECT de,para from depara_modelos";
	$QRY   = mysqli_query($conn,$SQL);
	while($depara = mysqli_fetch_array($QRY)){
		$modelo = str_replace($depara["de"], $depara["para"], $modelo);
	}
	return $modelo;
}

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}
?>