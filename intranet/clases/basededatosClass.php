<?php
/*Inciar las sesiones*/
session_start();
class db
{
	
	private $basededatos = 'fundacion';
	public $actividadesLista;
	public $actividadesListaObj;
	public $aliadosLista;
	public $aliadosListaObj;
	public $oracionLista;
	public $oracionListaObj;
	public $usuariosLista;
	public $usuariosListaObj;
	public $interesadosLista;
	public $interesadosListaObj;
	public $actividadesobt;
	public $oracionobt;
	public $aliadosobt;
	public $datosDeUsuario;
	public $calendarioObj;
	public $actividadesDetalle;
	public $rsverUsuAct;
	
	private function conectar()
	{
		//establecer conexion con la base de datos
		$con= new mysqli("192.168.10.29","fundacion","fundacion2015",$this->basededatos);
		//Setear el formato adecuado amysql para uso de caracteres en español como la letra Ñ y tildes
		$con->query("set names 'utf8'");
		//algún problema con la conexión
		if($con->connect_errno > 0):
			echo 'Problemas con la conexión';
		endif;
		//si todo está bien se retorna la conexión seteada
		return $con;
	}
	
	/*Clases Para limpiar los valores de entreda que ingresa el usuario en la web*/
	private function limpiarDatos($entrada) 
	{
	  /*Array con posibles caracteres peligrosos*/
	  $buscar = array(
		'@<script [^>]*?>.*?@si',            // Javascript
		'@< [/!]*?[^<>]*?>@si',            // tag de html
		'@<style [^>]*?>.*?</style>@siU',    // propiedades de estilo
		'@< ![sS]*?--[ tnr]*>@'         // inyeccion sql
	  );
	  /*Si existen se limpian de la cadena de entrada*/
	  $salida = preg_replace($buscar, '', $entrada);
	  /*Retornar variable limpia*/
	  return $salida;
	}
	
	private function sanear($entrada) 
	{
		/*Si es un arreglo haga*/
		if (is_array($entrada)):
			/*Cada posición del arreglo se limpia con el método limpiarDatos*/
			foreach($entrada as $var=>$val):
				$entrada[$var] = $this->limpiarDatos($val);
		    endforeach;
		/*Si no es arreglo haga*/
		else:
		/*Limpiar Cadena*/
        $entrada  = $this->limpiarDatos($entrada);
		/*limpia caracteres de uso sql, solo para php menor a 5.5*/
        $entrada = mysql_real_escape_string($entrada);
		endif;
		return $entrada;
	}
	/*fin Clases Para limpiar los valores de entreda que ingresa el usuario en la web*/
	
	public function ingresar($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		//encriptar clave a md5
		$md5Clave = md5($clave);
		//limpiar las variables de entrada evitando vulnerabilidad
		$usuarioListo = $this->sanear($usuario);
		$md5ClaveListo = $this->sanear($md5Clave);
		//generar la consulta con las credenciales digitadas por el usuario
		$consulta = "select a.* , b.descripcion as desTipo
					 from ".$this->basededatos.".fun_usuarios a
					 left join ".$this->basededatos.".tipo b on a.tipo = b.id_tipo
					 where usuario = '".$usuario."'
					 and clave = '".$md5Clave."'";
		//ejecutar consulta
		$rs=$this->conectar()->query($consulta);
		//verificar si la consulta no tuvo errores
		if($rs):
			//si encontró el usuario y clave
			if($rs->num_rows > 0):
				//obtener datos encontrados
				$datosUsuario = $rs->fetch_assoc();
				//si el usuario está activo
				if($datosUsuario['estado'] == 1):
					//como todo salió bien se crean las sesiones
					$_SESSION['documento'] = $datosUsuario['documento'];
					$_SESSION['nombre'] = $datosUsuario['nombre1'].' '.$datosUsuario['nombre2'].' '.$datosUsuario['apellido1'].' '.$datosUsuario['apellido2'];
					$_SESSION['tipo'] = $datosUsuario['tipo'];
					$_SESSION['desTipo'] = $datosUsuario['desTipo'];
					echo 1;
				/*el registro encontrado tiene como estado uno diferente a 1, es decir que no está activo*/
				else:
					echo 'El Usuario no se encuentra activo';
				endif;	
			//no encontró usuario y clave
			else:
				echo 'Usuario o clave no v&aacute;lida';
			endif;
		/*hay algún problema con la consulta, intento de hack o problema de sintaxis con en la consulta*/
		else:
			echo 'Tenemos un error, consulte al administrador del sistema';
		endif;
	}
	
