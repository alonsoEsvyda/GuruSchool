function RescuePass(){
  Email=$('.Email-Rescue').val();
  $.post(Hostname()+"/GuruSchool/session/rescue_pass/",{
    Email:Email,
  },function(info){
    if (info==true) {
      $('.request').html("<span style='color:rgba(46, 204, 113,1.0);'>Se Envío Correctamente. Revise su bandeja de entrada o el Correo no deseado</span>");
      $('.Btn-Rescue').removeAttr("disabled");
    }else if(info==false){
      $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Hubo un error al enviar, revise que el correo sea valido o llene el campo correspondiente.</span>");
      $('.Btn-Rescue').removeAttr("disabled");
    }
  });
}
$(document).ready(function(){
  $('.Btn-Rescue').on('click', function(e){
    e.preventDefault();
    if ($('.Email-Rescue').val()=="") {
      $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Llene este Campo Primero.</span>");
    }else{
      $(".Btn-Rescue").attr('disabled', 'disabled');
      $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Espere un momento mientras enviamos el mensaje.</span>");
      RescuePass();
    }
  });
});