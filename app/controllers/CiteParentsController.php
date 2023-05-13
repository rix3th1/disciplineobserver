<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Models\GradesModel;

class CiteParentsController extends BaseController
{
  public function showCiteParentsPage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();

    echo $this->twig->render('cite-parents.twig', [
      'title' => 'Citar padres de familia',
      'permissions' => $userLogged['permissions'],
      'grades' => $grades
    ]);
  }

  public function citingParents()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    $gradesModelInstance = new GradesModel();
    $grade = $gradesModelInstance->getByIdGrade($_GET['grade']);

    echo $this->twig->render('citing-parents.twig', [
      'title' => 'Citación de padres de familia',
      'permissions' => $userLogged['permissions'],
      '_studentInfo' => '[Nombre del estudiante] de ' . $grade->grade . ' grado',
      '_id' => $_GET['_id']
    ]);
  }

  public function citeParents()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showCiteParentsPage();
    }

    $this->citingParents();
  }
}
