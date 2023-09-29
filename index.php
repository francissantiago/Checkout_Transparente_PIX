<?php
$localPath = $_SERVER['DOCUMENT_ROOT'];
require_once($localPath.'/configurations/vars.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $appName; ?></title>
    <!-- Jquery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body class="bg-secondary text-white">
    <div class="container">
        <form class="form-control fw-bold bg-dark text-warning mt-1 mb-1">
            <div class="row">
                <div class="col-md-12 mt-3 mb-2 text-center fw-bold text-uppercase">
                    <h2><?php echo $appName;?></h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4">
                    <label for="input_orderID">ID do pedido:</label>
                        <input type="number" class="form-control" id="input_orderID" name="input_orderID" required>
                </div>
                <div class="col-md-4">
                    <label for="input_orderValue">Valor do pedido(R$10,00 = 1000):</label>
                        <input type="number" class="form-control" id="input_orderValue" name="input_orderValue" required>
                </div>
                <div class="col-md-4">
                    <label for="input_customerID">ID do cliente:</label>
                        <input type="number" class="form-control" id="input_customerID" name="input_customerID" required>
                </div>
            </div>
            <!-- Dados do cliente-->
                <div class="row mb-2">
                    <div class="col-md-8">
                        <label for="input_customer_name">Nome do Titular:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_name" name="input_customer_name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="input_customer_cpf">CPF</label>
                        <input type="text" class="form-control mb-2" id="input_customer_cpf" name="input_customer_cpf" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="input_customer_email">E-mail:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_email" name="input_customer_email" required>
                    </div>
                    <div class="col-md-2">
                        <label for="input_customer_ddd">DDD:</label>
                        <input type="number" class="form-control mb-2" id="input_customer_ddd" name="input_customer_ddd" required>
                    </div>
                    <div class="col-md-4">
                        <label for="input_customer_phone">Telefone:</label>
                        <input type="number" class="form-control mb-2" id="input_customer_phone" name="input_customer_phone" required>
                    </div>
                </div>
            <!-- Dados de endereço do cliente-->
                <div class="row mb-2">
                    <div class="col-md-8">
                        <label for="input_customer_address">Endereço:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_address" name="input_customer_address" required>
                    </div>
                    <div class="col-md-2">
                        <label for="input_customer_address_number">Nº da Residência:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_address_number" name="input_customer_address_number" required>
                    </div>
                    <div class="col-md-2">
                        <label for="input_customer_complement">Complemento:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_complement" name="input_customer_complement" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="input_customer_district">Bairro:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_district" name="input_customer_district" required>
                    </div>
                    <div class="col-md-4">
                        <label for="input_customer_city">Cidade:</label>
                        <input type="text" class="form-control mb-2" id="input_customer_city" name="input_customer_city" required>
                    </div>
                    <div class="col-md-4">
                        <label for="input_customer_cep">CEP:</label>
                        <input type="number" class="form-control mb-2" id="input_customer_cep" name="input_customer_cep" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <a class="btn btn-success btn-lg btn-block form-control fw-bold h2" id="payBTN">FINALIZAR</a>    
                    </div>
                </div>
        </form>
    </div>
</body>
<!-- SDK Pagseguro -->
<script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.js"></script>
<!-- Informações gerais do pedido e do cliente -->
<script src="<?php $localPath;?>/assets/js/main.js"></script>
<!-- Encriptação de dados do cartão -->
<script src="<?php $localPath;?>/assets/js/encryptCard.js"></script>
<!-- Scripts JS para pagamento com cartão de crédito -->
<script src="<?php $localPath;?>/assets/js/payTransaction.js"></script>
</html>