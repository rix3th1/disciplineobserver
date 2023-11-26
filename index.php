<?php

// Definimos que el codigo se ejecute en modo estricto
declare(strict_types=1);

// Requerimos el autoload de composer
require_once __DIR__ . '/vendor/autoload.php';

// Importamos las variables de entorno y el Enrutador
use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;

// Crear una instancia del contenedor de enrutamiento
$routerContainer = new RouterContainer();

// Obtenemos el mapa de rutas
$map = $routerContainer->getMap();


/**
 * Aquí comienza la definición de las rutas.
 */

// Ruta get para el login
$map->get('login.page', '/', [
  'App\Controllers\AuthController',
  'showLoginPage'
]);

// Ruta post para autenticar al usuario
$map->post('login.auth', '/auth', [
  'App\Controllers\AuthController',
  'authenticate'
]);

// Ruta post para cerrar sesión
$map->post('login.out', '/salir', [
  'App\Controllers\AuthController',
  'logOut'
]);

// Ruta get para el registro de datos personales al crear una cuenta
$map->get('register.askdata', '/registro/datos-personales', [
  'App\Controllers\RegisterController',
  'showAskDataView'
]);

// Ruta get para completar el formulario de crear una cuenta
$map->get('register.requestData', '/registrarme', [
  'App\Controllers\RegisterController',
  'showRequestDataView'
]);

// Ruta post para crear una cuenta
$map->post('register.register', '/registrarme', [
  'App\Controllers\RegisterController',
  'register'
]);

// Ruta get para ver la página principal
$map->get('home.welcome', '/inicio', [
  'App\Controllers\HomeController',
  'showHomePage'
]);

// Ruta get para hacer anotaciones en el observador
$map->get('make.notation', '/hacer/anotaciones', [
  'App\Controllers\MakeNotationController',
  'makeNotation'
]);

// Ruta get para hacer las anotaciones del observador
$map->get('making.notation', '/make-notation', [
  'App\Controllers\MakeNotationController',
  'makingNotation'
]);

// Ruta post para guardar las anotaciones del observador
$map->post('save.notation', '/make-notation', [
  'App\Controllers\MakeNotationController',
  'saveNotation'
]);

// Ruta get para hacer las citaciones de los padres
$map->get('make.citation', '/citacion/padres', [
  'App\Controllers\CiteParentsController',
  'citeParents'
]);

// Ruta get para hacer las citaciones de los padres
$map->get('making.citation', '/cite-parents', [
  'App\Controllers\CiteParentsController',
  'citingParents'
]);

// Ruta post para guardar las citaciones de los padres
$map->post('save.citation', '/cite-parents', [
  'App\Controllers\CiteParentsController',
  'saveCitation'
]);

// Ruta get para ver las citaciones de los padres
$map->get('view.cite.parents', '/ver/citacion/padres', [
  'App\Controllers\ViewCiteParentsController',
  'viewCitations'
]);

// Ruta get para ver las citaciones de los padres
$map->get('visualizing.cite.parents', '/view-cite-parents', [
  'App\Controllers\ViewCiteParentsController',
  'visualizingCitations'
]);

// Ruta get para ver las anotaciones del observador
$map->get('view.observer', '/ver/observador', [
  'App\Controllers\ViewObserverController',
  'viewObserver'
]);

// Ruta get para ver las anotaciones del observador
$map->get('visualizing.observer', '/view-observer', [
  'App\Controllers\ViewObserverController',
  'visualizingObserver'
]);

// Ruta post para eliminar las anotaciones del observador
$map->post('visualizing.observer.delete.notation', '/ver/observador/eliminar/anotacion', [
  'App\Controllers\ViewObserverController',
  'deleteNotation'
]);

// Ruta get para ver la página de cambiar contraseña
$map->get('passsword.change.page', '/cambiar/contrasena', [
  'App\Controllers\UserController',
  'changePassword'
]);