	public function salir()
	{
		//obtener las sesiones credas
		$_SESSION = array();
		//eliminar las cookies de sesión
		if (ini_get("session.use_cookies")):
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		endif;
		//destruir la sesion
		session_destroy();
	}
	
	public function nueva_actividad($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*preparar la consulta para insertar los datoa en la tabla actividades*/
		$insertar = "insert into ".$this->basededatos.".actividades
					(lugar,fecha_inicio,fecha_final,estado,min_asis,max_asis,descripcion,cup_dis,cup_asig) 
					values('".$this->sanear($lugar)." ','".$this->sanear(str_replace("T"," ",$fecha1))."',' ".$this->sanear(str_replace("T"," ",$fecha2))."',".$this->sanear($estado).",".$this->sanear($minimo).",".$this->sanear($maximo).",'".$this->sanear($intDescrip)."','".$this->sanear($maximo)."','0')";
		/*ejecutar la consulta*/
		$rs_insert = $this->conectar()->query($insertar);
		/*Si todo está bien*/
		if($rs_insert):
			echo 'Gracias,Actividad Ingresada Correctamente';
		/*algo pasó ejecutando la consulta*/
		else:
			echo 'Tenemos alg&uacute;n problema, confirma la informaci&oacute;n que estas intentando ingresar';
		endif;
	}
	
	public function actividadesTabla()
	{
		/*Preparar Consulta*/
		$lista="select a.* ,b.descripcion as estadodesc
				from actividades a
				left join estados b 
				on a.estado = b.id_estado";
		/*Ejecturar Consulta*/
		$exec = $this->conectar()->query($lista);
		/*almacenar resultado para que se pueda obtener*/
		if($exec):
		    /*Array con resultados*/
			//$this->actividadesLista = $exec->fetch_assoc();
			/*Objeto de tipo Sql*/
			$this->actividadesListaObj = $exec;
		else:
			$this->actividadesLista = 'Hay algún problema en la consulta, contacte al administrador';
		endif;
	}
	
	public function actualizarActividad($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Separa la acción seleccionada por el usuario y el id_de la actividad a afectar*/
		$arreglo = explode("_",$tipo);
		$tipo = $arreglo[0];
		$id_actividad = $arreglo[1];
		/*Según la accion seleccionada por el usuario se prepara la consulta a la base de datos*/
		switch($tipo):
			case 'activar':
				$consulta = "update actividades set estado = 1 where id_actividad =".$id_actividad."";
			break;
			case 'suspender':
				$consulta = "update actividades set estado = 2 where id_actividad =".$id_actividad."";
			break;
			case 'eliminar':
				$consulta = "delete from actividades where id_actividad =".$id_actividad."";
			break;
		endswitch;
		/*Ejecutar la consulta*/
		$this->conectar()->query($consulta);
	}
	
	public function nuevoAliado($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Preparar la consulta*/
		$consulta = "insert into web_con_aliados (Nombre,enlace,descripcion,estado)
					 values('".$this->sanear($nombre1)."','".$this->sanear($enlace)."','".$this->sanear($descripcion)."',1)";
		$rs = $this->conectar()->query($consulta);
		
		if($rs):
			echo 'El Aliado fue registrado correctamente';
		else:
			echo 'Se presentó un problema compurebe los datos diligenciados';
		endif;	
	}
	
