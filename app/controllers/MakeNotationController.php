<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ GradesModel, StudentsModel, NotationsModel };

class MakeNotationController extends BaseController {
  public function showMakeNotationPage()
  {
    // Obtener todos los grados
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();

    // Renderizar la vista de pedir documento de identidad y grado
    echo $this->twig->render('request-student.twig', [
      'current_template' => 'make-notation',
      'title' => 'Anotación en el Observador',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'success' => $_SESSION['success_msg'] ?? NULL,
      'grades' => $grades
    ]);

    // Limpiar mensaje de éxito
    $_SESSION['success_msg'] = NULL;
  }

  public function makingNotation()
  {
    try {
      // Validar que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Obtener el nombre del grado por el id del grado
      $gradesModelInstance = new GradesModel();
      $grade = $gradesModelInstance->getByIdGrade($_GET['grade']);

      // Verificar que el estudiante exista
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si el estudiante no existe, mostramos mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Pero si existe, mostramos la página de hacer anotaciones
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

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'make-notation',
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
      // Validar que los datos realmente fueron enviados
      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Verificar que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Validar que los datos enviados son correctos
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

      // Verificar si el estudiante está en la base de datos
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si el estudiante no existe, mostramos mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Vamos a crear la anotación en el observador
      $notationsModelInstance = new NotationsModel();
      $newNotation = $notationsModelInstance->create(
        $_GET['_id'],
        $_POST['notation'],
        $_GET['grade'],
        $_POST['testimony']
      );

      // Si la anotación se creo correctamente, mostramos mensaje de éxito
      if ($newNotation) {
        $_SESSION['success_msg'] = "Anotación guardada correctamente";
        
        // Redirigimos a la página de hacer anotaciones
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
    // Validamos que el usuario este logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    /**
     * Si el grade y el _id estan vacios, mostramos la pagina de pedir el grado
     * y el documento de identidad del estudiante
     */
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showMakeNotationPage();
    }

    /**
     * Si el grado y el documento de identidad existen, mostramos la página de hacer
     * anotaciones en el observador
     */
    $this->makingNotation();
  }
}
