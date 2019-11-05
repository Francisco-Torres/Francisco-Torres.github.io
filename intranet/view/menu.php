	<section class="container">
	   <div class="row">
		 <header>
			 <nav class="navbar navbar-default" role="navigation">
			  <div class="container-fluid">
				<!-- Compatibilidad con dispositivos mobiles -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="principal.php">Inicio</a>
				</div>
			 
				<!-- Menú -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<!--Esto solo pueden verlo los administradores-->
					<?php if($_SESSION['tipo']==1):?>
					<li><a href="#" id="lnkActividades">Registro Actividades</a></li>
					<li><a href="#" id="lnkAliados">Aliados</a></li>
					<li><a href="#" id="lnkOracion">Oraci&oacute;n del D&iacute;a</a></li>
					<li><a href="#" id="lnkUsuario">Usuarios</a></li>
					<li><a href="#" id="lnkContactenos">Posibles Aliados</a></li>
					<!--Esto solo pueden verlo los administradores-->
					<?php endif;?>
					<li><a href="#" id="lnkCalendario">Calendario</a></li>
				  </ul>
				  <ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['nombre'];?> (<?php echo $_SESSION['desTipo']?>)<span class="caret"></span></a>
					  <ul class="dropdown-menu" role="menu">
						<li><a href="#" id="lnkDatos">Actualizar Datos</a></li>
						<li class="divider"></li>
						<li><a href="#" id="lnkSalir">Salida Segura</a></li>
					  </ul>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>
		 </header>
	  </div>
	</section>