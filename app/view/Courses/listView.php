<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<!-- Content -->
<body ng-app="AppCourses">
<?= $menuFront; ?>
	<section class="with-content" ng-controller="ListCourses as list">
    	<div class="content-aside">
    	<!--ACORDEON-->
			<div class='panel-group' id='accordion'>
		  		<h2 class='margin-lestc-left'>CATÁLOGO</h2>
			    <?php $Categories = $helper->unique_multidim_array($Accordeon,1);  ?>
			    <?php foreach ($Categories as $categories) { ?>
			    	<div class='panel panel-default'>
				      	<div style='margin-top:5px;' class='panel-heading'>
					        <h4 class='h1-bold-four panel-title'>
					          <a data-toggle='collapse' href='.<?= $categories[1]; ?> '><?= $categories[1]; ?> <i class='fa fa-angle-down' aria-hidden='true'></i></a>
					        </h4>
				      	</div>
				      	<div class='panel-collapse collapse <?= $categories[1]; ?>'>
				      		<?php foreach ($Accordeon as $subcat) { ?>
					      		<?php if ($categories[1] == $subcat[1]) { ?>
							      	<ul class='list-group'>
							          <li class='list-group-item'><a style='cursor:pointer;' class='Encontrar' data-name='<?= $subcat[2]; ?>' ng-click="list.CoursesFilter($event)"><?= $subcat[2]; ?></a></li>
					        		</ul>
				        		<?php } ?>
			        		<?php } ?>
					  	</div>
			    	</div>
		    	<?php } ?>
		    </div>
		</div> 
    	<div class="content-with-inside">
    		<div class="page-content padding-none-bottom">
    			<div class="container-fluid padding-lesta">
    				<div class="row">
    					<div style="padding-left:0px;" class="col-xs-12">
    					<!--ACORDEON RESPONSIVE-->
	    						<div class="padding-lesta-top" style=" margin-left:10px;">
								    <div class='panel-group visible-xs' id='accordion-res'>
								  		<h2 class='margin-lestc-left'>CATÁLOGO</h2>
									    <?php foreach ($Categories as $categories) { ?>
									    	<div class='panel panel-default'>
										      	<div style='margin-top:5px;' class='panel-heading'>
											        <h4 class='h1-bold-four panel-title'>
											          <a data-toggle='collapse' href='.<?= $categories[1]; ?> '><?= $categories[1]; ?> <i class='fa fa-angle-down' aria-hidden='true'></i></a>
											        </h4>
										      	</div>
										      	<div class='panel-collapse collapse <?= $categories[1]; ?>'>
										      		<?php foreach ($Accordeon as $subcat) { ?>
											      		<?php if ($categories[1] == $subcat[1]) { ?>
													      	<ul class='list-group'>
													          <li class='list-group-item'><a style='cursor:pointer;' class='Encontrar' data-name='<?= $subcat[2]; ?>' ng-click="list.CoursesFilter($event)">><?= $subcat[2]; ?></a></li>
											        		</ul>
										        		<?php } ?>
									        		<?php } ?>
											  	</div>
									    	</div>
								    	<?php } ?>
								    </div>
								</div> 
				            </div>
			    			<div style="/*height:1000px;width:100%;overflow-y: scroll;*/" class="contenible-courses">
			    			<!--CURSOS EN LA PLATAFORMA-->
				    			<div class="intermediate text-left" id="tittle_panel_course">
				    				<h1 class="h1-bold-three">{{list.subcategorie}}</h1>
					                <hr>	
				    			</div>
				    			<div id="content-contenible-card" ng-repeat="courses in list.courses_get">
					    			<div class="contenible-card" >
						                <div  class="card hoverable" style="height: auto;" ng-hide="courses.bool == 'falso'">
						                    <div class="card-image hidden-xs">
						                        <div class="view overlay hm-white-slight z-depth-1">
						                            <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/{{courses.Imagen}}" class="img-responsive" alt="">
						                            <a href="<?= BASE_DIR; ?>/cursos/detalles/{{courses.IdPkCurso}}/&accept=yes">
						                                <div class="mask waves-effect"></div>
						                            </a>
						                        </div>
						                    </div>
						                    <div class="card-image-res visible-xs">
						                        <div class="view overlay hm-white-slight z-depth-1">
						                            <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/{{courses.Imagen}}" class="img-responsive" alt="">
						                            <a href="<?= BASE_DIR; ?>/cursos/detalles/{{courses.IdPkCurso}}/&accept=yes">
						                                <div class="mask waves-effect"></div>
						                            </a>
						                        </div>
						                    </div>
						                    <div class="card-content">
						                        <span class=" span-card black-gray">{{courses.StrNameCurso | limitTo: 70 }}{{courses.StrNameCurso.length > 70 ? '...' : '' }}..</span>
						                        <p>{{courses.NameUser}}</p>
						                    </div>
						                    <div style="overflow: hidden;" class="card-btn text-left">
						                    	<h2 style="float: left;" ng-if="courses.StrTipoCurso == 'Gratis'" class="h1-bold-second">Grátis</h2>
						                    	<h2 style="float: left;" ng-if="courses.StrTipoCurso == 'De Pago'" class="h1-bold-second">$ {{courses.Intprecio}} COP</h2>
						                		<label style="float: right;" class="opacity-gray margin-lestc-right"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; {{courses.StundentsIn}}</label>
						                   </div>
						                </div>
				    				</div>
				    				<div class='intermediate padding' ng-show="courses.bool == 'falso'">
				    					<center>
				    						<i style='font-weight:100; font-size:130px; color:#C9DAE1;' class='fa fa-frown-o' aria-hidden='true'></i>
				    						<br><br>
				    						<h2 class='h1-light black-gray'>!Lo Sentimos¡</h2><br><h4 class='semi-gray'>No hay Cursos en esta Sub-Categoría</h4><br>
				    					</center>
				    				</div>
				    			</div>
			    			</div>
    					</div>

    				</div>
    			</div>
    		</div>
    		<center>
    			<div class="pagination form-group">
    				<div class="col-md-12">
    					<input style="width:50%;" id="quantity" ng-model="list.quantity" placeholder="Ej:10" type="number">
    					<br>
    					<button id="GoPagination" class="btn btn-default" data-sub="'+ SubCategorie +'" ng-click="list.Pagination(0)">Ver +</button>
    					<button id="AddPagination" class="btn btn-default" ng-click="list.Pagination(1)">+</button>
    				</div>
    			</div>
    		</center>
    	</div>
    </section>
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<!--Encontrar Cursos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Courses/app.js"></script>	