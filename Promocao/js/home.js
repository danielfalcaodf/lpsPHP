var maskBehavior = function (val) {
	return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {onKeyPress: function(val, e, field, options) {
		field.mask(maskBehavior.apply({}, arguments), options);
	}
};
var slide = '';
var list = ListCarros();
function show_cad(num, token, entrada, parcela, mensal,idVei){
	html = `<br><b>Para dar continuidade precisamos de algumas informações</b>
				<form class="crmtony">
					<input type="text" class="input-dados" placeholder="Nome" name="nome" id="nome" required>
					<input type="text" class="input-dados cel" placeholder="Celular"  name="telefone" id="celular" required>
					<input type="text" class="input-dados" placeholder="Email" name="email" id="email" required>
					<br>
	
					  <select style="color: #818181;" class="input-dados " name="horario" id="horario" required>
					 	<option selected disabled>Melhor Horário Contato</option>
						<option value="09">09 Horas</option>
						<option value="10">10 Horas</option>
						<option value="11">11 Horas</option>
						<option value="12">12 Horas</option>
						<option value="13">13 Horas</option>
						<option value="14">14 Horas</option>
						<option value="15">15 Horas</option>
						<option value="16">16 Horas</option>
						<option value="17">17 Horas</option>
	 				 </select>
					<input type="hidden" name="forma" value='1'>
					<input type="hidden" name="entrada" value=`+entrada+`>
					<input type="hidden" name="qtde_parcela" value=`+parcela+`>
					<input type="hidden" name="valor_parcela" value=`+mensal+`>
					<input type="hidden" name="iD_Veiculo" value=`+idVei+`>
					<input type="hidden" name="token" value=`+token+`>
					<button id=btn-cad`+num+` type="submit" class="btn btn-primary botao-padrao2">CONTINUAR</button>
				</form>`;
			
	$('[name="cad"]').slideUp("slow");	
	$('[name="cad"]').html('');

	$("#cad"+num).html(html);
	console.log(html);
	console.log("#cad"+num);
	console.log(slide);
	
	if(slide != num){
		$("#cad"+num).slideDown("slow");
		slide = num;
	} else {
		slide = '';
	}

	$('#cpf').mask('999.999.999-99');
	$('#date').mask('99/99/9999');
	$('.cel').mask(maskBehavior, options);

	$(document).ready(function() {
	    console.log('CRMTony Integration');
	});
	
	
	$(document).ready(function() {
		console.log('CRMTony Integration');
	});
	
	$('.crmtony').submit(function (event) {
		event.preventDefault();
		$('.crmtony [type="submit"]').attr('disabled', true);
		var buttonname = $('.crmtony [type="submit"]').html();
		$('.crmtony [type="submit"]').html('Enviando...');
	
		var data = $(this).serialize();
		$.ajax({
			url: 'https://zzz.com/integrationsV2.php',
			type: 'POST',
			data: data,
			dataType: 'json'
		}).done(function(dados){
			if(dados.error == 'false' || dados.url){
				$('.crmtony [type="submit"]').html('Enviado');
				location.href = dados.url;
			} else {
				console.log(dados);
				$('.crmtony [type="submit"]').attr('disabled', false);
				$('.crmtony [type="submit"]').html(buttonname);
			}
		});
	});
}

function changeNegativado(obj){
	var val = $(obj).val();
	if(val == '1'){
		$(obj).val('');
		swalNotify('warning', 'Infelizmente as opções de venda dos carros desta página não se aplicam a essa condição, mas não se preocupe, nós temos outras ofertas exclusivas para negativado.', 'http://tonyveiculos.com.br/Negativado/');
	}
}

function swalNotify(type, text, url = ''){  
    swal({ 
        title: 'Ops!',
        html: text,
        confirmButtonText: 'Clique aqui e veja novas ofertas',
        cancelButtonText: 'Cancelar',
        showConfirmButton: true,
        showCancelButton: true,
    }).then((result) => {
	  	if (result.value) {
	  		if(url){
	  		 	location.href = url;
	  		}
	  	}
    }); 
}

function ListCarros()
 {
	$('#list-carro').html('<div class="spinner-border p-5  spinnermb" role="status"><span class="sr-only">Loading...</span></div>');
	$.ajax({
		url: './listCarro.php',
		data: '',
		dataType: 'html'
	}).done(function(dados){
		$('#list-carro').html(dados);
	});
}

function linkapp(wpp) {
	location.href = wpp;
}