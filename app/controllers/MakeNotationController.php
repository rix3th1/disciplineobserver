<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middlewares\AuthMiddleware;
use App\Models\{
  GradesModel,
  StudentsModel,
  NotationsModel
};

class MakeNotationController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;
  protected GradesModel $gradesModelInstance;
  protected StudentsModel $studentsModelInstance;
  protected NotationsModel $notationsModelInstance;

  public function __construct()
  {
    // Llamar al constructor del padre
    parent::__construct();

    // Instanciar modelos
    $this->authMiddlewareInstance = new AuthMiddleware;
    $this->gradesModelInstance = new GradesModel;
    $this->studentsModelInstance = new StudentsModel;
    $this->notationsModelInstance = new NotationsModel;

    // Validamos que el usuario este logueado
    $this->authMiddlewareInstance->handle();
  }

  public function makeNotation(): void
  {
    /**
     * Si el grade y el _id estan vacios, mostramos la pagina de pedir el grado
     * y el documento de identidad del estudiante
     */
    if (empty($_GET['grade']) && empty($_GET['search'])) {
      $this->showMakeNotationPage();
      return;
    }

    /**
     * Si el grado y el documento de identidad existen, mostramos la página de hacer
     * anotaciones en el observador
     */
    $this->showSelectStudentsPage();
  }

  public function showSelectStudentsPage(): void
  {
    try {
      // Verificar si el estudiante esta registrado en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getStudentByDocumentOrName($_GET['search']);

      // Si no esta registrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Renderizar la vista de seleccionar estudiante
      echo $this->twig->render('select-student.twig', [
        'current_template' => 'make-notation',
        'title' => 'Anotación en el Observador',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'studentsFound' => $studentFound,
        'grade' => $_GET['grade']
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'make-notation',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }
  
  public function showMakeNotationPage(): void
  {
    // Obtener todos los grados
    $grades = $this->gradesModelInstance->getAllGrades();

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

  public function makingNotation(): void
  {
    try {
      // Validar que los datos realmente fueron enviados
      if (empty($_GET['grade'])) {
        throw new Exception('Ingrese el grado del estudiante');
      }

      if (empty($_GET['_id'])) {
        throw new Exception('Ingrese el número de documento del estudiante');
      }

      // Obtener el nombre del grado por el id del grado
      $grade = $this->gradesModelInstance->getByIdGrade($_GET['grade']);

      // Verificar que el estudiante exista
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si el estudiante no existe, mostramos mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Pero si existe, mostramos la página de hacer anotaciones
      echo $this->twig->render('making-notation.twig', [
        'title' => 'Anotación en el Observador',
        'userLogged' => $_SESSION['user_discipline_observer'],
        '_studentInfo' => $studentFound->student . ' de ' . $grade->grade . ' grado',
        '_id' => $studentFound->_id
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'make-notation',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function saveNotation(): void
  {
    try {
      // Validar que los datos realmente fueron enviados
      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

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
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si el estudiante no existe, mostramos mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Vamos a crear la anotación en el observador
      $newNotation = $this->notationsModelInstance->create(
        $studentFound->_id,
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
}
