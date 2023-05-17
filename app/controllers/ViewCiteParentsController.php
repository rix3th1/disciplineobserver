<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, CitationsModel };

class ViewCiteParentsController extends BaseController
{
  public function showViewCiteParentsPage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];

    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();
    
    echo $this->twig->render('view-cite-parents.twig', [
      'title' => 'Ver citaciones a padres de familia',
      'permissions' => $userLogged['permissions'],
      'grades' => $grades
    ]);
  }

  public function visualizingCitations()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];

    $citationsModelInstance = new CitationsModel();
    $citationFound = $citationsModelInstance->findCitationsByStudent($_GET['_id']);

    echo $this->twig->render('visualizing-citations.twig', [
      'title' => 'Ver citaciones a padres de familia en el Observador',
      'permissions' => $userLogged['permissions'],
      'observerStudent' => $citationFound
    ]);
  }

  public function viewCitations()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showViewCiteParentsPage();
    }

    $this->visualizingCitations();
  }
}
