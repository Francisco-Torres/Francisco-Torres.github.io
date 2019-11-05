$(document).ready(function()
{
	$("#lnkSalir").on('click',salir);
	$("#btnListarActividades").on('click',listarActividades);
	$("#btnListarAliados").on('click',listarAliados);
	$("#btnListarOraciones").on('click',listarOraciones);
	$("#btnListarUsuarios").on('click',listarUsuarios);
});
/*Verificar Usuario y clave para ingresar*/
function ingresar()
{
	//se obtienen los datos ingresados por el usuario en el formulario
	var usuario = $("#intUsuario").val();
	var clave = $("#intClave").val();
	//enviar solicitud de verificación en base de datos
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea: 'ingresar', usuario: usuario, clave: clave},
		success:function(data)
		{
			//si la solicitud fue encontrada como válida
			if(data==1)
			{
				location.href='../intranet/principal.php';
			}
			//de lo contrario escribir el error
			else
			{
				$("#loginResultado").html('<span>* '+data+'</span>');
			}
		}
	});
}
/*Salir del Sistema*/
function salir()
{
	/*Solicitud de destrucción de sesión php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'salir'},
		success:function(){
							location.href='login.php';
						  }
	});
}

/*Registrar una nueva actividad*/
function nuevaActividad()
{
	/*Obtener los valores que ingreso el usuario en el formulario*/
	 var lugar = $("#intLugar").val();
	 var fecha1 = $("#intFecha1").val();
	 var fecha2 = $("#intFecha2").val();
	 var estado = $("#intEstado").val();
	 var minimo = $("#intMinAsis").val();
	 var maximo = $("#intMaxAsis").val();
	 var intDescrip = $("#intDescrip").val();
	 /*Enviar a php los datos ingresados por el usuario para insertarlos en la base de datos*/
	 $.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'nueva_actividad', lugar: lugar, fecha1: fecha1, fecha2: fecha2, estado: estado, minimo: minimo, maximo: maximo, intDescrip: intDescrip},
		/*Editar la plantilla con la respuesta que retorna php*/
		success:function(data){
								$("#actividadResultado").html(data);
								$("#actividadEstado").modal('show');
							  }
	 });
}

/*Recargar la página cuando sea necesario*/
function recargar()
{
	location.reload(true);
}

/*Solicitar a php las actividades existentes en la tabla actividades*/
function listarActividades()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'listarActividades'},
		success:function(data){
								$("#tablaActividades").html(data);
								$("#listarActividades").modal('show');
							  }
	});
}

/*Selección de acción detectada*/
function accionActividad(selectAccion)
{
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'actualizarActividad', tipo: selectAccion},
		success:function(data){
								/*Una vez realizada la acción seleccionado por el usuario, se esconde el modal*/
								$("#listarActividades").modal('hide');
							  }
	});
}

/*Ingresar un nuevo aliado*/
function nuevoAliado()
{
	var nombre = $("#intAliado").val();
	var enlace = $("#intenlace").val();
	var descripcion = $("#intDescrip").val();
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'nuevoAliado', nombre1: nombre, enlace: enlace, descripcion: descripcion},
		success:function(data){
								/*mostrar resultado de php al usuario*/
								$("#aliadoResultado").html(data);
								$("#aliadoEstado").modal('show');
							  }
	});
	
}

/*Listar Aliados*/
function listarAliados()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'listarAliados'},
		success:function(data){
								$("#tablaAliados").html(data);
								$("#listarAliados").modal('show');
							  }
	});
}

/*Selección de acción detectada*/
function accionAliado(selectAccion)
{
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'actualizarAliado', tipo: selectAccion},
		success:function(data){
								/*Una vez realizada la acción seleccionado por el usuario, se esconde el modal*/
								$("#listarAliados").modal('hide');
							  }
	});
}

