<?php
class LogsController{
    private $response;
    
    function __construct($response){
        $this->response = $response;
    }

    function log_payload(){
        $localPath = $_SERVER['DOCUMENT_ROOT'];
		// Nome do arquivo onde você deseja salvar os dados
		$filePath =  $localPath.'/logs/payload_log.txt';

		// Formata os dados
		$dados = "\nLog de Payload por PIX - PAGSEGURO\n\n".$this->response."\n\n\n\n\n\n";

		// Abre o arquivo para escrita (modo 'a' para anexar)
		$arquivo = file_put_contents($filePath , $dados, FILE_APPEND);

		// Verifica se o arquivo foi aberto com sucesso
		if ($arquivo === false) {
			die('Não foi possível abrir o arquivo para escrita.');
		}
	}

    function log(){
        $localPath = $_SERVER['DOCUMENT_ROOT'];
		// Nome do arquivo onde você deseja salvar os dados
		$filePath =  $localPath.'/logs/log.txt';

		// Formata os dados
		$dados = "\nLog de Pagamento por PIX - PAGSEGURO\n\n".$this->response."\n\n\n\n\n\n";

		// Abre o arquivo para escrita (modo 'a' para anexar)
		$arquivo = file_put_contents($filePath , $dados, FILE_APPEND);

		// Verifica se o arquivo foi aberto com sucesso
		if ($arquivo === false) {
			die('Não foi possível abrir o arquivo para escrita.');
		}
	}

	function err_log(){
        $localPath = $_SERVER['DOCUMENT_ROOT'];
		// Nome do arquivo onde você deseja salvar os dados
		$filePath  = $localPath.'/logs/error_log.txt';

		// Formata os dados
		$dados = "\nLog de Erros de Pagamento por PIX - PAGSEGURO\n\n".$this->response."\n\n\n\n\n\n";

		// Abre o arquivo para escrita (modo 'a' para anexar)
		$arquivo = file_put_contents($filePath , $dados, FILE_APPEND);

		// Verifica se o arquivo foi aberto com sucesso
		if ($arquivo === false) {
			die('Não foi possível abrir o arquivo para escrita.');
		}
	}
}

?>