	public function aliadosTabla()
	{
		/*Preparar Consulta*/
		$lista="select a.*, b.descripcion as estadodesc 
				from web_con_aliados a
				left join estados b on a.estado = b.id_estado";
		/*Ejecturar Consulta*/
		$exec_aliado = $this->conectar()->query($lista);
		/*almacenar resultado para que se pueda obtener*/
		if($exec_aliado):
		    /*Array con resultados*/
			//$this->aliadosLista = $exec_aliado->fetch_assoc();
			/*Objeto de tipo Sql*/
			$this->aliadosListaObj = $exec_aliado;
		else:
			$this->actividadesLista = 'Hay algún problema en la consulta, contacte al administrador';
		endif;
	}
	
	public function actualizarAliado($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Separa la acción seleccionada por el usuario y el id del aliado a afectar*/
		$arreglo = explode("_",$tipo);
		$tipo = $arreglo[0];
		$id_aliado = $arreglo[1];
		/*Según la accion seleccionada por el usuario se prepara la consulta a la base de datos*/
		switch($tipo):
			case 'activar':
				$consulta = "update web_con_aliados set estado = 1 where id_aliado =".$id_aliado."";
			break;
			case 'suspender':
				$consulta = "update web_con_aliados set estado = 2 where id_aliado =".$id_aliado."";
			break;
			case 'eliminar':
				$consulta = "delete from web_con_aliados where id_aliado =".$id_aliado."";
			break;
		endswitch;
		/*Ejecutar la consulta*/
		$this->conectar()->query($consulta);
	}
	
	public function nuevaOracion($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Preparar la consulta*/
		$consulta = "insert into web_con_oracion (titulo,descripcion,estado)
					 values('".$this->sanear($titulo)."','".$this->sanear($descripcion)."',1)";
		$rs = $this->conectar()->query($consulta);
		
		if($rs):
			echo 'La oraci&oacute;n fue registrado correctamente';
		else:
			echo 'Se presentó un problema compurebe los datos diligenciados';
		endif;	
	}
	
	public function oracionesTabla()
	{
		/*Preparar Consulta*/
		$lista="select a.*, b.descripcion as estadodesc 
				from web_con_oracion a
				left join estados b on a.estado = b.id_estado";
		/*Ejecturar Consulta*/
		$exec_oracion = $this->conectar()->query($lista);
		/*almacenar resultado para que se pueda obtener*/
		if($exec_oracion):
		    /*Array con resultados*/
			//$this->oracionLista = $exec_oracion->fetch_assoc();
			/*Objeto de tipo Sql*/
			$this->oracionListaObj = $exec_oracion;
		else:
			$this->actividadesLista = 'Hay algún problema en la consulta, contacte al administrador';
		endif;
	}
	
	public function actualizarOracion($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Separa la acción seleccionada por el usuario y el id del aliado a afectar*/
		$arreglo = explode("_",$tipo);
		$tipo = $arreglo[0];
		$id_aliado = $arreglo[1];
		/*Según la accion seleccionada por el usuario se prepara la consulta a la base de datos*/
		switch($tipo):
			case 'activar':
				$consulta = "update web_con_oracion set estado = 1 where id_oracion =".$id_aliado."";
			break;
			case 'suspender':
				$consulta = "update web_con_oracion set estado = 2 where id_oracion =".$id_aliado."";
			break;
			case 'eliminar':
				$consulta = "delete from web_con_oracion where id_oracion =".$id_aliado."";
			break;
		endswitch;
		/*Ejecutar la consulta*/
		$this->conectar()->query($consulta);
	}
	
	public function nuevoUsuario($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		
		$md5Clave = md5($clave);
	
		/*Preparar la consulta*/
		$consulta = "insert into fun_usuarios values('".$this->sanear($documento)."','".$this->sanear($usuario)."','".$md5Clave."','".$this->sanear($nombre1)."','".$this->sanear($nombre2)."','".$this->sanear($apellido1)."','".$this->sanear($apellido2)."','".$this->sanear($direccion)."','".$this->sanear($telefono1)."','".$this->sanear($telefono2)."','".$this->sanear($tipo)."',1)";
		
		$rs = $this->conectar()->query($consulta);
		
		if($rs):
			echo 'Usuario Registrado Correctamente';
		else:
			echo 'Se present&oacute; un problema compruebe los datos diligenciados';
		endif;
	}
	
