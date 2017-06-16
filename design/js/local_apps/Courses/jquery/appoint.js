$(document).ready(function(){
    $('.Apuntar').click(function(){
        $('.Apuntar').css('display','none');
        $.post(Hostname()+'/GuruSchool/cursos/pointCourse/',{
            Id:$(this).attr('data-id'),
        },function(info){
            if (info==true) {
                window.location=Hostname()+"/GuruSchool/home/iniciar_session/&request=Debes Inciar Sesión";
            }else if(info==false){
                console.log("datos");
                // window.location=Hostname()+"/GuruSchool/data_user.php?request=Completar Datos Personales";
            }else if(info==1){
                window.location=Hostname()+"/GuruSchool/session/logout/";
            }else if(info==0){
                window.location=Hostname()+"/GuruSchool/home/";
            }else{
                $('.Apuntar').css('display','block');
                $('#ModalReq').html(info);
                $('#myModalmsg').modal();
            }
        });

    });
});