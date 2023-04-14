<?php

namespace App\Controllers;

class AuthController extends BaseController {
  public function show()
  {
    $output = $this->twig->render('login.twig', [
      'title' => 'Mi proyecto sin framework',
      'message' => 'Este es un ejemplo de un proyecto MVC usando Aura/Router y Twig.'
    ]);
    // Renderizar la plantilla y mostrar la salida
    echo $output;
  }

  public function authenticate()
  {
    echo $_POST['email'];
  }
}