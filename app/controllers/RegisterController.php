<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Models\{ UserModel, EmailSenderModel };
use App\Middleware\AuthMiddleware;

class RegisterController extends BaseController {
  protected $roles;

  public function __construct()
  {
    // Llamamos al constructor del padre BaseController
    parent::__construct();

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

  public function showAskDataView($data = [])
  {
    // Mostramos la vista de tomar los datos personales
    echo $this->twig->render('askdata-register.twig', array_merge([
      'title' => 'Datos personales'
    ], $data));
  }

  public function showRequestDataView($data = [])
  {
    // Verificamos que el usuario este logueado
    if ($_GET['auth'] === 'true') {

      // Verificamos que el usuario este logueado
      $authMiddlewareInstance = new AuthMiddleware();
      $authMiddlewareInstance->handle();
      
      // Cargamos los roles
      $this->roles = [
        [
          "_id" => "teacher",
          "role" => "Docente",
        ]
      ];

      // Cargamos los datos del usuario
      $data = array_merge([
        'userLogged' => $_SESSION['user_discipline_observer']
      ], $data);
    }

    // Mostramos la vista del formulario de crear la cuenta
    echo $this->twig->render('requestdata-register.twig', array_merge([
      'title' => 'Crear una cuenta',
      'roles' => $this->roles
    ], $data));
  }

  public function register()
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

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }

      if (empty($_POST['password'])) {
        throw new Exception('Ingrese la contraseña');
      }

      if (empty($_POST['identification'])) {
        throw new Exception('Seleccione la identificación');
      }

      // Creamos una instancia de UserModel
      $userModelInstance = new UserModel();
      $userFound = $userModelInstance->findById($_GET['_id']);
      $emailExists = $userModelInstance->findByEmail($_POST['email']);
      
      if ($userFound || $emailExists) {
        throw new Exception("El usuario o el correo ya existen");
      }

      // Creamos el usuario
      $userCreated = $userModelInstance->create(
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

      $emailSenderModelInstance = new EmailSenderModel();
      $emailAccountCreatedSended = $emailSenderModelInstance->sendEmail(
        'Confirmación cuenta Discipline Observer',
        $_POST['email'],
        'Cuenta creada exitosamente, Observador Discipline Observer, Colegio San José Obrero - Espinal.<br>Gracias por registrarte.<br><br>Buen día ' . $_GET['name'] . ', esta es una copia de su contraseña: <strong>' . $_POST['password'] . '</strong><br>Por favor cambie su contraseña inmediatamente, ingresando al siguiente enlace: <a href=' . $_SERVER['HTTP_ORIGIN'] . '/cambiar/contrasena' . '>Cambiar contraseña</a>.'
      );

      if (!$emailAccountCreatedSended) {
        throw new Exception("Error al enviar un correo de confirmación, pero su cuenta fue creada exitosamente.");
      }

      // Mostramos el mensaje de registro exitoso
      $this->showRequestDataView([
        'title' => 'Registro exitoso',
        'success' => 'Registrado exitosamente, por favor inicie sesión'
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();
      
      $this->showRequestDataView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }
}
