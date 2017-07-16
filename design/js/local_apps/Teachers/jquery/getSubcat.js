//script para traer sub-categorias
 function GetSubCat(input){
 	$(input).change(function(){
	    $.ajax({
	      url:Hostname()+"/GuruSchool/maestros/GetSubCategorie/",
	      type: "POST",
	      data:"categoria="+$(input).val(),
	      success: function(info){
	        $('.sub_categoria').html(info);
	      }
	    })
	  });
 }