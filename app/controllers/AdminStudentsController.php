<?php

namespace App\Controllers;

use Exception;
use App\Middlewares\AuthMiddleware;
use App\Models\{
  StudentsModel,
  GradesModel
};

class AdminStudentsController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;
  protected StudentsModel $studentsModelInstance;
  protected GradesModel $gradesModelInstance;

  public function __construct() {
    // Llamamos al constructor del padre
    parent::__construct();

    // Instanciar el modelo de estudiantes
    $this->studentsModelInstance = new StudentsModel;

    // Instanciar el modelo de grados
    $this->gradesModelInstance = new GradesModel;

    // Instanciar el middleware de autenticación
    $this->authMiddlewareInstance = new AuthMiddleware;

    // verificar que el usuario este logueado
    $this->authMiddlewareInstance->handle();
  }

  public function showDashboardStudents(array $data = []): void
  {
    /**
     * Si la petición proviene de make-notation o cite-parents vamos a
     * obtener los estudiantes por grado y lo vamos a manejar de manera
     * diferente.
     */
    if (!empty($_GET["aria_current"])) {
      if ($_GET["aria_current"] === "make-notation" || $_GET["aria_current"] === "cite-parents") {
        if (!empty($_GET['grade'])) {
          // obtener los estudiantes concidentes por grado
          $students = $this->studentsModelInstance->getStudentByGrade($_GET['grade']);
        }
      }
    } else {
      // Sí la búsqueda esta vacía, obtener todos los estudiantes
      if (empty($_GET['search'])) {
        // obtener todos los estudiantes
        $students = $this->studentsModelInstance->getAllStudents();
      }

      // Sí no esta vacía, obtener un estudiante por la búsqueda
      if (!empty($_GET['search'])) {
        // obtener un estudiante por la bésqueda
        $students = $this->studentsModelInstance->getStudentBySearchAdmin($_GET['search']);
      }
    }

    // renderizar el pánel de administración de los estudiantes
    echo $this->twig->render('dashboard-students.twig', array_merge([
      'title' => 'Estudiantes',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'students' => $students,
      'search' => $_GET['search'] ?? '',
      'aria_current_origin' => $_GET['aria_current'] ?? ''
    ], $data));
  }

  public function updateStudent(): void
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

      if (empty($_POST['student'])) {
        throw new Exception('Ingrese los nombres del estudiante');
      }

      if (empty($_POST['grade'])) {
        throw new Exception('Seleccione el grado del estudiante');
      }

      $studentEdited = $this->studentsModelInstance->updateStudent(
        $_POST['_id'],
        $_POST['student'],
        $_POST['grade']
      );

      if ($studentEdited) {
        $this->showEditStudentView([
          'success' => 'Datos actualizados exitosamente'
        ]);
        return;
      }

      throw new Exception("Error al editar los datos del Estudiante");    
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showEditStudentView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function showEditStudentView(array $data = []): void
  {
    $studentData = $this->studentsModelInstance->getByIdStudent($_POST['_id']);
    
    // Obtener todos los grados
    $grades = $this->gradesModelInstance->getAllGrades();

    echo $this->twig->render('edit-student.twig', array_merge([
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'student' => $studentData,
      'grades' => $grades
    ], $data));
  }

  public function showAddStudentView(array $data = []): void
  {
    // Obtener todos los grados
    $grades = $this->gradesModelInstance->getAllGrades();

    echo $this->twig->render('students-register.twig', array_merge([
      'title' => 'Datos Personales - Estudiante',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'grades' => $grades
    ], $data));
  }

  public function addStudent(): void
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
      if (empty($_GET['parent_id'])) {
        throw new Exception("Ingrese el id del padre de familia");
      }

      if (strlen($_GET['parent_id']) < 8 || strlen($_GET['parent_id']) > 10) {
        throw new Exception("El valor del id del padre de familia es incorrecto");
      }

      if (empty($_POST['_id'])) {
        throw new Exception("Ingrese la cédula");  
      }

      if (strlen($_POST['_id']) < 8 || strlen($_POST['_id']) > 10) {
        throw new Exception("El valor de la cédula es incorrecto");
      }

      if (empty($_POST['student'])) {
        throw new Exception('Ingrese los nombres del estudiante');
      }

      if (empty($_POST['grade'])) {
        throw new Exception('Seleccione el grado del estudiante');
      }

      $userFound = $this->studentsModelInstance->getByIdStudent($_POST['_id']);
      
      if ($userFound) {
        throw new Exception("El estudiante ya existe en la base de datos");
      }

      $studentCreated = $this->studentsModelInstance->create(
        $_POST['_id'],
        $_POST['student'],
        $_POST['grade'],
        $_GET['parent_id'],
      );

      if ($studentCreated) {
        $this->showAddStudentView([
          'success' => 'Estudiante guardado exitosamente'
        ]);
        return;
      }

      throw new Exception("Error al guardar los datos del Estudiante");    
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showAddStudentView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function deleteStudent(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $studentDeleted = $this->studentsModelInstance->deleteStudent($_POST['_id']);

      if ($studentDeleted) {
        $this->showDashboardStudents([
          'success' => 'Estudiante eliminado correctamente',
        ]);
        return;
      }

      throw new Exception('Error al eliminar el estudiante');
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showDashboardStudents([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function changeStudentState(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Cast new state and invert it.
      $newState = !(bool) $_POST['is_enabled'];
      $studentUpdated = $this->studentsModelInstance->changeStudentState($_POST['_id'], $newState);

      if ($studentUpdated) {
        $this->showDashboardStudents([
          'success' => 'Estudiante ' . ($newState ? 'habilitado' : 'deshabilitado') . ' correctamente.',
        ]);
        return;
      }

      throw new Exception('Error al cambiar el estado del estudiante');
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showDashboardStudents([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }
}