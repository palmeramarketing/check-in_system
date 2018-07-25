<?php

require_once "../assets/plugins/mpdf-v6.1.0/mpdf.php";

class PDF_generator
{

	function imprimir_pdf($datos){
		$html = str_replace("@name", $datos["data"]["nombre"], $datos["data"]["data_html"]);
		$mpdf = new Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

}
?>