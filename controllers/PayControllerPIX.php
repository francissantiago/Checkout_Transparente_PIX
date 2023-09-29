<?php
header("Content-Type: application/json; charset=UTF-8");
$localPath = $_SERVER['DOCUMENT_ROOT'];
require_once($localPath.'/configurations/vars.php');
require_once($localPath.'/controllers/LogsController.php');
$msg = array();
if(isset($_POST['input_orderID'])){
	// Dados do pedido
	$input_orderID = $_POST['input_orderID'];
	$input_orderValue = $_POST['input_orderValue'];

	// Dados do cliente
	$input_customerID = $_POST['input_customerID'];
	$input_customer_name = $_POST['input_customer_name'];
	$input_customer_cpf = strval($_POST['input_customer_cpf']);
	$input_customer_email = $_POST['input_customer_email'];
	$input_customer_ddd = $_POST['input_customer_ddd'];
	$input_customer_phone = $_POST['input_customer_phone'];

	$input_customer_address = $_POST['input_customer_address'];
	$input_customer_address_number = strval($_POST['input_customer_address_number']);
	$input_customer_complement = $_POST['input_customer_complement'];
	$input_customer_district = $_POST['input_customer_district'];
	$input_customer_city = $_POST['input_customer_city'];
	$input_customer_cep = strval($_POST['input_customer_cep']);

	// Obter a data e hora atuais no formato ISO 8601
	$currentDate = date('c');
	// Converter a data e hora para um objeto DateTime
	$dateTime = new DateTime($currentDate);
	// Adicionar 15 minutos
	// Este é o tempo que o cliente terá para pagar sua compra
	$dateTime->modify('+15 minutes');
	// Formatar a nova data e hora no formato desejado
	$futureDate = $dateTime->format('Y-m-d\TH:i:sP');

	$data["reference_id"] = $input_orderID;
	$data["customer"] = [
		"name"=> $input_customer_name,
		"email"=> $input_customer_email,
		"tax_id"=> $input_customer_cpf,
		"phones"=> [
			[
				"country"=> "55",
				"area"=> $input_customer_ddd,
				"number"=> $input_customer_phone,
				"type"=> "MOBILE"
			]
		]
	];
	$data["items"]=[
		[
			"reference_id"=> $input_orderID,
			"name"=> "Pedido #000".$input_orderID,
			"quantity"=> 1,
			"unit_amount"=> $input_orderValue
		]
	];
	$data["qr_codes"] = [
		[
			"amount"=> [
				"value"=> $input_orderValue
			],
			"expiration_date"=> $futureDate,
		]
	];
	$data["shipping"]= [
		"address"=> [
			"street"=> $input_customer_address,
			"number"=> $input_customer_address_number,
			"complement"=> $input_customer_complement,
			"locality"=> $input_customer_district,
			"city"=> $input_customer_city,
			"region_code"=> "MG",
			"country"=> "BRA",
			"postal_code"=> $input_customer_cep
		]
	];

	$curl = curl_init($ps_ordersURL);
	curl_setopt($curl, CURLOPT_HTTPHEADER, Array(
		'Content-Type: application/json; charset=UTF-8',
		'Authorization: '.$ps_Token
	));
	curl_setopt($curl ,CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

	$retorno = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$payloadLog = new LogsController(json_encode($data));
	$payloadLog->log_payload();

	if ($err){
		$msg = "Ocorreu um erro! Detalhes no log.";
		$err_log = new LogsController($err);
		$err_log->err_log();
	} else {
		$msg = 200;
		$log = new LogsController($retorno);
		$log->log();
		// Imagem e texto copia e cola para pagamentos PIX
		$qrcodeImage = json_decode($retorno)->qr_codes[0]->links[0]->href;
		$textCopyPaste = json_decode($retorno)->qr_codes[0]->text;
		$pixID = json_decode($retorno)->qr_codes[0]->id;
		$msg = [
			'status' => 200,
			'pix_QRcode' => $qrcodeImage,
			'pix_CopyPaste' => $textCopyPaste,
			'pix_code' => $pixID
		];
	}
} else {
	$msg = "ID de pedido não recebido!";
}

echo json_encode($msg);
?>