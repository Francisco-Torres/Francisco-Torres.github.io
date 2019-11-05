<?php
session_start();
if(isset($_SESSION['documento'])):
require_once("view/head_metas.html");
?>
  <body>
		<div class="row">
			<?php require_once("view/menu.php"); ?>
			<?php require_once("view/logo.html"); ?>
			<div class="container">
				<div class="row">
					<div class="jumbotron" id="contenedor_de_plantillas">
					<!--las plantillas serán insertadas aquí por jquery-->
					</div>
				</div>
			</div>
		</div>
  </body>
</html>
<?php
else:
	header("Location: /Fundacion/index.html");
endif;
?>