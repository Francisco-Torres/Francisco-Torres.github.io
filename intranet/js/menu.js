$(document).ready(function(){
	$("#lnkActividades").on('click',temActividades);
	$("#lnkAliados").on('click',temAliados);
	$("#lnkOracion").on('click',temOracion);
	$("#lnkUsuario").on('click',temUsuarios);
	$("#lnkContactenos").on('click',temContactenos);
	$("#lnkDatos").on('click',temDatos);
	$("#lnkCalendario").on('click',temCalendario);
});

function temActividades()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/actividades.html");
}
function temAliados()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/aliados.html");
}
function temOracion()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/oracion.html");
}
function temUsuarios()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/usuarios.html");
}
function temContactenos()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/interesados.html");
}
function temDatos()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/actDatos.html");
}
function temCalendario()
{
	$("#contenedor_de_plantillas").load("../intranet/view/plantillas/calendario.html");
}