<?php
  if (isset($_GET['request'])) {
    ?>
	<body onload="notify('Notificacion','<?php echo $_GET['request'];?>','error','brighttheme');">
    <?php
  }else if(isset($_GET['requestok'])){
  	?>
	<body onload="notify('Notificación','<?php echo $_GET['requestok'];?>','success','brighttheme');">
    <?php
  }
?>