$(document).ready(function(){
	$('#payBTN').on('click', function(){
		console.log('Validando dados do formulário...');
		let userData = {
			// Dados do cliente
			input_customer_name : $("#input_customer_name").val(),
			input_customerID : $("#input_customerID").val(),
			input_customer_email : $("#input_customer_email").val(),
			input_customer_ddd : $("#input_customer_ddd").val(),
			input_customer_phone : $("#input_customer_phone").val().replace(/[-\s]/g, ''),
			input_customer_cpf : $("#input_customer_cpf").val().replace(/[.-]/g, ''),
			input_customer_address : $("#input_customer_address").val(),
			input_customer_address_number : $("#input_customer_address_number").val(),
			input_customer_complement : $("#input_customer_complement").val(),
			input_customer_district : $("#input_customer_district").val(),
			input_customer_city : $("#input_customer_city").val(),
			input_customer_cep : $("#input_customer_cep").val(),

			// ID do pedido
			input_orderID : $("#input_orderID").val(),
			input_orderValue : $("#input_orderValue").val().replace(/\./g, ''),
		}

		if(!userData.input_customer_name){
            alert("Nome do Titular em branco!");
		} else if(!userData.input_customerID){
            alert("ID de cliente em branco!");
		} else if(!userData.input_customer_email){
            alert("E-mail em branco!");
		} else if(!userData.input_customer_ddd){
            alert("DDD em branco!");
		} else if(!userData.input_customer_phone){
            alert("Telefone em branco!");
		} else if(!userData.input_customer_cpf){
			alert("CPF em branco!");
		} else if(!userData.input_customer_address){
			alert("Endereço em branco!");
		} else if(!userData.input_customer_address_number){
			alert("Nº da Residencia em branco!");
		} else if(!userData.input_customer_complement){
			alert("Complemento em branco!");
		} else if(!userData.input_customer_district){
			alert("Bairro em branco!");
		} else if(!userData.input_customer_city){
			alert("Cidade em branco!");
		} else if(!userData.input_customer_cep){
			alert("CEP em branco!");
		} else if(!userData.input_orderID){
			alert("ID de Pedido em branco!");
		} else if(!userData.input_orderValue){
			alert("Valor do pedido em branco!");
		} else {
            // Chamar função de encriptação de dados
            if (validaCPF($("#input_customer_cpf").val())) {
                console.log("Enviando dados para a finalização do pagamento...");
				$.ajax({
					url: "controllers/PayControllerPIX.php",
					type: "POST",
					data: {
						input_orderID:userData.input_orderID,
						input_customer_name:userData.input_customer_name,
						input_customer_cpf:userData.input_customer_cpf,
						input_customer_email:userData.input_customer_email,
						input_customerID:userData.input_customerID,
						input_customer_ddd:userData.input_customer_ddd,
						input_customer_phone:userData.input_customer_phone,
						input_orderValue:userData.input_orderValue,
						input_customer_address:userData.input_customer_address,
						input_customer_address_number:userData.input_customer_address_number,
						input_customer_complement:userData.input_customer_complement,
						input_customer_district:userData.input_customer_district,
						input_customer_city:userData.input_customer_city,
						input_customer_cep:userData.input_customer_cep
					}, 
					success: function(resultado){
						console.log('Pagamento retornou com sucesso!');
						jsonReturn = JSON.parse(JSON.stringify(resultado));
						var pix_status = jsonReturn.status;
						var pix_QRCode = jsonReturn.pix_QRcode;
						var pix_textCopyPaste = jsonReturn.pix_CopyPaste;
						var pix_ID = jsonReturn.pix_code;
						if(pix_status == 200){
							console.log("Realize o pagamento na página que se abriu!");
							var queryParams = `?pix_QRCode=${encodeURIComponent(pix_QRCode)}&pix_textCopyPaste=${encodeURIComponent(pix_textCopyPaste)}&pix_ID=${encodeURIComponent(pix_ID)}`;
        					window.open(`payPIX.php${queryParams}`, '_blank');
						} else {
							console.log('Pagamento retornou com erro!');
							console.log(resultado);
							alert("Pagamento retornou com erro!");
						}
					},
					error: function(e){
						console.log(e);
						alert("Não foi possível realizar o pagamento! Tente novamente em alguns instantes.");
					}
				});
            } else {
                alert("CPF inválido!");
            }
		}
	});
	
	// Validar CPF
	function validaCPF(cpf) {
		exp = /\.|-/g;
		cpf = cpf.toString().replace(exp, "");
		var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
		var soma1 = 0,
				soma2 = 0;
		var vlr = 11;
		for (i = 0; i < 9; i++) {
			soma1 += eval(cpf.charAt(i) * (vlr - 1));
			soma2 += eval(cpf.charAt(i) * vlr);
			vlr--;
		}
		soma1 = (((soma1 * 10) % 11) === 10 ? 0 : ((soma1 * 10) % 11));
		soma2 = (((soma2 + (2 * soma1)) * 10) % 11);
		if (cpf === "11111111111" || cpf === "22222222222" || cpf === "33333333333" || cpf === "44444444444" || cpf === "55555555555" || cpf === "66666666666" || cpf === "77777777777" || cpf === "88888888888" || cpf === "99999999999" || cpf === "00000000000") {
			var digitoGerado = null;
		} else {
			var digitoGerado = (soma1 * 10) + soma2;
		}
		if (digitoGerado !== digitoDigitado) {
			return false;
		}
		return true;
	}
});