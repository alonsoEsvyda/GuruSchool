function SendData(button){
  var DataCourse=$(button).attr('data-course');
  $('#modal-message').find('.btn-primary').attr('data-course',DataCourse);
}
function SendCharge(button){
  var DataCourse=$(button).attr('data-course');
    $.post(hostname()+'/GuruSchool/maestros/paymentCharge/',{
      Data:DataCourse,
    },function(info){
      if (info==true) {
        window.location="payments?requestok=Le notificaremos el Pago por Email o Telefono, tan pronto esté listo.";
      }
    });
}