//Script para habilitar  y des-habilitar campo precio
$(document).ready(function(){
	// deshabilitamos campo precio al cargar
	$(".precio").attr('disabled', 'disabled');
	$(".precio").css('display','none');
});
function habilitar(value)
{
	if(value=="1")
	{
		// deshabilitamos campo precio
		$(".precio").attr('disabled', 'disabled');
		$(".precio").css('display','none');
	}else if(value=="0"){
		// habilitamos campo precio
		$(".precio").removeAttr("disabled");
		$(".precio").css('display','block');
	}
}