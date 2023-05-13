<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, NotationsModel };

class ViewObserverController extends BaseController
{
  public function showViewObserverPage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];

    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();
    
    echo $this->twig->render('view-observer.twig', [
      'title' => 'Ver observador',
      'permissions' => $userLogged['permissions'],
      'grades' => $grades
    ]);
  }

  public function visualizingObserver()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    
    $notationsModelInstance = new NotationsModel();
    $notationFound = $notationsModelInstance->findNotationsByStudent($_GET['_id']);

    echo $this->twig->render('visualizing-observer.twig', [
      'title' => 'Ver Observador del estudiante',
      'permissions' => $userLogged['permissions'],
      'observerStudent' => $notationFound
    ]);
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