/*Registrar nueva Oración*/
function nuevaOracion()
{
	var titulo = $("#intTitulo").val();
	var descripcion = $("#intDescrip").val();
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'nuevaOracion', titulo: titulo, descripcion: descripcion},
		success:function(data){
								/*mostrar resultado de php al usuario*/
								$("#oracionResultado").html(data);
								$("#oracionEstado").modal('show');
							  }
	});
	
}
/*Listar Oraciones*/
function listarOraciones()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'listarOraciones'},
		success:function(data){
								$("#tablaOraciones").html(data);
								$("#listarOraciones").modal('show');
							  }
	});
}
/*Selección de acción detectada*/
function accionOracion(selectAccion)
{
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'actualizarOracion', tipo: selectAccion},
		success:function(data){
								/*Una vez realizada la acción seleccionado por el usuario, se esconde el modal*/
								$("#listarOraciones").modal('hide');
							  }
	});
}
/*Registrar Nuevo Usuario*/
function nuevousuario()
{
	var documento = $("#intDocumento").val();
	var usuario = $("#intUsuario").val();
	var clave = $("#intClave").val();
	var nombre1 = $("#intNombre1").val();
	var nombre2 = $("#intNombre2").val();
	var apellido1 = $("#intApellido1").val();
	var apellido2 = $("#intApellido2").val();
	var direccion = $("#intDireccion").val();
	var telefono1 = $("#intTelefono1").val();
	var telefono2 = $("#intTelefono2").val();
	var tipo = $("#intTipo").val();
	
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'nuevoUsuario', documento: documento, usuario: usuario, clave: clave, nombre1: nombre1, nombre2: nombre2, apellido1: apellido1, apellido2: apellido2, direccion: direccion, telefono1: telefono1, telefono2: telefono2, tipo: tipo},
		success:function(data){
								/*mostrar resultado de php al usuario*/
								$("#resultadoUsuario").html(data);
								$("#UsuarioEstado").modal('show');
							  }
	});
	
}
/*Listar Usuarios*/
function listarUsuarios()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'listarUsuarios'},
		success:function(data){
								$("#tablaUsuarios").html(data);
								$("#listarUsuarios").modal('show');
							  }
	});
}
/*Administrador Actualiza clave de usuario*/
function actualizarUsuario(documento)
{
	var clave = $("#clave_"+documento).val();
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'actualizarUsuario', documento: documento, clave: clave},
		success:function(data){
								recargar();
								//alert(data);
							  }
	});
}
/*Elimminar un usuario*/
function eliminarUsuario(documento)
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'eliminarUsuario', documento: documento},
		success:function(data){
								recargar();
								//alert(data);
							  }
	});
}
/*Listar los usuario que se han registrado en contactenos*/
function listarInteresados()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'listarInteresados'},
		success:function(data){
								$("#interesadosTable").html(data);
							  }
	});
}
/*Listar los datos del usuario*/
function datosUsuario()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'datosUsuario'},
		success:function(data){
								$("#contenidoDatosUsuario").html(data);
							  }
	});
}

function actDatos()
{
	var documento = $("#intDocumento").val();
	var usuario = $("#intUsuario").val();
	var nombre1 = $("#intNombre1").val();
	var nombre2 = $("#intNombre2").val();
	var apellido1 = $("#intApellido1").val();
	var apellido2 = $("#intApellido2").val();
	var direccion = $("#intDireccion").val();
	var telefono1 = $("#intTelefono1").val();
	var telefono2 = $("#intTelefono2").val();
	
	/*Enviar tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'actUsuario', documento: documento, usuario: usuario, nombre1: nombre1, nombre2: nombre2, apellido1: apellido1, apellido2: apellido2, direccion: direccion, telefono1: telefono1, telefono2: telefono2},
		success:function(data){
								/*mostrar resultado de php al usuario*/
								$("#resultadoUsuario").html(data);
								$("#UsuarioEstado").modal('show');
							  }
	});
}
function cargarCalendario()
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'cargarCalendario'},
		success:function(data){
								$("#calendarioActividades").html(data);
							  }
	});
}

function detalleActividad(id_actividad)
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'detalleActividad', id_actividad: id_actividad},
		success:function(data){
								$("#detActividad").html(data);
								$("#dActividad").modal('show');
							  }
	});
}

function newUsuActividad(id_actividad)
{
	/*Envia tarea a php*/
	$.ajax({
		url:'controladores/controlador.php',
		type:'POST',
		data:{tarea:'newUsuActividad', id_actividad: id_actividad},
		success:function(data){
								$("#regActividad").html(data);
								$("#registroActividad").modal('show');
							  }
	});
}