	public function UsuariosTabla()
	{
		/*Preparar Consulta*/
		$lista="select documento,nombre1,nombre2,apellido1,apellido2,usuario,clave,b.descripcion as tipo,c.descripcion as estado
				from fun_usuarios a
				left join tipo b on a.tipo = b.id_tipo
				left join estados c on a.estado = c.id_estado";
		/*Ejecturar Consulta*/
		$exec_usuarios = $this->conectar()->query($lista);
		/*almacenar resultado para que se pueda obtener*/
		if($exec_usuarios):
		    /*Array con resultados*/
			//$this->usuariosLista = $exec_usuarios->fetch_assoc();
			/*Objeto de tipo Sql*/
			$this->usuariosListaObj = $exec_usuarios;
		else:
			$this->actividadesLista = 'Hay algún problema en la consulta, contacte al administrador';
		endif;
	}
	
	public function actualizarUsuario($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		
		/*Encriptar clave a md5*/
		$md5Clave = md5($clave);
		/*Preparar Consulta*/
		$actUsuario = "update fun_usuarios set clave ='".$this->sanear($md5Clave)."' where documento=".$documento."";
		//Ejecutar la consulta
		$this->conectar()->query($actUsuario);
	}
	
	public function eliminarUsuario($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		
		/*preparar la consulta*/
		$eliUsuario = "delete from fun_usuarios where documento=".$documento;
		/*Ejecutar Consulta*/
		$this->conectar()->query($eliUsuario);
		//echo $eliUsuario;
	}
	
	public function enviarInteresado($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Preparar la consulta*/
		$inserInteresado = "insert into fun_interesados
		values('".$this->sanear($nombre1)."','".$this->sanear($correo)."','".$this->sanear($telefono1)."','".$this->sanear($telefono2)."','".$this->sanear($ubicacion)."','".$this->sanear($mensaje)."')";
		/*Ejecutar la consulta*/
		$this->conectar()->query($inserInteresado);
	}
	
	public function interesadosTabla()
	{
		/*Preparar Consulta*/
		$lista="select * 
				from fun_interesados";
		/*Ejecturar Consulta*/
		$exec_interesados = $this->conectar()->query($lista);
		/*almacenar resultado para que se pueda obtener*/
		if($exec_interesados):
		    /*Array con resultados*/
			//$this->interesadosLista = $exec_interesados->fetch_assoc();
			/*Objeto de tipo Sql*/
			$this->interesadosListaObj = $exec_interesados;
		else:
			$this->actividadesLista = 'Hay algún problema en la consulta, contacte al administrador';
		endif;
	}
	
	public function tablaActividades()
	{
		$lista = "select * from actividades where estado=1";
		$this->actividadesobt = $this->conectar()->query($lista);
	}
	
	public function tablaOracion()
	{
		$lista = "select * from web_con_oracion where estado = 1";
		$this->oracionobt = $this->conectar()->query($lista);
	}
	
	public function tablaAliados()
	{
		$lista="select * from web_con_aliados where estado = 1";
		$this->aliadosobt = $this->conectar()->query($lista);
	}
	
	public function dUsuario()
	{
		$lista = "select * from fun_usuarios where documento =".$_SESSION['documento'];
		$rs = $this->conectar()->query($lista);
		$this->datosDeUsuario = $rs->fetch_assoc();
	}
	public function actUsuario($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;
		/*Preparar Consultas*/
		$consulta = "update fun_usuarios 
					 set nombre1='".$this->sanear($nombre1)."'
					 ,nombre2='".$this->sanear($nombre2)."'
					 ,apellido1='".$this->sanear($apellido1)."'
					 ,apellido2='".$this->sanear($apellido2)."'
					 ,direccion='".$this->sanear($direccion)."'
					 ,telefono1='".$this->sanear($telefono1)."'
					 ,telefono2='".$this->sanear($telefono2)."'
					 where documento = '".$_SESSION['documento']."'";
		/*Ejecutar Consulta*/
		$rs = $this->conectar()->query($consulta);
		/*Si todo está bien*/
		if($rs):
			echo 'Datos actualizados correctamente';
		/*Si se tiene alguna falla*/
		else:
			echo 'Hay algún mal,por favor confirme la información ingresada';
		endif;
	}
	
