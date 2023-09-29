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
<body>
    <div class="container text-center mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Dados Pix</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <img src="" alt="QRCode" id="qrCodeImage" style="padding-top: 15px;width: 250px" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label>Código: Copia e Cola</label>
                <input type="text" id="pixText" class="form-control" style="margin-top: 5px;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label>Código para pagamento manual:</label>
                <input type="text" id="pixID" class="form-control" style="margin-top: 5px;">
            </div>
        </div>
    </div>
    <script>
        // Função para obter os parâmetros da query string
        function getQueryParams() {
            var params = {};
            var queryString = window.location.search.substring(1);
            var keyValuePairs = queryString.split('&');

            for (var i = 0; i < keyValuePairs.length; i++) {
                var keyValue = keyValuePairs[i].split('=');
                var key = decodeURIComponent(keyValue[0]);
                var value = decodeURIComponent(keyValue[1]);
                var id = decodeURIComponent(keyValue[2]);
                params[key] = value;
            }

            return params;
        }

        // Obter os dados da query string
        var queryParams = getQueryParams();
        var pix_QRCode = queryParams.pix_QRCode;
        var pix_textCopyPaste = queryParams.pix_textCopyPaste;
        var pix_ID = queryParams.pix_ID;

        // Definir a imagem e o input com os dados obtidos
        var qrCodeImage = document.getElementById('qrCodeImage');
        var pixText = document.getElementById('pixText');
        var pixID = document.getElementById('pixID');

        qrCodeImage.src = pix_QRCode;
        pixText.value = pix_textCopyPaste;
        pixID.value = pix_ID;
    </script>
</body>
</html>
