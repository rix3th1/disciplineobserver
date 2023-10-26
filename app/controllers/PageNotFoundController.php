<?php

namespace App\Controllers;

class PageNotFoundController extends BaseController {

  public function __construct() {
    // Llamar al constructor del padre
    parent::__construct();
  }

  public function showNotFoundPage(): void
  {
    // Mostramos la página que corresponde a página no encontrada
    echo $this->twig->render('page-not-found.twig', [
      'title' => 'Página no encontrada'
    ]);
  }
}
