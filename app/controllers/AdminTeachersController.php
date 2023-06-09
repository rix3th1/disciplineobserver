<?php

namespace App\Controllers;

use Exception;
use App\Middlewares\AuthMiddleware;
use App\Models\TeachersModel;

class AdminTeachersController extends RegisterController {
  protected TeachersModel $teachersModelInstance;
  protected AuthMiddleware $authMiddlewareInstance;

  public function __construct()
  {
    // Llamamos al constructor del padre
    parent::__construct();

    // Instanciar el modelo de profesores
    $this->teachersModelInstance = new TeachersModel();

    // Instanciar el middleware de autenticación
    $this->authMiddlewareInstance = new AuthMiddleware();

    // verificar que el usuario este logueado
    $this->authMiddlewareInstance->handle();
  }

  public function showDashboardTeachers(array $data = []): void
  {
    // Sí la búsqueda esta vacía, obtener todos los profesores
    if (empty($_GET['search'])) {
      // obtener todos los profesores
      $teachers = $this->teachersModelInstance->getAllTeachers();
    }

    // Sí no esta vacía, obtener un profesor por la búsqueda
    if (!empty($_GET['search'])) {
      // obtener un profesor por la bésqueda
      $teachers = $this->teachersModelInstance->getTeacherBySearch($_GET['search']);
    }

    // renderizar el pánel de administración de los profesores
    echo $this->twig->render('dashboard-teachers.twig', array_merge([
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'teachers' => $teachers,
      'search' => $_GET['search'] ?? ''
    ], $data));
  }

  public function updateTeacher(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Validamos que los datos sean correctos
      if (empty($_POST['_id'])) {
        throw new Exception("Ingrese la cédula");  
      }

      if (strlen($_POST['_id']) < 8 || strlen($_POST['_id']) > 10) {
        throw new Exception("El valor de la cédula es incorrecto");
      }

      if (empty($_POST['name'])) {
        throw new Exception('Ingrese los nombres');
      }

      if (empty($_POST['lastname'])) {
        throw new Exception('Ingrese los apellidos');
      }

      if (empty($_POST['telephone'])) {
        throw new Exception('Ingrese el teléfono');
      }

      if (strlen($_POST['telephone']) !== 10) {
        throw new Exception("El número de telefono debe tener 10 dígitos");
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      $teacherEdited = $this->teachersModelInstance->updateTeacher(
        $_POST['_id'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['telephone'],
        $_POST['email']
      );

      if ($teacherEdited) {
        $this->showEditTeacherView([
          'success' => 'Datos actualizados exitosamente'
        ]);
        return;
      }

      throw new Exception("Error al editar los datos del Docente");    
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showEditTeacherView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function showEditTeacherView(array $data = []): void
  {
    $teacherData = $this->teachersModelInstance->getTeacherById($_POST['_id']);

    echo $this->twig->render('edit-teacher.twig', array_merge([
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'teacher' => $teacherData
    ], $data));
  }

  public function showAddTeacherView(): void
  {
    $_SESSION['temporarily_roles'] = [
      [
        "_id" => "teacher",
        "role" => "Docente",
      ]
    ];

    $_SESSION['temporarily_data_create_user'] = [
      'permissions' => ['admin', 'teachers'],
      'path_redirect' => 'profesores'
    ];

    $this->showAskDataView([
      'userLogged' => $_SESSION['user_discipline_observer'],
      'current_admin_action' => $_SESSION['temporarily_data_create_user']['permissions']
    ]);
  }

  public function deleteTeacher(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $teacherDeleted = $this->teachersModelInstance->deleteTeacher($_POST['_id']);

      if ($teacherDeleted) {
        $this->showDashboardTeachers([
          'success' => 'Profesor eliminado correctamente',
        ]);
        return;
      }

      throw new Exception('Error al eliminar el profesor');
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showDashboardTeachers([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }
}