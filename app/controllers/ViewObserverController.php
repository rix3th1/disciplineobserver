<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middleware\AuthMiddleware;
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
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      $this->showViewObserverPage();
      return;
    }

    // Si existen, visualizamos las anotaciones
    $this->visualizingObserver();
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

  public function visualizingObserver(): void
  {
    try {
      // Buscamos al estudiante
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si no existe, mostramos un error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }
      
      // Si existe, obtenemos las anotaciones del estudiante
      $notationFound = $this->notationsModelInstance->findNotationsByStudent($_GET['_id']);

      // Renderizar la vista con las anotaciones del estudiante
      echo $this->twig->render('visualizing-observer.twig', [
        'title' => 'Ver Observador del estudiante',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'observerStudent' => $notationFound
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
}
