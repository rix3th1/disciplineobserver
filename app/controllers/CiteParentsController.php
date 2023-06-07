<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use Datetime;
use App\Middleware\AuthMiddleware;
use App\Models\{
  GradesModel,
  StudentsModel,
  NotationsModel,
  CitationsModel,
  EmailSenderModel
};

class CiteParentsController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;
  protected GradesModel $gradesModelInstance;
  protected StudentsModel $studentsModelInstance;
  protected NotationsModel $notationsModelInstance;
  protected CitationsModel $citationsModelInstance;
  protected EmailSenderModel $emailSenderModelInstance;

  public function __construct()
  {
    // Llamar al constructor del padre
    parent::__construct();

    // Instanciar los modelos
    $this->authMiddlewareInstance = new AuthMiddleware;
    $this->gradesModelInstance = new GradesModel;
    $this->studentsModelInstance = new StudentsModel;
    $this->notationsModelInstance = new NotationsModel;
    $this->citationsModelInstance = new CitationsModel;
    $this->emailSenderModelInstance = new EmailSenderModel;

    // Validar que el usuario este logueado
    $this->authMiddlewareInstance->handle();
  }

  public function citeParents(): void
  {
    /**
     * Si no existe el grado y el documento de identidad en la petición mostrar
     * la página de pedir el documento de identidad y el grado para hacer la
     * citación a los padres de familia
     */
    if (empty($_GET['grade']) && empty($_GET['search'])) {
      $this->showCiteParentsPage();
      return;
    }

    /**
     * Si existe el grado y el documento de identidad en la petición mostrar la pagina de hacer citaciones a padres de familia
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
        'current_template' => 'cite-parents',
        'title' => 'Citación de padre de familia',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'studentsFound' => $studentFound,
        'grade' => $_GET['grade']
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'cite-parents',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }
  
  public function showCiteParentsPage(): void
  {
    // Obtener todos los grados, con su _id y nombre
    $grades = $this->gradesModelInstance->getAllGrades();

    // Renderizar la vista de pedir documento de identidad y grado
    echo $this->twig->render('request-student.twig', [
      'current_template' => 'cite-parents',
      'title' => 'Citación de padre de familia',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'success' => $_SESSION['success_msg'] ?? NULL,
      'grades' => $grades
    ]);

    // Limpiar mensaje de exito, cuando se vuelva a mostrar la página
    $_SESSION['success_msg'] = NULL;
  }

  public function citingParents(): void
  {
    try {
      // Obtener el nombre del grado ingresado por el usuario
      $grade = $this->gradesModelInstance->getByIdGrade($_GET['grade']);

      // Verificar si el estudiante esta registrado en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

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
        '_id' => $studentFound->_id
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $grades = $this->gradesModelInstance->getAllGrades();

      echo $this->twig->render('request-student.twig', [
        'current_template' => 'cite-parents',
        'title' => 'Error',
        'userLogged' => $_SESSION['user_discipline_observer'],
        'error' => $error,
        'grades' => $grades
      ]);
    }
  }

  public function saveCitation(): void
  {
    try {
      // Validar que los datos si fueron enviados
      if (!$_POST || !$_GET) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

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

      if (empty($_POST['citation_date'])) {
        throw new Exception('Ingrese la fecha de la citación');
      }

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      // Validar que el estudiante exista en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      if ($_POST['email'] !== $studentFound->email_parent) {
        throw new Exception("El correo del padre de familia no coincide con el ingresado en la citación");
      }

      // El estudiante no fue encontrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador");
      }

      // Crear la anotación en el observador
      $newNotation = $this->notationsModelInstance->create(
        $studentFound->_id,
        $_POST['notation'],
        $_GET['grade'],
        $_POST['testimony']
      );

      // Crear la citación para el padre de familia
      $newCitation = $this->citationsModelInstance->create(
        $studentFound->_id,
        $_POST['citation_date'],
        $_POST['notice'],
        $_POST['email']
      );

      $citationDate = new Datetime($_POST['citation_date']);

      // Enviar correo al padre de familia
      $citationSended = $this->emailSenderModelInstance->sendEmail(
        'Citación padre de familia - Alumno ' . $_POST['student'] . ' Grado ' . $_GET['grade'] . ' San José Obrero, Espinal - Tolima, Discipline Observer',
        $_POST['email'],
        $_POST['notice'] . "<br><strong>Fecha de citación: " . $citationDate->format('Y-m-d') . " a las " . $citationDate->format('H:i') . "</strong>."
      );

      // Si no se creo la notación o la citación, mostrar mensaje de error
      if (!$newNotation || !$newCitation || !$citationSended) {
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
}
