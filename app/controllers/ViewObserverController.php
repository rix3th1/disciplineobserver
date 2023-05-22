<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, NotationsModel, StudentsModel };

class ViewObserverController extends BaseController
{
  public function showViewObserverPage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();
    
    echo $this->twig->render('view-observer.twig', [
      'title' => 'Ver observador',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'grades' => $grades
    ]);
  }

  public function visualizingObserver()
  {
    try {
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }
      
      $notationsModelInstance = new NotationsModel();
      $notationFound = $notationsModelInstance->findNotationsByStudent($_GET['_id']);

      echo $this->twig->render('visualizing-observer.twig', [
        'title' => 'Ver Observador del estudiante',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'observerStudent' => $notationFound
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $gradesModelInstance = new GradesModel();
      $grades = $gradesModelInstance->getAllGrades();

      echo $this->twig->render('view-observer.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function viewObserver()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showViewObserverPage();
    }

    $this->visualizingObserver();
  }
}
