<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login_controller";

//MENU
$route['iniciar-sesion']="login_controller/loginUsuario";
$route['inicio'] = "inicio_controller";
$route['nueva-tarea'] = "nuevatarea_controller";
$route['crear-nueva-tarea'] = "nuevatarea_controller/nuevaTarea";
$route['tareas-pendientes'] ="tareaspendientes_controller";
$route['tareas-en-curso']="tareascurso_controller";
$route['tareas-completadas']="tareascompletadas_controller";
$route['tareas-creadas']="tareascreadas_controller";
$route['cerrar-sesion']="login_controller/cerrarSesion";

$route['calendario-tareas']="calendariotareas_controller";

$route['inicio_contrasenyas']="inicio_contrasenyas_controller";
$route['nueva-contrasenya']="nuevacontrasenya_controller";
$route['crear-nueva-contrasenya'] = "nuevacontrasenya_controller/nuevaContrasenya";

$route['inicio_conocimientos']="inicio_conocimientos_controller";
$route['nuevo-conocimiento']="nuevoconocimiento_controller";
$route['crear-nuevo-conocimiento'] = "nuevoconocimiento_controller/nuevoConocimiento";

$route['mantenimiento_clientes']="mantenimiento_clientes_controller";
$route['mantenimiento_usuarios']="mantenimiento_usuarios_controller";
$route['mantenimiento_etiquetas']="mantenimiento_etiquetas_controller";

$route['prueba']="verconocimiento_controller/prueba";

//inicio_controller
$route['eliminar-tarea/(:num)'] = "inicio_controller/EliminarTarea/$1";
$route['tareas'] = "inicio_controller/MostrarTareas";

//inicio_conocimientos_controller
$route['eliminar-conocimiento/(:num)'] = "inicio_conocimientos_controller/EliminarConocimiento/$1";
$route['conocimientos'] = "inicio_conocimientos_controller/MostrarConocimientos";

//inicio_contrasenyas_controller
$route['eliminar-contrasenya/(:num)'] = "inicio_contrasenyas_controller/EliminarContrasenya/$1";
$route['contrasenyas'] = "inicio_contrasenyas_controller/MostrarContrasenyas";
	
//$route['edad/(:num)'] = 'home/edad/$1';

//vertarea_controller
$route['tarea/(:num)'] = "vertarea_controller/mostrarTarea/$1";

//verconocimiento_controller
$route['conocimiento/(:num)'] = "verconocimiento_controller/mostrarConocimiento/$1";

//vercontrasenya_controller
$route['contrasenya/(:num)'] = "vercontrasenya_controller/mostrarContrasenya/$1";

//nuevaTareController
$route['inicio/correcta']='nuevatarea_controller/irInicio';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */