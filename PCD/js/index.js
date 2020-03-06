var maskBehavior = function (val) {
	return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {onKeyPress: function(val, e, field, options) {
		field.mask(maskBehavior.apply({}, arguments), options);
	}
};
$('#telefone').mask(maskBehavior, options);
$('#placa').mask("SSS-9999");
$('#km').mask("9999999999");
$('#ano').mask("9999");
$('.moneyk').mask("#.##0", {reverse: true});

window.btn_nPlaca = true;
function showmarca(obj){
	if(window.btn_nPlaca){
		window.btn_nPlaca = false;
		$(".fipe").slideDown('medium');
		$(".nfipe").slideUp('medium');
		$(obj).html('Sei minha placa');
	}
	else{
		window.btn_nPlaca = true;
		$(".fipe").slideUp('medium');
		$(".nfipe").slideDown('medium');
		$(obj).html('Não sei minha placa');
	}
	$("#placa").val('');
}

function check(){
	if($("#nseiplaca").prop( "checked"))
		$("#nseiplaca").prop( "checked", false);
	else
		$("#nseiplaca").prop( "checked", true);

	showmarca($("#nseiplaca").prop( "checked"));
}

function FIPE(){
	if(valida_campos()){
		$("#loading_area").removeClass("d-none");
		var dados = {
			processo: "FIPE",
			placa:    $("#placa").val(),
			marca:    $("#marca").val(),
			id:       $("#modelo").val(),
			ano:      $("#ano").val(),
		}
		// console.log(dados);
		$.ajax({
			type: "POST",
			url: "php/home.php",
			data: dados,
			dataType: "json",
			success: function(resp){
				$("#loading_area").addClass("d-none");
				if(resp.cod == 0)
					send_cot(resp.marca,resp.modelo,resp.ano,resp.valor,resp.combustivel);
				else if(resp.cod == 2){
					var html = "";
					for (var i = 0; i < resp.carros.length; i++) {
						html += `<div class="col-11 carros" style="cursor:pointer" onclick="send_cot('${resp.carro_marca}','${resp.carros[i][0]}','${resp.carro_ano}','${resp.carros[i][4]}','${resp.carros[i][2]}')">
									<div><b>Marca:</b> ${resp.carro_marca}</div>
									<div><b>Modelo:</b> ${resp.carros[i][0]}</div>
									<div><b>Ano:</b> ${resp.carro_ano}</div>
									<div><b>Combustível:</b> ${resp.carros[i][2]}</div>
								</div>`;
					}
					$("#select_cars").html(html);
					carros();
				}
				else
					alert(resp.msg);
			},
			error: function(a, b, c){
				// console.log(a,b,c);
			}
		});
	}
}

function send_cot(marca,modelo,ano,valor,combus){ //FUNÇÃO QUE ENVIA INFO RODRIGO
	$("#loading_area").removeClass("d-none");
	var dados = {
		processo: "cotacao",
		marca:    marca,
		modelo:   modelo,
		ano:      ano,
		valor:    valor,
		combus:   combus,
		km:       $("#km").val(),
		nome:     $("#nome").val(),
		email:    $("#email").val(),
		telefone: $("#telefone").val()
	}

	$.ajax({
		type: "POST",
		url: "php/enviar.php",
		data: dados,
		dataType: "html",
		success: function(resp){
			$('#carros').modal('hide');
			$("#loading_area").addClass("d-none");
			// console.log(resp);
			$(location).attr('href','obrigado.php');
		},
		error: function(a,b,c){
			console.log(a,b,c);
		}
	});
}

function carregaModelos(marca){

	if($("#ano").val().length == 2 || $("#ano").val().length == 4){
		if($("#ano").val().length == 2){
			if($("#ano").val() >= 0 && $("#ano").val() <= 49){
				var ano = '20'+$("#ano").val();
				$("#ano").val(ano);
			} else {
				var ano = '19'+$("#ano").val();
				$("#ano").val(ano);
			}
		} else {
			var ano = $("#ano").val();
		}
		$("#modelo").attr('disabled', true);
		$("#modelo").html('<option>Carregando modelos...</option>');

		var dados = {
			processo: "modelos",
			marca: marca,
			ano: ano
		}
		// console.log(dados);
		$.ajax({
			type: "POST",
			url: "php/home.php",
			data: dados,
			dataType: "html",
			success: function(resp){
				setTimeout(function() {
					$("#modelo").attr('disabled', false);
					$("#modelo").empty();
					$("#modelo").append(resp);
				}, 1000);
			},
			error: function(info, status, error){
				// console.log(error);
			}
		});
	}
}

var modal = document.getElementById('carros');
var span  = document.getElementsByClassName("close")[0];

span.onclick = function() {
	$('#carros').modal('hide');
}

function carros(){
	$('#carros').modal('show');
}

window.onclick = function(event) {
  	if (event.target == modal) {
		$('#carros').modal('hide');
  	}
}

function valida_campos(){
	if(window.btn_nPlaca){
		if($("#placa").val() == ""){
			alert("Preencha o campo Placa");
			$("#placa").focus();
			return false;
		}
	}
	else{
		if($("#marca").prop('selectedIndex') == 0){
			alert("Preencha o campo Marca");
			$("#marca").focus();
			return false;
		}
		if($("#modelo").prop('selectedIndex')  == 0){
			alert("Preencha o campo Modelo");
			$("#modelo").focus();
			return false;
		}
		if($("#ano").val() == ""){
			alert("Preencha o campo Ano");
			$("#ano").focus();
			return false;
		}
	}

	if($("#km").val() == ""){
		alert("Preencha o campo Quilometragem");
		$("#km").focus();
		return false;
	}
	if($("#nome").val() == ""){
		alert("Preencha o campo Nome");
		$("#nome").focus();
		return false;
	}
	if($("#email").val() == ""){
		alert("Preencha o campo E-mail");
		$("#email").focus();
		return false;
	}
	if($("#telefone").val() == ""){
		alert("Preencha o campo Telefone");
		$("#telefone").focus();
		return false;
	}

	return true;
}
var info = 'start';
$('.unidades').click(function(){
	if( $(this).hasClass('primary') ){
		$('.show-unidade').removeClass('secondary');
		$('.show-unidade').addClass('primary');
	} else {
		$('.show-unidade').removeClass('primary');
		$('.show-unidade').addClass('secondary');
	}
	$('.icon-show').html('<i class="fas fa-chevron-down"></i>');

  	$('.show-unidade .info').hide({ direction: "left" }, 1000);
  	$('.picture-unidades:not(".in")').collapse('hide');
  	if(info != $(this).attr('aria-controls')){
  		info = $(this).attr('aria-controls');
  		$('.show-unidade .cidade[data-info="'+info+'"]').show({ direction: "right" }, 1000);
		$(this).find('.icon-show').html('<i class="fas fa-chevron-up"></i>');
  	} else {
  		info = 'start';
  		$('.show-unidade .start').show({ direction: "right" }, 1000);
  	}
});