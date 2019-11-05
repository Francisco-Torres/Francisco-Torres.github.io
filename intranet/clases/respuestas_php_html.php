<?php
/*Incluir al archivo que gestiona las consultas a la base de datos*/
require_once("basededatosClass.php");
/*Crear clase que obtendrá los datos de la base de datos cuando estos deben ser retornados de brain.js con etiquetas html
  Esta clase garantiza que basededatosClass.php no tenga contenido html en su estructura*/
class php_html
{
	public function listarActividades()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste las actividades*/
		$db->actividadesTabla();
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->actividadesListaObj->fetch_assoc()):
		echo '<tr>
				<td>'.$row['fecha_inicio'].'</td>
				<td>'.$row['lugar'].'</td>
				<td>'.$row['descripcion'].'</td>
				<td>'.$row['estadodesc'].'</td>
				<td>
					<select id="selectAccionActividad" Onchange="accionActividad(this.value);">
						<option value="">....</option>
						<option value="activar_'.$row['id_actividad'].'">Activar</option>
						<option value="suspender_'.$row['id_actividad'].'">Suspender</option>
						<option value="eliminar_'.$row['id_actividad'].'">Eliminar</option>
					</select>
				</td>
			 </tr>';
		endwhile;
	}
	
	public function listarAliados()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->aliadosTabla();
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->aliadosListaObj->fetch_assoc()):
		echo '<tr>
				<td>'.$row['Nombre'].'</td>
				<td>'.$row['enlace'].'</td>
				<td>'.$row['estadodesc'].'</td>
				<td>
					<select id="selectAccionAliado" Onchange="accionAliado(this.value);">
						<option value="">....</option>
						<option value="activar_'.$row['id_aliado'].'">Activar</option>
						<option value="suspender_'.$row['id_aliado'].'">Suspender</option>
						<option value="eliminar_'.$row['id_aliado'].'">Eliminar</option>
					</select>
				</td>
			 </tr>';
		endwhile;
	}
	
	public function listarOraciones()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->oracionesTabla();
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->oracionListaObj->fetch_assoc()):
		echo '<tr>
				<td>'.$row['Titulo'].'</td>
				<td>'.$row['estadodesc'].'</td>
				<td>
					<select id="selectAccionAliado" Onchange="accionOracion(this.value);">
						<option value="">....</option>
						<option value="activar_'.$row['id_oracion'].'">Activar</option>
						<option value="suspender_'.$row['id_oracion'].'">Suspender</option>
						<option value="eliminar_'.$row['id_oracion'].'">Eliminar</option>
					</select>
				</td>
			 </tr>';
		endwhile;
	}
	
	public function listarUsuarios()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->UsuariosTabla();
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->usuariosListaObj->fetch_assoc()):
		echo '<tr>
				<td>'.$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2'].'</td>
				<td>'.$row['usuario'].'</td>
				<td><input type="text" value="'.$row['clave'].'" id="clave_'.$row['documento'].'" /></td>
				<td>'.$row['tipo'].'</td>
				<td><button type="submit" class="btn btn-success" onclick="actualizarUsuario('.$row['documento'].');">Guargar</button></td>
				<td><button type="submit" class="btn btn-danger" onclick="eliminarUsuario('.$row['documento'].')">Eliminar</button></td>
			   </td>
			 </tr>';
		endwhile;
	}
	
	public function listarInteresados()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->interesadosTabla();
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->interesadosListaObj->fetch_assoc()):
		echo '<tr>
				<td>'.$row['nombre'].'</td>
				<td>'.$row['correo'].'</td>
				<td>'.$row['telefono1'].'</td>
				<td>'.$row['telefono2'].'</td>
				<td>'.$row['ubicacion'].'</td>
				<td>'.$row['mensaje'].'</td>
			   </td>
			  </tr>';
		endwhile;
	}
	
	public function obtActividades()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->tablaActividades();
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		echo '<table class="tablaDinamica">
			  <thead>
				<tr>
					<th>Lugar</th>
					<th>Fecha Inicio</th>
					<th>Fecha Final</th>
					<th>Asistentes</th>
					<th>M&aacute;ximo</th>
					<th>Descripci&oacute;n</th>
				</tr>
			  </thead>
			  <tbody>';
		while($row = $db->actividadesobt->fetch_array()):
		echo '<tr>
				<td>'.$row['lugar'].'</td>
				<td>'.$row['fecha_inicio'].'</td>
				<td>'.$row['fecha_final'].'</td>
				<td>'.$row['min_asis'].'</td>
				<td>'.$row['max_asis'].'</td>
				<td>'.$row['descripcion'].'</td>
			   </td>
			  </tr>';
		endwhile;
		echo '</tbody></table>';
	}
	
	public function obtOracion()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->tablaOracion();
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->oracionobt->fetch_array()):
		echo '
		<table class="tablaDinamica">
		  <thead>
			<tr>
			  <th>'.$row['Titulo'].'</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td>'.$row['descripcion'].'</td>
			  </tr>
		  </tbody>
		</table><br><br>';
		endwhile;
	}
	
	public function obtAliados()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->tablaAliados();
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		while($row = $db->aliadosobt->fetch_array()):
		echo '
		<table class="tablaDinamica">
		  <thead>
			<tr>
			  <th>'.$row['Nombre'].'</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td><a href="'.$row['enlace'].'">'.$row['enlace'].'</a></td>
			</tr>
			<tr>
				<td>'.$row['descripcion'].'</td>
			</tr>
		  </tbody>
		</table><br><br>';
		endwhile;
	}
	
	public function datosUsuario()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->dUsuario();
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		echo '<div class="form-group">
		<label for="exampleInputEmail1">Documento</label>
		<input type="int" class="form-control" id="intDocumento" value="'.$db->datosDeUsuario['documento'].'" placeholder="Documento" disabled>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Usuario</label>
		<input type="text" class="form-control" id="intUsuario" value="'.$db->datosDeUsuario['usuario'].'" placeholder="Usuario" disabled>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Primer Nombre</label>
		<input type="text" class="form-control" id="intNombre1" value="'.$db->datosDeUsuario['nombre1'].'" placeholder="Primer Nombre" required>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Segundo Nombre</label>
		<input type="text" class="form-control" id="intNombre2" value="'.$db->datosDeUsuario['nombre2'].'" placeholder="Segundo Nombre" required>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Primer Apellido</label>
		<input type="text" class="form-control" id="intApellido1" value="'.$db->datosDeUsuario['apellido1'].'" placeholder="Primer Apellido" required>
	  </div>
	  	  <div class="form-group">
		<label for="exampleInputEmail1">Segundo Apellido</label>
		<input type="text" class="form-control" id="intApellido2" value="'.$db->datosDeUsuario['apellido2'].'" placeholder="Segundo Apellido" required>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Direcci&oacute;n</label>
		<input type="text" class="form-control" id="intDireccion" value="'.$db->datosDeUsuario['direccion'].'" placeholder="Direcci&oacute;n" required>
	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Tel&eacute;fono</label>
		<input type="text" class="form-control" id="intTelefono1" value="'.$db->datosDeUsuario['telefono1'].'" placeholder="Tel&eacute;fono" required>
	  </div>
	  	  </div>
	  <div class="form-group">
		<label for="exampleInputEmail1">Tel&eacute;fono 2</label>
		<input type="text" class="form-control" id="intTelefono2" value="'.$db->datosDeUsuario['telefono2'].'" placeholder="Tel&eacute;fono 2" required>
	  </div>
	  <button type="submit" class="btn btn-success">Guardar</button>';
	}
	/*Clase extensa que define el calendario que será cargado*/
	public function cargarCalendario()
	{
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->tablaCalendario();
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/
		
		while($rowcal = $db->calendarioObj->fetch_assoc()):
			
			$db->verUsuAct($rowcal['id_actividad']);
			echo '
					<table class="table">
						<thead>
							<tr>
								<th>'.$rowcal['anio'].'</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr>
								<th></th>
								<th>'.$rowcal['mes_descrip'].'</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th>Semana '.$rowcal['semana_del_mes'].'</th>
								<th></th>
								<th></th>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th>'.$rowcal['dia_descrip'].'</th>
								<th></th>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th><table class="table">
											<thead>
												<th>
													Lugar
												</th>
												<th>
													Fecha Inicial
												</th>
												<th>
													Fecha Final
												</th>
												<th>
													Descripci&oacute;n
												</th>
												<th>
													Acci&oacute;n
												</th>
											<thead>
											<tbody>';
												if($db->rsverUsuAct==1):
													echo '<tr class="active">';
												else:
													if($rowcal['cup_dis']==0):
														echo '<tr class="danger">';
													else:
														echo '<tr class="success">';
													endif;
												endif;
												echo'<td>
														'.$rowcal['lugar'].'
													</td>
													<td>
														'.$rowcal['fecha_inicio'].'
													</td>
													<td>
														'.$rowcal['fecha_final'].'
													</td>
													<td>
														'.$rowcal['descripcion'].'
													</td>
													<td>';
														if($db->rsverUsuAct==1):
															echo 'Registrado';
														else:
															if($rowcal['cup_dis']==0):
																echo 'No hay Cupos Disponibles';
															else:
															echo '
																   <button type="button" class="btn btn-success" Onclick="newUsuActividad('.$rowcal['id_actividad'].')">Registrarme</button>
																 ';
															endif;
														endif;
														echo'<button type="button" class="btn btn-primary" Onclick="detalleActividad('.$rowcal['id_actividad'].')">Detalles</button>
												    </td>
												</tr>
											</body>
										</table>
								</th>
							</tr>
						</thead>
					</table>
				 ';
		endwhile;
	}
	
	public function detalleActividad($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		
		/*Un objeto con todo el contenido de la clase db que esá definida en basededatosClass.php*/
		$db = new db();
		/*Solicitar a basededatosClass que liste los aliados*/
		$db->tablaActividadesDetalle($id_actividad);
		//var_dump($db->actividadesobt->fetch_array(MYSQLI_ASSOC));
		/*Definir estructura html para retornar a brain.js con datos dinámicos en php*/

		echo '
				<h3>Personas que Asistir&aacute;n</h3>
				<table class="table">
					<thead>
						<tr>
						</tr>
					</thead>
					<tbody>
					';
						while($row = $db->actividadesDetalle->fetch_assoc()):
							echo '
									<tr>
										<td> - '.$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2'].'</td>
									</tr>
								 ';
						endwhile;
			    echo'</tbody>
				</table>';
		$db->tablaActividadesDetalle($id_actividad);
		$rs = $db->actividadesDetalle->fetch_assoc();
		echo '
			<h3>Descripci&oacute;n de la Actividad:</h3>
			<small>  - '.$rs['descripcion'].'</small>
			<br><br>
			<h4>Actualmente hay '.$rs['cup_asig'].' personas inscritas y '.$rs['cup_dis'].' cupos disponibles para participar</h4>';
	}
}
?>