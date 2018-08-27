<?php

require_once "../assets/plugins/mpdf-v6.1.0/mpdf.php";
require_once('../mailer/class.phpmailer.php');
require_once('../mailer/PHPMailerAutoload.php');

class PDF_generator
{

	function imprimir_pdf($datos){
		$html = str_replace("@name", $datos["data"]["nombre"], $datos["data"]["data_html"]);
		$email= $datos["data"]["email"];
		$mpdf = new Mpdf();
		$mpdf->WriteHTML($html);
		$pdf= $mpdf->Output('', 'S');

		$mail = new PHPMailer;
    $mail->setFrom('info@cwc.com', 'MENARINI');
    $mail->addAddress($email, '');
    $mail->Subject = 'Certificado';
    $mail->CharSet = 'UTF-8';
    $mail->msgHTML('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Eventos MENARINI</title>
    </head>
    <body>
      <div style="font-size: 14px; color: black !important">
        <br>
        <p>Gracias por asistir al evento! en el presente se adjuntó su certificado de asistencia</p>
      </div>
    </body>
    </html>'
    );
    $mail->AltBody = 'Certificado de asistencia a eventos Menarini';
		$mail->AddStringAttachment($pdf, 'certificado.pdf', 'base64', 'application/pdf');
    $mail->send();

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
