<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body ng-app="AppTeachers">
  <!--Navigation-->
  <?= $menuFront; ?>
  <!--Front-->
  <div ng-controller="DataTeacherController as teacher">
    <!--Titulo de la sección-->
    <section id="sec-front" class="padding margin-top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="text-front text-front-down">
                  <center>
                    <h2>Plataforma del Maestro</h2>
                    <p>En esta Sección puedes Enseñar, Cobrar y Editar tus Cursos</p>
                    <a href="up_course"><button type="button" data-step="1" data-intro="Si tienes un talento que mostrár, enseñalo aquí en un Video-Curso" class="waves-effect waves-light wow pulse animated btn btn-default">Enseña Un Curso</button></a>
                  </center>
              </div>
            </div>            
          </div>
        </div>
    </section>
     <!--Navegación-->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="container-nav-teacher margin-lestc-top">
            <ul id="nav">
                <li data-toggle="tooltip" 
                    data-placement="top" title="Aquí verás los cursos que enseñas y el estado de cada uno." >
                    <a data-step="2" 
                       data-intro="Encuentra la lista de todos los cursos que enseñas, el estado y la cantidad de alumnos inscritos"
                       ng-click="teacher.selectTab(1)">
                       Enseño
                    </a>
                </li>
                <li data-toggle="tooltip" 
                    data-placement="top" title="En esta sección puedes cobrar tus cursos, despues de tener minimo, $ 400.000 COP" >
                    <a data-step="3" 
                       data-intro="Cobra tus cursos desde $ 400.000 COP en adelante."
                       ng-click="teacher.selectTab(2)">
                       Cobrar
                    </a>
                </li>
                <li data-toggle="tooltip" 
                    data-placement="top" title="En esta sección tienes un resumen completo de tus cobros..">
                    <a data-step="4" 
                       data-intro="Encuentra la lista de tus cobros, Pagos, etc.."
                       ng-click="teacher.selectTab(3)">
                       Reporde de Cobros
                    </a>
                </li>
                <li><a href="javascript:void(0);" onclick="javascript:introJs().setOption('showProgress', true).start();" ><i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!--Courses-->
    <section ng-show="teacher.isSelect(1)" class="courses-grid">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!--Cursos-->
            <?php
            if ($MyCourses==false) {
              echo '<center>
                      <div class="intermediate margin-bottom padding">
                        <br><br><br>
                          <h2><i class="fa fa-smile-o" aria-hidden="true"></i> Usted no ha Creado Ningún Curso. <a href="up_course">Empieza Aquí</a></h2>
                      </div>
                    </center>' ;
            }else{
              foreach ($MyCourses as $Courses) {
                ?>
                  <div class="contenible-card ">
                    <div class="card hoverable">
                        <div class="card-image hidden-xs">
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Courses[2]; ?>" class="img-responsive" alt="">
                                <?php
                                  switch ($Courses[3]) {
                                    case 'Publicado':
                                      ?>
                                        <a href="<?= BASE_DIR; ?>/cursos/detalles/<?= $Courses[0]; ?>/<?= str_replace(" ","-",$Courses[1]); ?>/">
                                          <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;
                                    
                                    case 'Rechazado':
                                      ?>
                                        <a href="update_course/<?= $Courses[0]; ?>">
                                            <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;

                                    case 'Aprobado':
                                      ?>
                                        <a href="up_video_course/<?= $Courses[0]; ?>">
                                            <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;

                                    case 'En Revision':
                                      ?>
                                        <div class="mask waves-effect"></div>
                                      <?php
                                      break;
                                      
                                    case 'En Revision Video':
                                      ?>
                                        <div class="mask waves-effect"></div>
                                      <?php
                                      break;
                                  }
                                ?>
                            </div>
                        </div>
                        <div class="card-image-res visible-xs">
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Courses[2]; ?>" class="img-responsive" alt="">
                                <?php
                                  switch ($Courses[3]) {
                                    case 'Publicado':
                                      ?>
                                        <a href="<?= BASE_DIR; ?>/cursos/detalles/<?= $Courses[0]; ?>/<?= str_replace(" ","-",$Courses[1]); ?>/">
                                          <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;
                                    
                                    case 'Rechazado':
                                      ?>
                                        <a href="update_course/<?= $Courses[0]; ?>">
                                            <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;

                                    case 'Aprobado':
                                      ?>
                                        <a href="up_video_course/<?= $Courses[0]; ?>">
                                            <div class="mask waves-effect"></div>
                                        </a>
                                      <?php
                                      break;

                                    case 'En Revision':
                                      ?>
                                        <div class="mask waves-effect"></div>
                                      <?php
                                      break;

                                    case 'En Revision Video':
                                      ?>
                                        <div class="mask waves-effect"></div>
                                      <?php
                                      break;

                                  }
                                ?>
                            </div>
                        </div>
                        <div class="card-content">
                            <h5><?= $Courses[1]; ?></h5>
                        </div>
                        <div class="card-btn text-left">
                        <?php
                          switch ($Courses[3]) {
                            case 'Publicado':
                              ?>
                                <span class="label label-success">Publicado&nbsp; • &nbsp;
                                <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <?= $Courses[6]; ?></span>
                              <?php
                              break;
                            
                            case 'Rechazado':
                              ?>
                                <span class="label label-danger">Rechazado</span>
                              <?php
                              break;

                            case 'Aprobado':
                              ?>
                                <span class="label label-info">Aprobado</span>
                              <?php
                              break;

                            case 'En Revision':
                              ?>
                                <span class="label label-warning">En Revisión</span>
                              <?php
                              break;

                            case 'En Revision Video':
                              ?>
                                <span class="label label-warning">En Revisión Video</span>
                              <?php
                              break;
                          }
                        ?>
                        </div>
                    </div>
                </div>
                <?php
              }
            }
            ?>
          </div>
        </div>
      </div>
    </section>

    <!--Charge-->
    <section ng-show="teacher.isSelect(2)" class="courses-grid">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!--Cursos-->
            <?php
              if ($ChargeCourse==false) {
                echo '<center>
                      <div class="intermediate margin-bottom padding">
                        <br><br><br>
                          <h2><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Usted no tiene cobros.</h2>
                      </div>
                    </center>' ;
              }else{
                foreach ($ChargeCourse as $Charge) {
                  ?>
                    <div class="contenible-card">
                        <div style="height:auto;" class="card hoverable margin-lestb-top">
                            <div class="card-image hidden-xs">
                                <div class="view overlay hm-white-slight z-depth-1">
                                    <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $Charge[4]; ?>" class="img-responsive" alt="">
                                      <div class="mask waves-effect"></div>
                                </div>
                            </div>
                            <div class="card-image-res visible-xs">
                                <div class="view overlay hm-white-slight z-depth-1">
                                    <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $Charge[4]; ?>" class="img-responsive" alt="">
                                      <div class="mask waves-effect"></div>
                                </div>
                            </div>
                            <div class="card-content">
                                <h5><?php echo $Charge[3]; ?></h5>
                                <?php
                                  if ($Charge[1]>=400000) {
                                    ?>
                                      <p>Total:$ <?php echo number_format($Charge[1]); ?> COP | <a data-course="<?php echo $helper->StringEncode($Charge[0]); ?>" data-toggle="modal" data-target="#myModal" onclick="SendData(this)"><span class="label label-success"><i class="fa fa-unlock-alt" aria-hidden="true"></i> COBRAR</span></a></p>
                                    <?php
                                  }else{
                                    ?>
                                      <p>Total:$ <?php echo number_format($Charge[1]); ?> COP | <span class="label label-danger"><i class="fa fa-lock" aria-hidden="true"></i> NO CREDIT</span></p>
                                    <?php
                                  }
                                ?>
                            </div>
                        </div>
                    </div>
                  <?php
                }
            ?>
            <?php
              }
            ?>
          </div>
          <!--modal-->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header intermediate">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          <center>
                            <h3 class="modal-title" id="myModalLabel">¿Desea confirmar el Cobro?</h3>
                          <label>Una vez se notifique el cobro no hay marcha atras, de click si está seguro.</label>
                          </center>
                      </div>
                      <div class="modal-footer" id="modal-message">
                        <center>
                            <button type="button" class="btn btn-primary" value="si" onclick="SendCharge(this)">yes</button>
                            <button type="button" class="btn btn-secondary" value="no" data-dismiss="modal">no</button>
                        </center>
                      </div>
                 </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--Payments-->
    <section ng-show="teacher.isSelect(3)" class="courses-grid">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <!--Cursos-->
            <div style="margin-left:11px;" class="list-global content-description intermediate margin-lestc-top table-responsive">
              <table class="table table-hover">
                <thead>
                    <tr>
                      <th><h1><i class="fa fa-usd" aria-hidden="true"></i> Cobros Efectuados y Pendientes.</h1></th>
                    </tr>
                </thead>
                  <tbody>
                    <tr>
                      <td><h3>Curso Cobrado</h3></td>
                      <td><h3>Monto</h3></td>
                      <td><h3>Estado del Cobro</h3></td>
                      <td><h3>Fecha</h3></td>
                      <td><h3># Pago</h3></td>
                    </tr>
                    <?php
                      if ($PaymentsCourse==false) {
                        ?>
                          <tr>
                            <td><h4>No tienes Cobros</h4></td>
                            <td>$ 0 COP</td>
                            <td><span class="label label-success">Efectuado</span></td>
                            <td>0</td>
                          </tr>
                        <?php
                      }else{
                        foreach ($PaymentsCourse as $Payment) {
                          ?>
                            <tr>
                              <td><h4><?php echo $Payment[3]; ?></h4></td>
                              <td>$ <?php echo number_format($Payment[0]); ?> COP</td>
                              <td>
                                <?php
                                  if ($Payment[1]=="Pending") {
                                    ?>
                                      <span class="label label-warning"><?php echo $Payment[1]; ?></span>
                                    <?php
                                  }else if($Payment[1]=="Execute"){
                                    ?>
                                      <span class="label label-success"><?php echo $Payment[1]; ?></span>
                                    <?php
                                  }else if($Payment[1]=="Resting"){
                                    ?>
                                      <span class="label label-info"><?php echo $Payment[1]; ?></span>
                                    <?php
                                  }
                                ?>
                              </td>
                              <td><?php echo $Payment[2]; ?></td>
                              <td><?php echo $Payment[4]; ?></td>
                            </tr>
                          <?php
                        }
                      }
                    ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/app.js"></script>
<!--subir vídeos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/ajax/upload.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_tooltip.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_notify.js"></script>
<script type="text/javascript">
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
</script>