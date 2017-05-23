function RescuePass(){
  Email=$('.Email-Rescue').val();
  $.post('desk/case_user/rescue_pass.php',{
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
    if ($('.Email-Rescue').val()=="") {
      $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Llene este Campo Primero.</span>");
    }else{
      e.preventDefault();
      $(".Btn-Rescue").attr('disabled', 'disabled');
      RescuePass();
    }
  });
});