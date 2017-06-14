// Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.9&appId=924596374312312";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      FB.api('/me?fields=id,name,email,permissions', function(response) {
        var data= {"email":response.email,"token_id":response.id};
        $.ajax({
            type: "POST",
            url: Hostname()+"/GuruSchool/session/validate_session_facebook",
            data:data
        }).done(function(info){
            if (info == true) {
              //por modificarse
              window.location = Hostname()+"/GuruSchool/home/iniciar_session/";
            }else if(info == false){
              window.location = Hostname()+"/GuruSchool/home/iniciar_session&request=Hubo un error, vuelva a internarlo";
            }else if (info == "HavePass"){
              window.location = Hostname()+"/GuruSchool/home/iniciar_session&request=Inicie con su password";
            }else if (info == "NoInsert"){
              window.location = Hostname()+"/GuruSchool/home/index&request=Error al registrar, intente de nuevo";
            }else{
              console.log("OLA MUNDO")
            }
        });
      });
    } else {
      
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '981554355256359',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });


    // FB.getLoginStatus(function(response) {
    //   statusChangeCallback(response);
    // });
  };
