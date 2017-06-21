function Delete(button){
	var Data=$(button).attr('data-vacancy');
	$.post(Hostname()+'/GuruSchool/la_bolsa/ApiDeleteJob/',{
	  Data:Data,
	},function(info){
		if (info == true) {
		  $(button).parent('div').parent('div').remove();
		}
	});
}