// Ruta post para cambiar la contraseña
$map->post('passsword.change', '/cambiar/contrasena', [
  'App\Controllers\UserController',
  'updatingPassword'
]);

// Ruta post para el codigo de verificación al cambiar la contraseña
$map->post('password.verification.code', '/verificar/codigo', [
  'App\Controllers\UserController',
  'verifyVerificationCode'
]);

// Ruta get para administrar a los profesores del colegio
$map->get('admin.teachers', '/administrar/profesores', [
  'App\Controllers\AdminTeachersController',
  'showDashboardTeachers'
]);

// Ruta get para administrar a los alumnos del colegio
$map->get('admin.students', '/administrar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'showDashboardStudents'
]);

// Ruta get para administrar a los padres de familia del colegio
$map->get('admin.parents', '/administrar/padres-de-familia', [
  'App\Controllers\AdminParentsController',
  'showDashboardParents'
]);

// Ruta get para agregar a los profesores
$map->get('admin.teachers.add', '/administrar/agregar/profesores', [
  'App\Controllers\AdminTeachersController',
  'showAddTeacherView'
]);

// Ruta get para agregar a los alumnos del colegio
$map->get('admin.students.add', '/administrar/agregar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'showAddStudentView'
]);

// Ruta get para agregar a los padres de familia del colegio
$map->get('admin.parents.add', '/administrar/agregar/padres-de-familia', [
  'App\Controllers\AdminParentsController',
  'showAddParentsView'
]);

// Ruta get para guardar a los alumnos del colegio
$map->post('admin.students.create', '/administrar/agregar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'addStudent'
]);

$map->post('admin.teachers.edit', '/administrar/editar/profesores', [
  'App\Controllers\AdminTeachersController',
  'showEditTeacherView'
]);

$map->post('admin.students.edit', '/administrar/editar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'showEditStudentView'
]);

$map->post('admin.parents.edit', '/administrar/editar/padres-de-familia', [
  'App\Controllers\AdminParentsController',
  'showEditParentsView'
]);

$map->post('admin.teachers.update', '/administrar/actualizar/profesores', [
  'App\Controllers\AdminTeachersController',
  'updateTeacher'
]);

$map->post('admin.students.update', '/administrar/actualizar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'updateStudent'
]);

$map->post('admin.parents.update', '/administrar/actualizar/padres-de-familia', [
  'App\Controllers\AdminParentsController',
  'updateParent'
]);

$map->post('admin.teachers.delete', '/administrar/eliminar/profesores', [
  'App\Controllers\AdminTeachersController',
  'deleteTeacher'
]);

$map->post('admin.students.delete', '/administrar/eliminar/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'deleteStudent'
]);

$map->post('admin.students.change-state', '/administrar/cambiar-estado/estudiantes', [
  'App\Controllers\AdminStudentsController',
  'changeStudentState'
]);

$map->post('admin.parents.delete', '/administrar/eliminar/padres-de-familia', [
  'App\Controllers\AdminParentsController',
  'deleteParent'
]);

$map->get('help', '/ayuda', [
  'App\Controllers\HelpController',
  'showHelpPage'
]);

// Obtener la ruta coincidente de las variables globales
$route = $routerContainer->getMatcher()->match(
  // Obtener las variables globales
  ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
  )
);

// Ejecutar la acción de la ruta coincidente
if ($route) {
  // Obtener el manejador de la ruta
  $handler = $route->handler;
  
  // Separar el nombre de la clase y el método
  list($controller, $method) = $handler;

  // Crear una instancia de la clase controladora
  $controllerInstance = new $controller();

  // Ejecutar el método de la clase controladora y terminar la ejecución
  $controllerInstance->$method();
} else {
  // Instanciamos la clase de controlador de página no encontrada
  $notFoundController = new App\Controllers\PageNotFoundController();

  // Mostramos la página de página no encontrada
  $notFoundController->showNotFoundPage();
}
