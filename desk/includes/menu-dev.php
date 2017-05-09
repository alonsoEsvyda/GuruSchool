<nav id="navegacion" class="navbar navbar-fixed-top  white" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" id="responsive" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img class="logo" src="../css/imagenes/logo.png">
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul id="UlBar" class="nav navbar-nav">
            <?php
                if (isset($_SESSION['Data']['Id_Usuario'])) {
                ?>
                    <li><a href="user" class="waves-effect waves-light"><strong>Inicio</strong></a></li>
                    <li><a href="../Cursos?accept=yes" class="waves-effect waves-light">Cursos</a></li>
                    <li><a href="../Certificados?accept=yes" class="waves-effect waves-light">Certificados</a></li>
                    <li><a href="../la-bolsa?accept=yes" class="waves-effect waves-light">La Bolsa</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mi Cuenta <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <a href="profile"><li class="active dropdown-item"><img style="width:16px; margin-top:5px; margin-right:5px; float:left;" src="../css/imagenes/favicon.ico"> Mi Perfil Gurú</li></a>
                            <a href="my-certificate"><li class="dropdown-item"><i class="blue-sun fa fa-certificate" aria-hidden="true"></i> Mis Certificados</li></a>
                            <a href="teach/teacher"><li class="dropdown-item"><i class="green-lanter fa fa-graduation-cap" aria-hidden="true"></i> Enseño</li></a>
                            <a href="learn"><li class="dropdown-item"><i class="red-black fa fa-book" aria-hidden="true"></i> Aprendo</li></a>
                            <a href="bag/list-my-job"><li class="dropdown-item"><i class="purple-black fa fa-suitcase" aria-hidden="true"></i> Empleos</li></a>
                            <a href="data_user"><li class="dropdown-item"><i class="blue-dark fa fa-database" aria-hidden="true"></i> Mis Datos</li></a>
                            <a href="security"><li class="dropdown-item"><i class="orange-sun fa fa-lock" aria-hidden="true"></i> Seguridad</li></a>
                            <a href="session/logout"><li class="dropdown-item"><i class="red-orange fa fa-times" aria-hidden="true"></i> Salir</li></a>
                        </ul>
                    </li>
                <?php    
                }else{
                    ?>
                        <li><a href="../index" class="waves-effect waves-light"><strong>Inicio</strong></a></li>
                        <li><a href="../Cursos?accept=yes" class="waves-effect waves-light">Cursos</a></li>
                        <li><a href="../Certificados?accept=yes" class="waves-effect waves-light">Certificados</a></li>
                        <li><a href="../la-bolsa?accept=yes" class="waves-effect waves-light">La Bolsa</a></li>
                        <li><a href="../iniciar-sesion" class="waves-effect waves-light">Iniciar Sesión</a></li>
                        <li><a style="background-color:#2BBBAD; color:white; border-radius:2px; padding:13px; margin-top:15px; font-size:15px;" href="../index" class="btn-register-menu waves-effect waves-light">REGISTRATE</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>