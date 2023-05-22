<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{
  GradesModel,
  StudentsModel,
  NotationsModel,
  CitationsModel,
  EmailSenderModel
};

class CiteParentsController extends BaseController
{
  public function showCiteParentsPage()
  {
    // Validar que el usuario este logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    // Obtener todos los grados, con su _id y nombre
    $gradesModelInstance = new GradesModel();
    $grades = $gradesModelInstance->getAllGrades();

    // Renderizar la vista de pedir documento de identidad y grado
    echo $this->twig->render('cite-parents.twig', [
      'title' => 'Citar padres de familia',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'success' => $_SESSION['success_msg'] ?? NULL,
      'grades' => $grades
    ]);

    // Limpiar mensaje de exito, cuando se vuelva a mostrar la página
    $_SESSION['success_msg'] = NULL;
  }

  public function citingParents()
  {
    try {
      // Validar que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Obtener el nombre del grado ingresado por el usuario
      $gradesModelInstance = new GradesModel();
      $grade = $gradesModelInstance->getByIdGrade($_GET['grade']);

      // Verificar si el estudiante esta registrado en la base de datos del observador
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si no esta registrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Si el estudiante existe en la base de datos, mostrar la página de citación
      echo $this->twig->render('citing-parents.twig', [
        'title' => 'Citación de padres de familia',
        'userLogged' => $_SESSION['user_discipline_observer'],
        '_studentInfo' => $studentFound->student . ' de ' . $grade->grade . ' grado',
        '_emailParent' => $studentFound->email_parent,
        '_nameParent' => $studentFound->name_parent,
        '_id' => $_GET['_id']
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $gradesModelInstance = new GradesModel();
      $grades = $gradesModelInstance->getAllGrades();

      echo $this->twig->render('cite-parents.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function saveCitation()
  {
    try {
      // Validar que los datos si fueron enviados
      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Validar que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();

      // Validar que los datos enviados sean correctos
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

      if (empty($_POST['notice'])) {
        throw new Exception('Ingrese el aviso al padre de familia');
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo del padre de familia');
      }

      // Validar que el estudiante exista en la base de datos del observador
      $studentsModelInstance = new StudentsModel();
      $studentFound = $studentsModelInstance->getByIdStudent($_GET['_id']);

      // El estudiante no fue encontrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Crear la anotación en el observador
      $notationsModelInstance = new NotationsModel();
      $newNotation = $notationsModelInstance->create(
        $_GET['_id'],
        $_POST['notation'],
        $_GET['grade'],
        $_POST['testimony']
      );

      // Crear la citación para el padre de familia
      $citationsModelInstance = new CitationsModel();
      $newCitation = $citationsModelInstance->create(
        $_GET['_id'],
        $_POST['notice'],
        $_POST['email']
      );

      // Enviar correo al padre de familia
      $emailSenderModelInstance = new EmailSenderModel();
      $citacionSended = $emailSenderModelInstance->sendEmail(
        'Citación padre de familia - Alumno ' . $_POST['student'] . ' Grado ' . $_GET['grade'] . ' San José Obrero, Espinal - Tolima, Discipline Observer',
        $_POST['email'],
        $_POST['notice']
      );

      // Si no se creo la notación o la citación, mostrar mensaje de error
      if (!$newNotation && !$newCitation && !$citacionSended) {
        throw new Exception('Ocurrió un error al enviar la citacion a ' . $_POST['email']);
      }
      
      // Mostrar mensaje de exito, ya que todo salio correctamente
      $_SESSION['success_msg'] = 'Citación enviada a ' . $_POST['email'];

      //  Redireccionar a la pagina de citacion de padres
      header('Location: /citacion/padres');

    } catch (Exception $e) {
      $error = $e->getMessage();

      echo $this->twig->render('citing-parents.twig', [
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
      ]);
    }
  }

  public function citeParents()
  {
    // Validar si el usuario está logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();

    /**
     * Si no existe el grado y el documento de identidad en la petición mostrar
     * la página de pedir el documento de identidad y el grado para hacer la
     * citación a los padres de familia
     */
    if (empty($_GET['grade']) && empty($_GET['_id'])) {
      return $this->showCiteParentsPage();
    }

    /**
     * Si existe el grado y el documento de identidad en la petición mostrar la pagina de hacer citaciones a padres de familia
     */
    $this->citingParents();
  }
}
