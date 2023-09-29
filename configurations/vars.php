<?php
$appName = "Checkout Transparente - PIX";

// Defina 1 para 'sandbox' e 2 para 'produção'
$pagSeguroMode = 1;

if($pagSeguroMode == 1){
	$ps_Token = "SEU_TOKEN";
	$ps_ordersURL = "https://sandbox.api.pagseguro.com/orders";
	$ps_clientEmail = "seu_email_pagseguro@mail.com";
	$ps_webhookPagSeguro = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/";
} else if($pagSeguroMode == 2){
	$ps_Token = "SEU_TOKEN";
	$ps_ordersURL = "https://api.pagseguro.com/orders";
	$ps_clientEmail = "seu_email_pagseguro@mail.com";
	$ps_webhookPagSeguro = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/";
}
?>