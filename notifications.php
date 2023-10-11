<?php
# Sistemas de notificações PAGSEGURO
# Documentação: https://dev.pagbank.uol.com.br/v1.0/docs/api-notificacao-v1
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$localPath = $_SERVER['DOCUMENT_ROOT'];
	require_once($localPath.'/configurations/vars.php');

	// Verifica se os parâmetros "notificationCode" e "notificationType" foram recebidos
	if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
		// Obtém os valores dos parâmetros iniciais de notificações
		$notificationCode = $_POST['notificationCode'];
		$notificationType = $_POST['notificationType'];

		// Define a URL webhook que buscará as informações da transação via CURL
		$url = $ps_notificationsURL.$notificationCode."?email=".$ps_clientEmail."&token=".$ps_Token;

		// CURL de chamada webhook
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$transaction = curl_exec($curl);

		// Erro caso o token ou e-mail do PagSeguro definido nas variáveis esteja incorreto
		if($transaction == 'Unauthorized'){
			echo "Verificação de transação não autorizada. Reveja seus dados de e-mail e token cadastrados junto ao PagSeguro.";
		}

		curl_close($curl);

		// Resgata o retorno dos dados da transação e converte para um formato em que seja possível manipular os objetos
		$transaction = simplexml_load_string($transaction);

		if(!$transaction){
			// Transação com retorno de XML nula, infelizmente muito comum em ambiente sandbox
			echo "Transação sem retorno. Favor verificar transação manualmente no painel.";
			exit;
		} else {
			// Trate aqui todos os dados que vem da notificação, por exemplo, o status da notificação:
			// Exemplo: $transaction->status
			echo "Tranção retornada com sucesso!";
		}
	} else {
		// Erro de não recebimento de algum ou nenhum dos parâmetros obrigatórios para consulta
		echo "Parâmetros `notificationCode` e/ou `notificationType` não recebidos!";
	}

	// Certifique-se de que $transaction seja um objeto SimpleXMLElement
	if ($transaction instanceof SimpleXMLElement) {
	    // Nome do arquivo onde você deseja salvar o log
	    $filePath = $localPath."/logs/notifications.txt";

	    // Formate os dados XML como uma string
	    $dados = "\nLog de notificações - PAGSEGURO\n\n" . $transaction->asXML() . "\n\n\n\n\n\n";

	    // Gravação dos logs no arquivo
	    $arquivo = file_put_contents($filePath, $dados, FILE_APPEND);

	    // Verifique se o arquivo foi aberto com sucesso
	    if ($arquivo === false) {
	        die('Não foi possível gravar os logs de notificações!');
	    } else {
	        echo 'Log de notificações gravado com sucesso!';
	    }
	} else {
	    die('A variável `$transaction` não é um objeto SimpleXMLElement válido.');
	}
} else {
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	$userIP = $_SERVER['REMOTE_ADDR'];
	echo "Você não está autorizado a acessar este arquivo. Dados coletados<br>";
	echo "Navegador: " . $userAgent . "<br>";
	echo "Endereço IP: " . $userIP;
}
?>
