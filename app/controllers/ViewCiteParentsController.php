<?php

namespace App\Controllers;

// Importar Modelos
use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, CitationsModel, StudentsModel };

class ViewCiteParentsController extends BaseController
{
  public function showViewCiteParentsPage()
  {
    // Validar si el usuario está logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    // Obtener todos los grados
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();
    
    // Vemos la vista de pedir el grado y el documento de identidad
    echo $this->twig->render('view-cite-parents.twig', [
      'title' => 'Ver citaciones a padres de familia',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'grades' => $grades
    ]);
  }

  public function visualizingCitations()
  {
    try {
      // Validar que el usuario esté logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Validar que el estudiante exista
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si el estudiante no existe, lanzar una excepción
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Obtener todas las citaciones del estudiante
      $citationsModelInstance = new CitationsModel();
      $citationFound = $citationsModelInstance->findCitationsByStudent($_GET['_id']);

      // Mostramos la página de todas las citaciones de ese estudiante
      echo $this->twig->render('visualizing-citations.twig', [
        'title' => 'Ver citaciones a padres de familia en el Observador',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'observerStudent' => $citationFound
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $gradesModelInstance = new GradesModel();
      $grades = $gradesModelInstance->getAllGrades();

      echo $this->twig->render('view-cite-parents.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function viewCitations()
  {
    // Validar que el usuario esté logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    // Si existe el grado y el documento de identidad vemos la página de pedir esos datos
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showViewCiteParentsPage();
    }

    // Si existen entonces vamos a visualizar las citaciones
    $this->visualizingCitations();
  }
}
