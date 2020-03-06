<?php
	$concrm = mysqli_connect("52.67.18.67","crmtony","tonysjc03082018","crmtonydb");
	date_default_timezone_set('America/Sao_Paulo');

	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  	exit();
	  }
?>