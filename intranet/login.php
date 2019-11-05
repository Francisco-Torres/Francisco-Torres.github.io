<!--cargar todos los archivos necesarios para estilos y eventos-->
<?php include("view/head_metas.html"); ?>
<!--contenido-->
  <body>
		<div class="row">
			<!-- Se carga la Imágen o logo -->
			<br><br><br><br><br>
			<?php include("view/logo.html");?>
			<!-- Contenido de la página -->
			<div class="col-md-4 col-md-offset-4" id="loginBox">
				<form class="form-horizontal" onsubmit="ingresar(); return false;">
					<div class="col-md-offset-2">
					  <br>
					  <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">Usuario: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="intUsuario" placeholder="usuario" required />
						</div>
					  </div>
					  <div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Clave: </label>
						<div class="col-sm-8">
						  <input type="password" class="form-control" id="intClave" placeholder="clave" required />
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-8" id="loginResultado"></div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-10">
						  <button type="submit" id="btnIngresar" class="btn btn-default">Ingresar</button>
						</div>
					  </div>
					</div>
				</form>
			</div>
		</div>
  </body>
 <!--fin contenido-->
</html>