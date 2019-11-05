<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//se incluye la clase
require_once("../clases/basededatosClass.php");
require_once("../clases/respuestas_php_html.php");
//se instancia la clase
$mibase = new db();
$miphp_html = new php_html();
//se determina la tarea
$tarea = $_POST['tarea'];

switch($tarea)
{
	case 'ingresar':
		$mibase->ingresar($_POST);
	break;
	case 'salir':
		$mibase->salir();
	break;
	case 'nueva_actividad':
		$mibase->nueva_actividad($_POST);
	break;
	case 'listarActividades':
		$miphp_html->listarActividades();
	break;
	case 'actualizarActividad':
		$mibase->actualizarActividad($_POST);
	break;
	case 'nuevoAliado':
		$mibase->nuevoAliado($_POST);
	break;
	case 'listarAliados':
		$miphp_html->listarAliados();
	break;
	case 'actualizarAliado':
		$mibase->actualizarAliado($_POST);
	break;
	case 'nuevaOracion':
		$mibase->nuevaOracion($_POST);
	break;
	case 'listarOraciones':
		$miphp_html->listarOraciones();
	break;
	case 'actualizarOracion':
		$mibase->actualizarOracion($_POST);
	break;
	case 'nuevoUsuario':
		$mibase->nuevoUsuario($_POST);
	break;
	case 'listarUsuarios':
		$miphp_html->listarUsuarios();
	break;
	case 'actualizarUsuario':
		$mibase->actualizarUsuario($_POST);
	break;
	case 'eliminarUsuario':
		$mibase->eliminarUsuario($_POST);
	break;
	case 'enviarInteresado':
		$mibase->enviarInteresado($_POST);
	break;
	case 'listarInteresados':
		$miphp_html->listarInteresados();
	break;
	case 'obtActividades':
		$miphp_html->obtActividades();
	break;
	case 'obtOracion':
		$miphp_html->obtOracion();
	break;
	case 'obtAliados':
		$miphp_html->obtAliados();
	break;
	case 'datosUsuario':
		$miphp_html->datosUsuario();
	break;
	case 'actUsuario':
		$mibase->actUsuario($_POST);
	break;
	case 'cargarCalendario':
		$miphp_html->cargarCalendario();
	break;
	case 'detalleActividad':
		$miphp_html->detalleActividad($_POST);
	break;
	case 'newUsuActividad':
		$mibase->newUsuActividad($_POST);
	break;
}
?>