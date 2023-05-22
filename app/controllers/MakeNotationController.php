<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, StudentsModel, NotationsModel };

class MakeNotationController extends BaseController
{
  public function showMakeNotationPage()
  {
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();

    echo $this->twig->render('make-notation.twig', [
      'title' => 'Hacer anotaciones en el observador',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'success' => $_SESSION['success_msg'] ?? NULL,
      'grades' => $grades
    ]);
    $_SESSION['success_msg'] = NULL;
  }

  public function makingNotation()
  {
    try {
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      $gradesModelInstance = new GradesModel();
      $grade = $gradesModelInstance->getByIdGrade($_GET['grade']);

      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      echo $this->twig->render('making-notation.twig', [
        'title' => 'Anotación en el Observador',
        'userLogged' => $_SESSION['user_discipline_observer'],
        '_studentInfo' => $studentFound->student . ' de ' . $grade->grade . ' grado',
        '_id' => $_GET['_id']
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $gradesModelInstance = new GradesModel();
      $grades = $gradesModelInstance->getAllGrades();

      echo $this->twig->render('make-notation.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function saveNotation()
  {
    try {
      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

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
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
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

      echo $this->twig->render('making-notation.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
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
