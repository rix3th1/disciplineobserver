<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, StudentsModel, NotationsModel };

class MakeNotationController extends BaseController
{
  public function showMakeNotationPage()
  {
    $userLogged = $_SESSION['user_discipline_observer'];
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();

    echo $this->twig->render('make-notation.twig', [
      'title' => 'Hacer anotaciones en el observador',
      'permissions' => $userLogged['permissions'],
      'success' => $_SESSION['success_msg'] ?? NULL,
      'grades' => $grades
    ]);
    $_SESSION['success_msg'] = NULL;
  }

  public function makingNotation()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    $gradesModelInstance = new GradesModel();
    $grade = $gradesModelInstance->getByIdGrade($_GET['grade']);

    echo $this->twig->render('making-notation.twig', [
      'title' => 'Anotación en el Observador',
      'permissions' => $userLogged['permissions'],
      '_studentInfo' => '[Nombre del estudiante] de ' . $grade->grade . ' grado',
      '_id' => $_GET['_id']
    ]);
  }

  public function saveNotation()
  {
    try {
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      if (empty($_GET['_id'])) {
        throw new Exception('Ingrese el número de documento del estudiante');
      }

      if (empty($_POST['notation'])) {
        throw new Exception('Ingrese la anotación del estudiante al observador');
      }

      if (empty($_POST['student'])) {
        throw new Exception('Ingrese el nombre del estudiante');
      }

      if (empty($_POST['testimony'])) {
        throw new Exception('Ingrese el testimonio del estudiante');
      }

      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      if (!$studentFound) {
        $newStudent = $studentsModelInstance->create($_GET['_id'], $_POST['student']);
      }

      $notationsModelInstance = new NotationsModel();
      $newNotation = $notationsModelInstance->create(
        $_GET['_id'],
        $_POST['notation'],
        $_GET['grade'],
        $_POST['testimony']
      );

      if ($newNotation) {
        $_SESSION['success_msg'] = "Anotación guardada correctamente";
        header('Location: /hacer/anotaciones');
      }

    } catch (Exception $e) {
      $error = $e->getMessage();
      $userLogged = $_SESSION['user_discipline_observer'];

      echo $this->twig->render('making-notation.twig', [
        'title' => 'Error',
        'permissions' => $userLogged['permissions'],
        'error' => $error,
      ]);
    }
  }

  public function makeNotation()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showMakeNotationPage();
    }

    $this->makingNotation();
  }
}
