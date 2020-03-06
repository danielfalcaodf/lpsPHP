<?php
class TonyLPClass
{
	public function convert($csv, $separator = ';')
	{
		$file = fopen($csv, "r");

		$i = 0;
		$ii = 0;
		$title = array();
		$row = array();

		while (($getData = fgetcsv($file, 0, $separator)) !== FALSE) {
			if ($i == 0) {
				foreach ($getData as $key => $value) {
					$title[$key] = $this->slug($value);
				}
			} else {
				foreach ($getData as $key => $value) {
					$title_row = $title[$key];
					$row[$ii][$title_row] = $value;
				}
				$ii++;
			}

			$i++;
		}

		fclose($file);
		return $row;
	}

	public function slug($str)
	{
		$yAccent = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', ' ', '-');

		$nAccent = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', '_', '');

		$str = str_replace($yAccent, $nAccent, $str);
		$str = strtolower($str);

		return $str;
	}

	public function buscarCarro($placa)
	{
		$carro = file_get_contents('https://0000.com/BNDV/Placa/' . $placa);

		$carro = json_decode($carro, true);

		return $carro;
	}

	public function removePontoCifrao($value)
	{
		$replace = str_replace('R$ ', '', $value);
		$replace = str_replace('.', '', $replace);
		$replace = str_replace(',', '.', $replace);
		return $replace;
	}
	public function getWAPP()
	{
		$nums = [
			'https://api.whatsapp.com/send?1=pt_BR&phone=',
			'https://api.whatsapp.com/send?1=pt_BR&phone=',
			'https://api.whatsapp.com/send?1=pt_BR&phone=',
			'https://api.whatsapp.com/send?1=pt_BR&phone=',
			'https://api.whatsapp.com/send?1=pt_BR&phone='
		];

		$i = array_rand($nums, 1);
		return $nums[$i];
	}
	public function ordemArray($array, $orderby)
	{
		$sortArray = array();

		foreach ($array as $carro) {
			foreach ($carro as $key => $value) {
				if (!isset($sortArray[$key])) {
					$sortArray[$key] = array();
				}

				$sortArray[$key][] = $value;
			}
		}
		 //change this to whatever key you want from the array
		// echo json_encode($carrosStatus);

		$soNum = $this->removePontoCifrao($sortArray[$orderby]);
		return $soNum;
	}
	public function verificarVendido($array)
	{
		$carrosStatus = array();
		$carrosVender = array();
		$carrosVendido = array();
		for ($i = 0; $i < count($array); $i++) {
			$carrosStatus[] = $this->buscarCarro($array[$i]['placa_']);
				if (!$carrosStatus[$i]['vendido']) {
					$carrosStatus[$i]['cor_'] = $array[$i]['cor_'];
					$carrosStatus[$i]['calcao_'] = $array[$i]['calcao_'];
					$carrosStatus[$i]['prazo_'] = $array[$i]['prazo_'];
					$carrosStatus[$i]['mensal_'] = $array[$i]['mensal_'];
					$carrosStatus[$i]['veiculo_'] = $array[$i]['veiculo_'];
					$carrosVender[] = $carrosStatus[$i];
				} else {
					$carrosVendido[] = $carrosStatus[$i];
				}
		 }
		 return $carrosVender;
	}
	
}
