<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\TeachersModel;

class AdminTeachersController extends RegisterController {
  protected $teachersModelInstance;
  protected $authMiddlewareInstance;

  public function __construct()
  {
    // Llamamos al constructor del padre
    parent::__construct();

    // Instanciar el modelo de profesores
    $this->teachersModelInstance = new TeachersModel();

    // Instanciar el middleware de autenticación
    $this->authMiddlewareInstance = new AuthMiddleware();
  }

  public function showDashboardTeachers($data = [])
  {
    // verificar que el usuario este logueado
    $this->authMiddlewareInstance->handle();

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

    // renderizar la vista home, donde se da la bienvenida
    echo $this->twig->render('dashboard-teachers.twig', array_merge([
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'teachers' => $teachers,
      'search' => $_GET['search'] ?? ''
    ], $data));
  }

  public function updateTeacher()
  {
    try {
      // verificar que el usuario este logueado
      $this->authMiddlewareInstance->handle();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $teacherCreated = $this->teachersModelInstance->updateTeacher(
        $_POST['_id'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['telephone'],
        $_POST['email']
      );

      if ($teacherCreated) {
        return $this->showEditTeacherView([
          'success' => 'Datos actualizados exitosamente'
        ]);
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

  public function showEditTeacherView($data = [])
  {
    $teacherData = $this->teachersModelInstance->getTeacherById($_POST['_id']);

    echo $this->twig->render('edit-teacher.twig', array_merge([
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'teacher' => $teacherData
    ], $data));
  }

  public function showAddTeacherView()
  {
    // verificar que el usuario este logueado
    $this->authMiddlewareInstance->handle();

    $this->showAskDataView([
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }

  public function deleteTeacher()
  {
    try {
      // verificar que el usuario este logueado
      $this->authMiddlewareInstance->handle();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $teacherDeleted = $this->teachersModelInstance->deleteTeacher($_POST['_id']);

      if ($teacherDeleted) {
        return $this->showDashboardTeachers([
          'success' => 'Profesor eliminado correctamente',
        ]);
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