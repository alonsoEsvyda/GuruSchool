function Change(button){
  $(".cuenta").val('');
  if (button=="Efecty") {
    mostrarRespuesta("Escribe tu cédula, donde llegarán tus giros.",false)
  }else if(button=="Bancolombia"){
    mostrarRespuesta(button+": Esta cuenta consta de 11 Dígitos",false)
  }else if(button=="Banco Agrario"){
    mostrarRespuesta(button+": Esta cuenta consta de 12 Dígitos",false)
  }else if(button=="Banco Caja Social"){
    mostrarRespuesta(button+": Esta cuenta consta de 11 Dígitos",false)
  }else if(button=="Davivienda"){
    mostrarRespuesta(button+": Esta cuenta consta de 12 Dígitos",false)
  }
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