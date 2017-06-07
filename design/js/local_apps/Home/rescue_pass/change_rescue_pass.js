function RescuePass(){
  var frm= $("#FrmPass").serialize();
  $.ajax({
      type: "POST",
      url: Hostname()+"/GuruSchool/session/change_rescue_pass/",
      data:frm
  }).done (function(info){
      if (info==true) {
          window.location=Hostname()+"/GuruSchool/home/iniciar_session/&requestok=Cambio de contraseña correcto, inicie sesión";
      }else if(info==false){
          $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Error, Escriba una Contraseña correcta, verifique que las contraseñas coincidan.</span>");
          $('.Btn-Rescue').removeAttr("disabled");
      }
  });
}
$(document).ready(function(){
  $('.Btn-Rescue').on('click', function(e){
    if ($('.new-pass').val()=="" || $('.repeat-pass').val()=="" || $('.key').val()=="") {
      $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Llene los Campos correspondientes.</span>");
      $('.new-pass').css("border-bottom","2px solid red");
      $('.repeat-pass').css("border-bottom","2px solid red");
    }else{
      e.preventDefault();
      $(".Btn-Rescue").attr('disabled', 'disabled');
      RescuePass();
    }
  });
});