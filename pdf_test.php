<?php

require_once "assets/plugins/mpdf-v6.1.0/mpdf.php";

$codigo = 150;

$mpdf = new Mpdf();
$mpdf->WriteHTML(
'<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HTML de mPDF</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div style="width: 100%">
		<div style="padding: 0px 15px;">
			<div style="margin: auto;">
				<h1 style="text-align: center;">
					Certificado de prueba
				</h1>
				<img src="assets/images/header_gracias.png" alt="" width="100%">
			</div>
		</div>
	</div>
</body>
</html>'
);

$mpdf->Output();

?>