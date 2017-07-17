//Script para subir los vídeos al Servidor
function subirArchivosPago() {//Script para subir archivos de Pago
	Name=$("#NameVideo").val(),
    $("#file").upload(Hostname()+'/GuruSchool/maestros/UpPayVideos/',
    {
        NameVideo: Name,
        IdC: $("#IdC").val(),
    },
    function(respuesta) {
        //Una vez se suba el archivo entonces nos retorna una respuesta
        $("#barra_de_progreso").val(0);
        if (respuesta == false) {
        	$('#Progress').css('display','none');
        	mostrarRespuesta("<h3><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>Error:</h3><br>-Revise que los Campos Esten Llenos<br><br>-Revise que sea un Vídeo Mp4<br><br>-No Exceda el Peso Limite del Archivo (30MB)",false);
        	HiddenInput(true);
        }else{
        	$('#Progress').css('display','none');
            mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Video ha sido subido correctamente.', true);
            HiddenInput(true);
            $("#NameVideo, #file").val('');
            $('#list-videos-pay').append('<li><td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>'+ Name +'<a data-id="'+respuesta[0]+'" data-case="pay" onclick="eliminar(this)"><i style="float:right;" class="fa fa-times" aria-hidden="true"></i></a><a data-idvideo="'+ respuesta[1] +'" data-case="pay" onclick="previewfree(this)"><i style="float:right;" class="fa fa-eye" aria-hidden="true"></i></a> </p></td></li>');
        }
    }, function(progreso, valor) {
        //Barra de progreso.
        $("#barra_de_progreso").val(valor);
    });
}

function subirArchivoFree(){//Script para subir archivos grátis
	id=$('#IdC').attr('data-id'),
	url=$('#UrlYoutube').val(),
	name=$('#NameVideo').val(),
   $.post(Hostname()+'/GuruSchool/maestros/UpFreeVideos/',{
    	IdC:id,
    	UrlYoutube:url,
    	NameVideo:name,
    },function(info){
    	if (info == false) {
    		mostrarRespuesta("<h3><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>Error:</h3><br>-Revise que los Campos Esten Llenos<br><br>-Revise que la Url del Vídeo sea Valida<br><br>-No Exceda el Limite de Caracteres",false)
    	}else{
    		mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Video ha sido subido correctamente.', true)
    		$('#UrlYoutube,#NameVideo').val('')
    		$('#list-videos-free').append('<li><td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>'+ name +'<a data-id="'+info+'" data-case="free"  onclick="eliminar(this)"><i style="float:right;" class="fa fa-times" aria-hidden="true"></i></a><a data-idvideo="'+ YouTubeGetID(url) +'" data-case="free" onclick="previewfree(this)"><i style="float:right;" class="fa fa-eye" aria-hidden="true"></i></a> </p></td></li>');
    	}
    });
}

function mostrarRespuesta(mensaje, ok){//Esta función añade la respuesta a un contenedor HTML
	$('#respuesta').css('display','block');
    $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
    if(ok){
        $("#respuesta").addClass('alert-success');
    }else{
        $("#respuesta").addClass('alert-danger');
    }
}

function HiddenInput(res){//esta función habilita y deshabilita el formulario
	if (res) {
		$("#file").removeAttr("disabled");
		$("#NameVideo").removeAttr("disabled");
		$('.send-pay').removeAttr("disabled");
	}else{
		$("#file").attr('disabled', 'disabled');
		$("#NameVideo").attr('disabled', 'disabled');
		$('.send-pay').attr('disabled', 'disabled');
	}
}

function YouTubeGetID(url){//Script para Obtener el Id de youtube
  var ID = '';
  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  if(url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_\-]/i);
    ID = ID[0];
  }
  else {
    ID = url;
  }
    return ID;
}

//enviamos el id para cambiar de estado
function send_review(button){
    if(button.value=="si"){
        $.post(Hostname()+'/GuruSchool/maestros/SendReviewVideos/',{
            IdC:$(button).attr('data-id'),
        },function(info){
            if (info == true) {
                window.location=Hostname()+"/GuruSchool/maestros/dashboard&requestok=Ok, ya falta poco para que tu Curso esté en Linea.";
            }else{
                window.location=Hostname()+"/GuruSchool/maestros/dashboard&request=Hubo un Error, Intente más Tarde";
            }
        });
    }
}

//script para elimiar vídeos
function eliminar(button){
    if ($(button).attr('data-case')=="free"){
        $.post(Hostname()+'/GuruSchool/maestros/DeleteVideoFree/',{
            Id:$(button).attr('data-id'),
        },function(info){
           if (info == true) {
            $(button).parent('p').remove();
            mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Vídeo se Ha Eliminado.',true);
           }else{
            mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El Vídeo no se Ha Borrado',false);
           }
        });
    }else if($(button).attr('data-case')=="pay"){
        $.post(Hostname()+'/GuruSchool/maestros/DeleteVideoPay/',{
            Id:$(button).attr('data-id'),
        },function(info){
           if (info == true) {
            $(button).parent('p').remove();
            mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Vídeo se Ha Eliminado.',true);
           }else{
            mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El Vídeo no se Ha Borrado',false);
           }
        });
    }
}

//scripta para visulizar video
function previewfree (button){
     if ($(button).attr('data-case')=="free") {
        $('#msgMdal').html('<div class="modal-dialog"><div class="modal-content"><div class="modal-body" ><iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/'+ $(button).attr('data-idvideo') +'?showinfo=0" frameborder="0"></iframe></div> </div></div>');
         $('#msgMdal').modal();
     }else if($(button).attr('data-case')=="pay"){

        $('#reproductor').html('<video id="video1" preload="auto" width="100%"  data-setup="{}"><source src="'+Hostname()+'/GuruSchool/design/videos/'+$(button).attr('data-idvideo')+'" type="video/mp4"><p class="vjsno-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/"</p></video>');
         $('#msgMdal').modal();
     }
}


$(document).ready(function() {//Empieza la función y llamamos los metodos creados
	//videos de pago
    $(".send-pay").on('click', function() {
    	if ($('#file').val()=="" || $('#NameVideo').val()=="") {
    		mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tienes que Insertar un Vídeo', false);
    	}else{
    		$('#Progress').css('display','block');
    		HiddenInput(false);
       		subirArchivosPago();
    	}
    });
    //videos grátis
    $('.send-free').on('click', function(e){
    	if ($('#UrlYoutube').val() == "" || $('#NameVideo').val()=="") {
    		mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tienes que Insertar un Vídeo', false);
    	}else{
    		e.preventDefault();
			subirArchivoFree();
    	}
	});
});