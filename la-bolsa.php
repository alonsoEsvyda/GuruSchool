<?php
  include('desk/session/session_parameters.php');
  include ("desk/class/functions.php");
  include ("desk/class/function_data.php");
  //llamamos la clase SQLGetSelInt
  $SQLGetSelInt= new SQLGetSelInt();
  //llamamos a la clase ModelHTMLTeach
  $ModelHTMLTeach=new ModelHTMLTeach();
  //llamamos a la clase TheBag
  $TheBag=new TheBag();
  //traemos el metodo que nos retorna una vista de todas las vacantes
  $GetViewAllVacancy=$TheBag->GetViewAllVacancy("Public");
  //llamamos la clase para traer  los paises
  $GetCountry=$SQLGetSelInt->SQLGetDataCountry(); 
  //Traemos el meotod que nos retona la categorías
  $ArrCategorias=$ModelHTMLTeach->GetCategoriesHtml();
?>
<!DOCTYPE html>
<html>
<head>
  <title>LA BOLSA | Gurú School</title>
  <meta name=" title" content="LA BOLSA | Gurú School">
  <?php include ("includes-front/head.php"); ?>
</head>
<body>
  <!--Navigation-->
    <?php 
      include("includes-front/menu.php"); 
      include("includes-front/pop_up.php");
    ?>   
   <!--Front-->
    <section style="background-image: url('css/imagenes/fondo-la-bolsa.png'); background-size: 100% 100%; no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;" id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                    <center>
                      <h1><i class="fa fa-suitcase" aria-hidden="true"></i> LA BOLSA</h1><br>
                      <p>Encuentra Vacantes, ofrece Empleo, crea un mundo de oportunidades.</p>
                      <a href="desk/bag/vacancy-published"><button type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Ofrecer Vacante</button></a>
                    </center>
                </div>
          </div>            
        </div>
      </div>
    </section>
    <section class="intermediate bk-gray-color ">
      <div class="container">
        <div class="row">
        <!--panel search-->
          <div class="col-xs-12 panel-job padding-lest-bottom">
            <h1 style="margin-left:12px;" class="margin-lestb-top black-gray">Encuentra Empleo</h1>
            <hr>
            <div style="display:none;" id="respuesta" class="alert"></div>
            <form>
              <div class="form-group">
                  <div class="col-md-3">
                    <select class="Pais"  name="Pais" required/>
                      <option value="" disabled selected>* Seleccione el País</option>
                      <?php 
                        sort($GetCountry);
                        foreach ($GetCountry as $DataCountry) {
                          ?>
                          <option value="<?php echo $DataCountry[0]; ?>"><?php echo $DataCountry[0]; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                      <input type="text" class="Ciudad" name="Ciudad" placeholder="Escribe la Ciudad" required/>
                  </div>
                  <div class="col-md-3">
                    <select class="Categoria" name="categoria" required/>
                      <option value="" disabled selected>* Seleccione Categoría</option>
                      <?php
                        sort($ArrCategorias);
                        foreach ($ArrCategorias as $DataCat) {
                          ?>
                            <option value="<?php echo $DataCat[0]; ?>"><?php echo $DataCat[0]; ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                      <select class="Tipo" name="Tipo" required/>
                        <option value="" disabled selected>* Seleccione Tipo</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Freelance">Freelance</option>
                      </select>
                  </div>
                  <div class="col-md-2 margin-lestc-top">
                    <button style="width:100%;" class="search-job btn btn-info"><i style="font-size:16px;" class="fa fa-search" aria-hidden="true"></i> | Buscar</button>
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <section class="intermediate">
      <div class="container">
        <div class="row">
          <!--lista de trabajo-->
          <div class="col-xs-12 padding-lest-bottom">
            <hr>
            <div class="jobs">
              <?php
                if ($GetViewAllVacancy==false) {
                  echo "<div class='padding intermediate'>
                      <center><h3>NO HAY VACANTES PUBLICADAS</h3></center>
                    </div>";
                }else{
                  foreach ($GetViewAllVacancy as $vacancy) {
                    ?>
                      <!--vacantes-->
                      <div class="container-job">
                        <div class="company-job">
                          <h4><?php echo $vacancy[1]; ?></h4>
                          <a href="desk/bag/job/<?php echo $vacancy[0]; ?>/"><h2><?php echo $vacancy[2]; ?></h2></a>
                        </div>
                        <div class="description-job">
                          <hr style="margin:0;">
                          <p class="darkgray" style="margin:0;"><?php echo strip_tags(substr($vacancy[3],0,150))."[...]"; ?></p>
                        </div>
                        <div class="add-job">
                          <h4><?php echo $vacancy[4]."-".$vacancy[5]."/".$vacancy[6]." (".$vacancy[7].")"; ?></h4>
                        </div>
                      </div>
                    <?php
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Footer-->
    <?php include ("includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes-front/scripts.html"); ?>
    <script type="text/javascript">
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
            $.post('desk/bag/controll/search_jobs.php',{
                Country:Country,
                City:City,
                Categorie:Categorie,
                Type:Type,
              },function(info){
                $(".jobs").html(info);
              });
          }
        });
      })
      function mostrarRespuesta(mensaje){//Esta función añade la respuesta a un contenedor HTML
        $('#respuesta').css('display','block');
          $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
          $("#respuesta").addClass('alert-danger');
      }
    </script>
</body>
</html>