	public function tablaCalendario()
	{
		/*Preparar la consulta*/
		$lista = "select year(fecha_inicio) as anio
				,if(month(fecha_inicio)=1,'Enero',if(month(fecha_inicio)=2,'Febrero',if(month(fecha_inicio)=3,'Marzo',if(month(fecha_inicio)=4,'Abril',if(month(fecha_inicio)=5,'Mayo',if(month(fecha_inicio)=6,'Junio',if(month(fecha_inicio)=7,'Julio',if(month(fecha_inicio)=8,'Agosto',if(month(fecha_inicio)=9,'Septiembre',if(month(fecha_inicio)=10,'Octubre',if(month(fecha_inicio)=11,'Noviembre',if(month(fecha_inicio)=12,'Diciembre','error')))))))))))) as mes_descrip
				,month(fecha_inicio) as mes
				,WEEK(fecha_inicio, 5) - WEEK(DATE_SUB(fecha_inicio, INTERVAL DAYOFMONTH(fecha_inicio) - 1 DAY), 5) + 1 as semana_del_mes
				,if(weekday(fecha_inicio)=0,'Lunes',if(weekday(fecha_inicio)=1,'Martes',if(weekday(fecha_inicio)=2,'Miercoles',if(weekday(fecha_inicio)=3,'Jueves',if(weekday(fecha_inicio)=4,'Viernes',if(weekday(fecha_inicio)=5,'Sabado',if(weekday(fecha_inicio)=6,'Domingo','error'))))))) as dia_descrip
				,weekday(fecha_inicio) as dia_de_semana 
				,a.*
				from actividades a
				where estado = 1
				order by year(fecha_inicio),month(fecha_inicio), WEEK(fecha_inicio, 5) - WEEK(DATE_SUB(fecha_inicio, INTERVAL DAYOFMONTH(fecha_inicio) - 1 DAY), 5) + 1 ,weekday(fecha_inicio);";
		/*Ejecutar consulta*/
		$this->calendarioObj = $this->conectar()->query($lista);
	}
	
	public function tablaActividadesDetalle($id_actividad)
	{
		$consulta = "select *
					from rel_usu_act a
					left join actividades b on a.id_actividad = b.id_actividad
					left join fun_usuarios c on a.documento = c.documento 
					where a.id_actividad=$id_actividad";

		$this->actividadesDetalle = $this->conectar()->query($consulta);
	}
	
	public function newUsuActividad($datos)
	{
		//convertir el arreglo datos en variables independientes de php
		foreach ($datos as $nombre => $valor):
			$validar = '$'.$nombre.'="'.$valor.'";';
			eval($validar);
		endforeach;

		/*Insertar el usuario y la actividad a la que se registró*/
		$insert="insert into rel_usu_act values ('".$id_actividad."','".$_SESSION['documento']."')";
		$this->conectar()->query($insert);
		/*Consultar las personas registradas y los cupos disponibles en la actividad*/
		$consultar="select * from actividades where id_actividad = '".$id_actividad."'";
		$exec = $this->conectar()->query($consultar);
		$rs = $exec->fetch_assoc();
		/*calcular personas registradas ahora*/
		$cup_asig = $rs['cup_asig'] + 1;
		/*Calcular los cupos disponibles*/
		$cup_dis = $rs['cup_dis'] - $cup_asig;
		/*Actualizar valores en la tabla de actividades*/
		$actualizar = "update actividades set cup_dis='".$cup_dis."', cup_asig='".$cup_asig."' where id_actividad=$id_actividad";
		$this->conectar()->query($actualizar);
		echo 'Registro exitoso, Gracias por querer participar';
	}
	
	public function verUsuAct($id_actividad)
	{
		$consulta="select * from rel_usu_act where id_actividad='".$id_actividad."' and documento='".$_SESSION['documento']."'";
		$exec = $this->conectar()->query($consulta);
		$this->rsverUsuAct = $exec->num_rows;	
	}
}
?>