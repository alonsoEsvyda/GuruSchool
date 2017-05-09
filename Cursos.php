<?php
	include('desk/session/session_parameters.php');
	include ("desk/class/function_data.php");
	include ("desk/class/functions.php");
	//llamamos la clase  DataHTMLModel
	$DataModel= new DataHTMLModel();
	//lamamos a la clase SQLGetSelInt();
  	$SQLGetSelInt= new SQLGetSelInt();
	//llamamos la clase ViewsSQL
	$ViewsSQL= new ViewsSQL();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cursos | Gurú School</title>
  <meta name=" title" content="Cursos | Gurú School">
  <?php include ("includes-front/head.php"); ?>
</head>
<body>
  <!--Navigation-->
    <?php 
    	include("includes-front/menu.php"); 
    	include("includes-front/pop_up.php");
    ?>   
    <section class="with-content">
    	<div class="content-aside">
    	<!--ACORDEON-->
    		<?php
    			//Traemos el accordeon de la clase DataHTMLModel
    			$accordeon=$DataModel->Accordeon(0);
			?>
			  </div> 
    	</div>
    	<div class="content-with-inside">
    		<div class="page-content padding-none-bottom">
    			<div class="container-fluid padding-lesta">
    				<div class="row">
    					<div style="padding-left:0px;" class="col-xs-12">
    					<!--ACORDEON RESPONSIVE-->
	    						<div class="padding-lesta-top" style=" margin-left:10px;">
								    <?php
									    //Traemos el accordeon Responsivo de la clase DataHTMLModel
									    $accordeon=$DataModel->Accordeon(1);
								    ?>
								</div> 
				            </div>
			    			<div style="/*height:1000px;width:100%;overflow-y: scroll;*/" class="contenible-courses">
			    			<!--CURSOS EN LA PLATAFORMA-->
				    			<div class="intermediate text-left">
				    				<h1 class="h1-bold-three">Cursos</h1>
					                <hr>	
				    			</div>	
			    				 <?php
			    				 //Traemos los cursos aleatorios en una vista de la clase DataHTMLModel
			    				 $Courses=$ViewsSQL->GetViewCourses();
			    				 foreach ($Courses as $Data) {
			    				 	//Traemos los cursos aleatorios en una vista de la clase ViewsSQL
	                      			$SQLStudentsIn=$SQLGetSelInt->SQLStudentsIn($Data[0]); 
			    				 	?>
			    				 	<div class="contenible-card">
						                <div  class="card hoverable">
						                    <div class="card-image hidden-xs">
						                        <div class="view overlay hm-white-slight z-depth-1">
						                            <img src="desk/img_user/Cursos_Usuarios/<?php echo $Data[3]; ?>" class="img-responsive" alt="">
						                            <a href="desk/details/<?php echo $Data[0]; ?>/<?php echo str_replace(" ","-",$Data[2]); ?>/">
						                                <div class="mask waves-effect"></div>
						                            </a>
						                        </div>
						                    </div>
						                    <div class="card-image-res visible-xs">
						                        <div class="view overlay hm-white-slight z-depth-1">
						                            <img src="desk/img_user/Cursos_Usuarios/<?php echo $Data[3]; ?>" class="img-responsive" alt="">
						                            <a href="desk/details/<?php echo $Data[0]; ?>/<?php echo str_replace( " ","-,$Data[2]"); ?>/">
						                                <div class="mask waves-effect"></div>
						                            </a>
						                        </div>
						                    </div>
						                    <div class="card-content">
						                        <span class=" span-card black-gray"><?php echo ucwords(substr($Data[2],0,70)); ?>..</span>
						                        <p><?php echo $Data[6]; ?></p>
						                    </div>
						                    <div style="overflow: hidden;" class="card-btn text-left">
							         		<?php if (utf8_encode($Data[5])=="Gratis") {?>
							                   	<h2 style="float: left;" class="h1-bold-second">Grátis</h2>
						                    <?php }else if($Data[5] =="De Pago") {?>
					                    		<h2 style="float: left;" class="h1-bold-second">$ <?php echo number_format($Data[4]); ?> COP</h2>
						                    <?php } ?>
						                		<label style="float: right;" class="opacity-gray margin-lestc-right"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; <?php echo $SQLStudentsIn; ?></label>
						                   </div>
						                </div>
				    				</div>
			    				 	<?php
			    				 }
					            ?>
			    			</div>
    					</div>

    				</div>
    			</div>
    		</div>
    		<center>
    			<div class="pagination form-group">
    				
    			</div>
    		</center>
    	</div>
    </section>
    <!--Footer-->
    <?php include ("includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes-front/scripts.html"); ?>
    <!--Encontrar Cursos-->
    <script type="text/javascript">
		$(document).ready(function(){
			$(".Encontrar").click(function(){
				var SubCategorie=$(this).attr('data-name');
				$.post('desk/case_courses/found_courses.php',{
					NameSubCat:SubCategorie
				},function(info){
					$(".contenible-courses").html(info);
					$(".pagination").html('<div class="col-md-12"><input style="width:50%;" id="quantity" placeholder="Ej:10" type="number" value="0"><br><button id="GoPagination" class="btn btn-default" data-sub="'+ SubCategorie +'" onclick="Pagination(this)">Ver</button><button id="AddPagination" class="btn btn-default" value="5" onclick="AddResult(this)">+</button></div>');
				});

			});
		});
		function Pagination(button){
			var Quantity=$('#quantity').val();
			var SubCategorie=$(button).attr('data-sub');
			$.post('desk/case_courses/found_courses_pagination.php',{
				NameSubCat:SubCategorie,
				Quanti:Quantity
			},function(info){
				if (info==false) {
					window.location="Cursos?accept=yes";
				}
				$(".contenible-courses").html(info);
			});
		}
		function AddResult(button){
			var Quantity=$('#quantity').val();
			var SubCategorie=$("#GoPagination").attr('data-sub');
			var AddPage=$(button).val();
			total=parseFloat(Quantity)+parseFloat(AddPage);
			$.post('desk/case_courses/found_courses_pagination.php',{
				NameSubCat:SubCategorie,
				Quanti:total
			},function(info){
				if (info==false) {
					window.location="Cursos?accept=yes";
				}
				$(".contenible-courses").html(info);
			});
		}
	</script>	
</body>
</html>