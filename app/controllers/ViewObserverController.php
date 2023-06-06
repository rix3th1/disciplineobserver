<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, NotationsModel, StudentsModel };

class ViewObserverController extends BaseController {
  public function showViewObserverPage()
  {
    // Validar que el usuario esté logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    // Obtener todos los grados
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();
    
    // Mostrar la vista de pedir el grado y el documento del estudiante
    echo $this->twig->render('request-student.twig', [
      'current_template' => 'view-observer',
      'title' => 'Ver Observador',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'grades' => $grades
    ]);
  }

  public function visualizingObserver()
  {
    try {
      // Validar que el usuario esté logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Buscamos al estudiante
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si no existe, mostramos un error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }
      
      // Si existe, obtenemos las anotaciones del estudiante
      $notationsModelInstance = new NotationsModel();
      $notationFound = $notationsModelInstance->findNotationsByStudent($_GET['_id']);

      // Renderizar la vista con las anotaciones del estudiante
      echo $this->twig->render('visualizing-observer.twig', [
        'title' => 'Ver Observador del estudiante',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'observerStudent' => $notationFound
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $gradesModelInstance = new GradesModel();
      $grades = $gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'view-observer',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function viewObserver()
  {
    // Validar que el usuario esté logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    // Si no existen estos datos, los pedimos
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showViewObserverPage();
    }

    // Si existen, visualizamos las anotaciones
    $this->visualizingObserver();
  }
}
