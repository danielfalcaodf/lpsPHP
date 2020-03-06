<?php 
	include_once 'dbcrm.php';

	if(@$_POST){
		$carro_marca = $_POST['marca'];
		$carro_modelo = $_POST['modelo'];
		$carro_comb = $_POST['combus'];
		$carro_ano = $_POST['ano'];
		$carro_km = $_POST['km'];
		$carro_valor = str_replace('R$ ', '', $_POST['valor']);

		$cli_nome = $_POST['nome'];
		$cli_email = $_POST['email'];
		$cli_telefone = $_POST['telefone'];

		$check = checkMarcaModelo($carro_marca, $carro_modelo);
		if(@$check['marca'] AND @$check['modelo']){
			$log['user'] = true;
			$origem = 'LP Tony - Paga Tabela (Se enquadra)';
		} else {
			$log['user'] = false;
			$origem = 'LP Tony - Paga Tabela (Não se enquadra)';
		}
		$url_origem = 'http://tonyveiculos.com.br/LP/2019/05/21/PagaTabela/';
		// echo json_encode($log);
		date_default_timezone_set('America/Sao_Paulo');

		$hora_cadastro = date('Y-m-d H:i:s');
		$hora_contato = date('Y-m-d H:i:s');
		$horario_contato = date('H').' Horas';

		mysqli_query($concrm, "INSERT INTO clientes (online, usuario, formapagamento, nome, negativado, tipo, email, celular, whatsapp, troca_tipo, troca_marca, troca_modelo, troca_ano, troca_km, troca_valor, horario_contato, origem, url_origem, hora_contato, pendente, status, hora) VALUES (1, 127, 1, '$cli_nome', 0, 2, '$cli_email', '$cli_telefone', '$cli_telefone', 1, '$carro_marca', '$carro_modelo', '$carro_ano', '$carro_km', '$carro_valor', '$horario_contato', '$origem', '$url_origem', '$hora_contato', 0, 1, '$hora_cadastro')") or die (mysqli_error($concrm));
		mysqli_close($concrm);
	}
	function checkMarcaModelo($marca = null, $modelo = null){
		$marcas = [
			'Renault',
			'Volkswagen',
			'VW - VolksWagen',
			'Hyundai',
			'Ford',
			'Fiat',
			'Chevrolet'
		];
		$modelos = [
			'Clio',
			'Logan',
			'Sandero',
			'Fox',
			'Gol',
			'Voyage',
			'HB20',
			'HB20S',
			'Fiesta',
			'Ka',
			'Palio',
			'Siena',
			'Uno',
			'Agile',
			'Classic',
			'Cobalt',
			'Prisma',
			'Onix'
		];

		if(checkString($marcas, $marca)){
			$ret['marca'] = true; 
			if(checkString($modelos, $modelo)){
				$ret['modelo'] = true; 
			} else {
				$ret['modelo'] = false; 
			}
		} else {
			$ret['marca'] = false; 
			$ret['modelo'] = false; 
		}
		return $ret;
	}
	function checkString($array, $string){
		$string = explode(' ', $string);
		foreach ($string as $value) {
			foreach ($array as $key) {
				$value = preg_replace("/[^a-zA-Z]+/", " ", $value);
				// echo $value;
			    if ( preg_match("/$value/", $key) ) {
			        return true;
			    }
			}
		}

		return false;
	}
?>