<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\ParentsModel;

class AdminParentsController extends RegisterController {
  protected ParentsModel $parentsModelInstance;
  protected AuthMiddleware $authMiddlewareInstance;

  public function __construct()
  {
    // Llamamos al constructor de la clase padre
    parent::__construct();

    // Instanciamos los modelos
    $this->parentsModelInstance = new ParentsModel();
    $this->authMiddlewareInstance = new AuthMiddleware();

    // Verificar que el usuario este autenticado
    $this->authMiddlewareInstance->handle();
  }

  public function showDashboardParents(array $data = []): void
  {
    // Si no hay nada en la variable de busqueda, se muestra todo	los padres
    if (empty($_GET['search'])) {
      // Obtenemos todos los padres
      $parents = $this->parentsModelInstance->getAllParents();
    }

    // Si no está vacía obtener padres por la búsqueda
    if (!empty($_GET['search'])) {
      // Obtener padres de familia por la búsqueda
      $parents = $this->parentsModelInstance->getParentBySearch($_GET['search']);
    }

    // Renderizar el pánel de administración de los padres de famila
    echo $this->twig->render('dashboard-parents.twig', array_merge([
      'title' => 'Padres de familia',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'parents' => $parents,
      'search' => $_GET['search'] ?? ''
    ], $data));
  }

  public function updateParent(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Validamos que los datos sean correctos
      if (empty($_POST['_id'])) {
        throw new Exception("Ingrese la cédula");  
      }

      if (strlen($_POST['_id']) < 8 || strlen($_POST['_id']) > 10) {
        throw new Exception("El valor de la cédula es incorrecto");
      }

      if (empty($_POST['name'])) {
        throw new Exception('Ingrese los nombres');
      }

      if (empty($_POST['lastname'])) {
        throw new Exception('Ingrese los apellidos');
      }

      if (empty($_POST['telephone'])) {
        throw new Exception('Ingrese el teléfono');
      }

      if (strlen($_POST['telephone']) !== 10) {
        throw new Exception("El número de telefono debe tener 10 dígitos");
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      $parentEdited = $this->parentsModelInstance->updateParent(
        $_POST['_id'],
        $_POST['name'],
        $_POST['lastname'],
        $_POST['telephone'],
        $_POST['email']
      );

      if ($parentEdited) {
        $this->showEditParentsView([
          'success' => 'Datos actualizados exitosamente'
        ]);
        return;
      }

      throw new Exception("Error al editar los datos del Padre de familia");    
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showEditParentsView([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function showEditParentsView(array $data = []): void
  {
    $parentData = $this->parentsModelInstance->getParentById($_POST['_id']);

    echo $this->twig->render('edit-parents.twig', array_merge([
      'title' => 'Editar Padre de familia',
      'userLogged' => $_SESSION['user_discipline_observer'],
      'parent' => $parentData
    ], $data));
  }

  public function showAddParentsView(array $data = []): void
  {
    $_SESSION['temporarily_roles'] = [
      [
        "_id" => "parent",
        "role" => "Padre de familia",
      ]
    ];

    $_SESSION['temporarily_data_create_user'] = [
      'permissions' => ['admin', 'parents'],
      'path_redirect' => 'padres-de-familia'
    ];

    $this->showAskDataView([
      'userLogged' => $_SESSION['user_discipline_observer'],
      'current_admin_action' => $_SESSION['temporarily_data_create_user']['permissions']
    ]);
  }

  public function deleteParent(): void
  {
    try {
      // Verificamos que el usuario este logueado y tenga los permisos de administrador
      $this->authMiddlewareInstance->handlePermissionsAdmin();

      // Validar que los datos realmente fueron enviados
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $parentDeleted = $this->parentsModelInstance->deleteParent($_POST['_id']);

      if ($parentDeleted) {
        $this->showDashboardParents([
          'success' => 'Padre de familia eliminado correctamente',
        ]);
        return;
      }

      throw new Exception('Error al eliminar el Padre de familia');
    } catch (Exception $e) {
      $error = $e->getMessage();

      $this->showDashboardParents([
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }
}