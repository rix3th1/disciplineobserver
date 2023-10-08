<?php

namespace App\Models;

// Importamos Sendgrid Email
use Exception;
use SendGrid;
use SendGrid\Mail\Mail;

class EmailSenderModel {
  protected Mail $email;
  protected EnvModel $envModelInstance;
  
  public function __construct()
  {
    // Instanciamos la clase Mail
    $this->email = new Mail;

    // Instanciamos la clase EnvModel para leer las variables de entorno
    $this->envModelInstance = new EnvModel;
  }

  public function sendEmail(string $subject, string $to, string $content): bool
  {
    // Configuramos el email
    $this->email->setFrom(
      $this->envModelInstance->reader('FROM_EMAIL'),
      $this->envModelInstance->reader('FROM_NAME')
    );
    $this->email->setSubject($subject);
    $this->email->addTo($to);
    $this->email->addContent("text/html", $content);

    // Obtenemos la API KEY de Sendgrid
    $sendgridApiKey = $this->envModelInstance->reader('SENDGRID_API_KEY');
    // Instanciamos la clase SendGrid
    $sendgrid = new SendGrid($sendgridApiKey);
    
    // Vamos a intentar enviar el email
    try {
      // Enviamos el email
      $response = $sendgrid->send($this->email);

      // print $response->statusCode() . "\n";
      // print_r($response->headers());
      // print $response->body() . "\n";

      // Retornamos la respuesta
      return $response->statusCode() === 202;
    } catch (Exception $e) {
      // En caso de error, lanzamos una excepción
      throw new Exception($e->getMessage());
    }
  }
}
