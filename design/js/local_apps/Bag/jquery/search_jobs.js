$(document).ready(function(){
	$(".search-job").click(function(e){
	  e.preventDefault();
	  if (!$('.Pais').val() || !$('.Categoria').val() || !$('.Tipo').val()) {
	    mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Llene Correctamente los Campos para hacer su busqueda');
	  }else{
	    $('#respuesta').css('display','none');
	    var Country=$('.Pais').val();
	    var City=$('.Ciudad').val();
	    var Categorie=$('.Categoria').val();
	    var Type=$('.Tipo').val();
	  	$.ajax({
		    url : Hostname()+'/GuruSchool/la_bolsa/ApiSearchJobs/',
		    data : {Country:Country,City:City,Categorie:Categorie,Type:Type},
		    type : 'POST',
		    dataType : 'json',
		    success : function(info) {
		        if (info[0].bool == "false") {
		  			$(".jobs").html("<div class='padding intermediate'><center><i style='font-weight:100; font-size:80px; color:#C9DAE1;' class='fa fa-frown-o' aria-hidden='true'></i><br><h3 style='font-size:38px;'>NO HAY VACANTES PUBLICADAS</h3></center></div>");
			  	}else{
			  		$(".jobs").html(" ");
			  		$.each(info, function(i){
			  			var description = info[i].Description;
			  			$(".jobs").append('<div class="container-job"><div class="company-job"><h4>'+info[i].NameCompany+'</h4><a href="desk/bag/job/'+info[i].IdVacancy+'/"><h2>'+info[i].NameVacancy+'</h2></a></div><div class="description-job"><hr style="margin:0;"><p style="margin:0;">'+description.substr(0,130)+'[...]</p></div><div class="add-job"><h4>'+info[i].Categorie+'-'+info[i].Country+'-'+info[i].City+'('+info[i].Date+')</h4></div></div>');
			  		});
			  	}
		    },
		    error : function(xhr, status) {
		        console.log('Disculpe, existió un problema');
		    },
		    complete : function(xhr, status) {
		        console.log('Petición realizada');
		    }
		});
	  }
	});
})
function mostrarRespuesta(mensaje){//Esta función añade la respuesta a un contenedor HTML
  $('#respuesta').css('display','block');
  $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
  $("#respuesta").addClass('alert-danger');
}