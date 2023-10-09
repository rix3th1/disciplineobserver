<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Middlewares\AuthMiddleware;
use App\Models\{
  UserModel,
  ParentsModel,
  EmailSenderModel
};

class RegisterController extends BaseController {
  protected UserModel $userModelInstance;
  protected ParentsModel $parentsModelInstance;
  protected EmailSenderModel $emailSenderModelInstance;

  // Roles
  protected array $roles;

  public function __construct()
  {
    // Llamamos al constructor del padre BaseController
    parent::__construct();

    // Inicializamos los modelos
    $this->userModelInstance = new UserModel;
    $this->parentsModelInstance = new ParentsModel;
    $this->emailSenderModelInstance = new EmailSenderModel;

    // Cargamos los roles
    $this->roles = [
      [
        "_id" => "teacher",
        "role" =>"Docente",
        "disabled" => true
      ],
      [
        "_id" => "parent",
        "role" =>"Padre de familia",
        "disabled" => false
      ]
    ];
  }

  public function showAskDataView(array $data = []): void
  {
    $temp_title = $_SESSION['temporarily_data_create_user']['temp_title'] ?? "";

    // Mostramos la vista de tomar los datos personales
    echo $this->twig->render('askdata-register.twig', array_merge([
      'title' => "Datos personales $temp_title"
    ], $data));
  }

  public function showRequestDataView(array $data = []): void
  {
    // Verificamos que el usuario este logueado
    if ($_GET['auth'] === 'true') {

      // Verificamos que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();
      
      // Cargamos los roles
      $this->roles = $_SESSION['temporarily_roles'] ?? $this->roles;

      // Cargamos los datos del usuario
      $data = array_merge([
        'userLogged' => $_SESSION['user_discipline_observer'],
        'path_redirect' => $_SESSION['temporarily_data_create_user']['path_redirect'] ?? '',
        'current_admin_action' => $_SESSION['temporarily_data_create_user']['permissions'] ?? NULL
      ], $data);
    }

    $temp_title = $_SESSION['temporarily_data_create_user']['temp_title'] ?? '';

    // Mostramos la vista del formulario de crear la cuenta
    echo $this->twig->render('requestdata-register.twig', array_merge([
      'title' => "Crear una cuenta $temp_title",
      'roles' => $this->roles,
      'parent_id' => $_GET['_id'],
    ], $data));
  }

  public function register(): void
  {
    try {
      // Validamos que se haya enviado los datos
      if (!$_GET || !$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handlePermissionsAdmin();

      // Validamos que los datos sean correctos
      if (empty($_GET['_id'])) {
        throw new Exception("Ingrese la cédula");  
      }

      if (strlen($_GET['_id']) < 8 || strlen($_GET['_id']) > 10) {
        throw new Exception("El valor de la cédula es incorrecto");
      }

      if (empty($_GET['name'])) {
        throw new Exception('Ingrese los nombres');
      }

      if (empty($_GET['lastname'])) {
        throw new Exception('Ingrese los apellidos');
      }

      if (empty($_GET['telephone'])) {
        throw new Exception('Ingrese el teléfono');
      }

      if (strlen($_GET['telephone']) !== 10) {
        throw new Exception("El número de telefono debe tener 10 dígitos");
      }

      if (empty($_GET['job'])) {
        throw new Exception('Ingrese su empleo');
      }

      if (empty($_GET['availability'])) {
        throw new Exception('Ingrese su disponibilidad');
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }

      if (empty($_POST['password'])) {
        throw new Exception('Ingrese la contraseña');
      }

      if (empty($_POST['identification'])) {
        throw new Exception('Seleccione la identificación');
      }

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      $userFound = $this->userModelInstance->findById($_GET['_id']);
      $emailExists = $this->userModelInstance->findByEmail($_POST['email']);
      
      if ($userFound || $emailExists) {
        throw new Exception("El usuario o el correo ya existen");
      }

      // Creamos el usuario
      $userCreated = $this->userModelInstance->create(
        $_GET['_id'],
        $_GET['name'],
        $_GET['lastname'],
        $_GET['telephone'],
        $_POST['email'],
        $_POST['password'],
        $_POST['identification']
      );

      if (!$userCreated) {
        throw new Exception("Error al crear el usuario");
      }

      // Creamos la relación entre el usuario y el padre de familia
      if ($_POST['identification'] === 'parent') {
        $parent_created = $this->parentsModelInstance->create(
          $_GET['_id'],
          $_GET['job'],
          $_GET['availability']
        );

        if (!$parent_created) {
          throw new Exception("Error al crear el padre de familia");
        }
      }

      $personPost = $_POST['identification'] === 'teacher' ? 'Docente' : ($_POST['identification'] === 'parent' ? 'Padre de Familia' : '');

      $emailAccountCreatedSended = $this->emailSenderModelInstance->sendEmail(
        "Confirmación cuenta Discipline Observer - $personPost",
        $_POST['email'],
        'Cuenta creada exitosamente, Observador Discipline Observer, Colegio San José Obrero - Espinal.<br>Gracias por registrarte.<br><br>Buen día señor(a) ' . $personPost . ': ' . $_GET['name'] . ', esta es una copia de su contraseña: <strong>' . $_POST['password'] . '</strong><br>Por favor cambie su contraseña inmediatamente, ingresando al siguiente enlace: <a href=' . $_SERVER['HTTP_ORIGIN'] . '/cambiar/contrasena' . '>Cambiar contraseña</a>.'
      );

      if (!$emailAccountCreatedSended) {
        throw new Exception("Error al enviar un correo de confirmación, pero su cuenta fue creada exitosamente.");
      }

      // Mostramos el mensaje de registro exitoso
      $this->showRequestDataView([
        'title' => 'Registro exitoso',
        'success' => 'Registrado exitosamente, por favor inicie sesión'
      ]);

      $_SESSION['temporarily_roles'] = $this->roles; // [teacher, parent']
      $_SESSION['temporarily_data_create_user'] = NULL;
    } catch (Exception $e) {
      $error = $e->getMessage();
      
      $this->showRequestDataView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }
}
