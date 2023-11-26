<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use Datetime;
use App\Middlewares\AuthMiddleware;
use App\Models\{
  GradesModel,
  StudentsModel,
  NotationsModel,
  CitationsModel,
  SubjectModel,
  EmailSenderModel
};

class CiteParentsController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;
  protected GradesModel $gradesModelInstance;
  protected StudentsModel $studentsModelInstance;
  protected NotationsModel $notationsModelInstance;
  protected CitationsModel $citationsModelInstance;
  protected EmailSenderModel $emailSenderModelInstance;
  protected SubjectModel $subjectModelInstance;

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
    $this->subjectModelInstance = new SubjectModel;

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
    header(sprintf('Location: /administrar/estudiantes?grade=%s&aria_current=%s', urlencode($_GET['grade']), urlencode("cite-parents")));
    exit;
    // try {
    //   // Verificar si el estudiante esta registrado en la base de datos del observador
    //   $studentFound = $this->studentsModelInstance->getStudentEnabledByDocumentOrName($_GET['search']);

    //   // Si no esta registrado, mostrar mensaje de error
    //   if (!$studentFound) {
    //     throw new Exception("El estudiante no fué encontrado en la base de datos del observador o ha sido deshabilitado.");
    //   }

    //   // Renderizar la vista de seleccionar estudiante
    //   echo $this->twig->render('select-student.twig', [
    //     'current_template' => 'cite-parents',
    //     'title' => 'Citación de padre de familia',
    //     'userLogged' => $_SESSION['user_discipline_observer'],
    //     'studentsFound' => $studentFound,
    //     'grade' => $_GET['grade']
    //   ]);
    // } catch (Exception $e) {
    //   $error = $e->getMessage();
    //   $grades = $this->gradesModelInstance->getAllGrades();

    //   echo $this->twig->render('request-student.twig', [
    //     'current_template' => 'cite-parents',
    //     'title' => 'Error',
    //     'userLogged' => $_SESSION['user_discipline_observer'],
    //     'error' => $error,
    //     'grades' => $grades
    //   ]);
    // }
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
      // Validar que los datos realmente fueron enviados
      if (empty($_GET['grade'])) {
        throw new Exception('Ingrese el grado del estudiante');
      }

      if (empty($_GET['_id'])) {
        throw new Exception('Ingrese el número de documento del estudiante');
      }

      // Obtener el nombre del grado ingresado por el usuario
      $grade = $this->gradesModelInstance->getByIdGrade($_GET['grade']);

      // Verificar si el estudiante esta registrado en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      // Si no esta registrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador o ha sido deshabilitado.");
      }
      // Obtener el número total de citaciones que lleva el esrudiante
      $totalCitations = $this->citationsModelInstance->getNumberOfCitations($studentFound->_id);

      // Si el estudiante existe en la base de datos, mostrar la página de citación
      echo $this->twig->render('citing-parents.twig', [
        'title' => 'Citación de padres de familia',
        'userLogged' => $_SESSION['user_discipline_observer'],
        '_studentInfo' => $studentFound->student . ' de ' . $grade->grade . ' grado',
        '_emailParent' => $studentFound->parent_email,
        '_nameParent' => $studentFound->parent_name . ' ' . $studentFound->parent_lastname,
        '_id' => $studentFound->_id,
        'totalCitations' => $totalCitations
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

      if (empty($_POST['teacher_name'])) {
        throw new Exception('Ingrese el nombre del docente a cargo de la asignatura');
      }

      if (empty($_POST['subject_name'])) {
        throw new Exception('Ingrese el nombre de la asignatura');
      }

      if (empty($_POST['subject_schedule'])) {
        throw new Exception('Ingrese la hora de la asignatura');
      }

      // Validar que la hora de la asignatura sea mayor a la actual
      if (new DateTime($_POST['subject_schedule']) < new DateTime('now')) {
        throw new Exception('La hora de la asignatura no puede ser anterior a la actual');
      }

      // Validar si el campo hora de la asignatura es una fecha válida
      // Formato de hora: Hora:Minutos (00:00 - 23:59)
      if (!DateTime::createFromFormat('H:i', $_POST['subject_schedule'])) {
        throw new Exception('La hora de la asignatura no es válida');
      }

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      // Validar que el estudiante exista en la base de datos del observador
      $studentFound = $this->studentsModelInstance->getByIdStudent($_GET['_id']);

      if ($_POST['email'] !== $studentFound->parent_email) {
        throw new Exception("El correo del padre de familia no coincide con el ingresado en la citación");
      }

      // El estudiante no fue encontrado, mostrar mensaje de error
      if (!$studentFound) {
        throw new Exception("El estudiante no fué encontrado en la base de datos del observador o ha sido deshabilitado.");
      }

      // Generamos un id unico para la asignatura
      $subject_id = uniqid($studentFound->_id . '-');
      // Vamos a guardar la asignatura en la base de datos
      $newSubject = $this->subjectModelInstance->create(
        $subject_id,
        $_POST['subject_name'],
        $_POST['subject_schedule'],
      );

      // Vamos a crear la anotación en el observador
      $newNotation = $this->notationsModelInstance->create(
        $studentFound->_id,
        $_POST['notation'],
        $_GET['grade'],
        $_POST['testimony'],
        $_POST['teacher_name'],
        $subject_id,
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
