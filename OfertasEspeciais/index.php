<!doctype html>
<html>
	<head>
		<title>Tony Veículos - Ofertas</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400i&display=swap" rel="stylesheet">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	</head>
	<body>
		<script>
			<?php 
				function getWAPP(){
					$nums = [
							'https://api.whatsapp.com/send?phone=',
							'https://api.whatsapp.com/send?phone=',
							'https://api.whatsapp.com/send?phone='

				
					];

					$i = array_rand($nums, 1);
					return $nums[$i];
				}
			?>		
		</script>
		<div class="mb-only">
			<a href="<?= getWAPP() ?>">
				<img src="mobile.png" class="img-fluid mb-only" alt="novaopção Tony Veiculos">
			</a>
		</div>
			<div class="dkt-only">
			<a href="<?= getWAPP() ?>">
				<img src="desktop.jpg" class="img-fluid dkt-only" alt="novaopção Tony Veiculos">
			</a>
		</div>
	
	</body>
	<style>
		body{
			text-align: center;
			margin: 0;
			background-color: #fff;
		}
		body img{
			height: auto;
			margin: 0 !important;
		}
		@media (max-width: 768px){
			body img{
				width: 100%;
				height: auto;
			}
			.dkt-only {
				display: none;
			}
			.mb-only {
				display: block;
			}
			div {
				height: auto;
				width: 100vw;
				background-color: #3e4345; 
				color: white;
			}
			p {
				margin: 0px !important;
				padding-top: 15px; 
				padding-bottom: 15px; 
			}
		}
		@media (min-width: 768px){
			body img{
				width: 100%;
				height: auto;
			}
			.mb-only {
				display: none;
			}
			.dkt-only {
				display: block;
			}
		}

	</style>
</html>