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

	function imprimir_gafete($email){
		$gafete = file_get_contents('../gafetes/html_gafete.html');
		$html = str_replace("@name", $email, $gafete);
		$mpdf = new Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->SetJS('this.print();');
		$mpdf->Output();
	}

}
?>
