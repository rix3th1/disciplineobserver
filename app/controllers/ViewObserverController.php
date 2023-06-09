<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middlewares\AuthMiddleware;
use App\Models\{
  GradesModel,
  NotationsModel,
  StudentsModel
};

class ViewObserverController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;
  protected GradesModel $gradesModelInstance;
  protected NotationsModel $notationsModelInstance;
  protected StudentsModel $studentsModelInstance;

  public function __construct()
  {
    // Llamamos al constructor del padre
    parent::__construct();

    // Instanciar los modelos
    $this->authMiddlewareInstance = new AuthMiddleware;
    $this->gradesModelInstance = new GradesModel;
    $this->notationsModelInstance = new NotationsModel;
    $this->studentsModelInstance = new StudentsModel;

    // Validar que el usuario esté logueado
    $this->authMiddlewareInstance->handle();
  }
  public function viewObserver(): void
  {
    // Si no existen estos datos, los pedimos
    if (empty($_GET['grade']) && empty($_GET['search'])) {
      $this->showViewObserverPage();
      return;
    }

    // Si existen, visualizamos las anotaciones
    $this->showSelectStudentsPage();
  }

  public function showSelectStudentsPage(): void
  {
    try {
      // Verificar si el estudiante esta registrado en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getStudentByDocumentOrName($_GET['search']);

      // Si no esta registrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Renderizar la vista de seleccionar estudiante
      echo $this->twig->render('select-student.twig', [
        'current_template' => 'view-observer',
        'title' => 'Ver Observador',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'studentsFound' => $studentFound,
        'grade' => $_GET['grade']
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'view-observer',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }
  
  public function showViewObserverPage(): void
  {
    // Obtener todos los grados
    $grades = $this->gradesModelInstance->getAllGrades();
    
    // Mostrar la vista de pedir el grado y el documento del estudiante
    echo $this->twig->render('request-student.twig', [
      'current_template' => 'view-observer',
      'title' => 'Ver Observador',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'grades' => $grades
    ]);
  }

  public function deleteNotation(): void
  {
    $notationDeleted = $this->notationsModelInstance->delete($_POST['_id'], $_POST['created_at']);

    if ($notationDeleted) {
      $_SESSION['success_msg'] = 'La anotación fue eliminada correctamente';
      echo "<script>window.location.href=document.referrer;</script>";
    }
  }

  public function visualizingObserver(): void
  {
    try {
      // Validar que los datos realmente fueron enviados
      if (empty($_GET['grade'])) {
        throw new Exception('Ingrese el grado del estudiante');
      }

      if (empty($_GET['_id'])) {
        throw new Exception('Ingrese el número de documento del estudiante');
      }
      
      // Buscamos al estudiante
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si no existe, mostramos un error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }
      
      // Si existe, obtenemos las anotaciones del estudiante
      $notationFound = $this->notationsModelInstance->findNotationsByStudent($studentFound->_id);

      // Renderizar la vista con las anotaciones del estudiante
      echo $this->twig->render('visualizing-observer.twig', [
        'title' => 'Ver Observador del estudiante',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'observerStudent' => $notationFound,
        'success' => $_SESSION['success_msg'] ?? null
      ]);

      $_SESSION['success_msg'] = null;
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'view-observer',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }
}
