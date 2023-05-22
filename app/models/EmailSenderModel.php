<?php

namespace App\Models;

// Importamos Sendgrid Email
use Exception;
use SendGrid;
use SendGrid\Mail\Mail;

class EmailSenderModel
{
  public function sendEmail($subject, $to, $content)
  {
    // Instanciamos la clase Mail
    $email = new Mail();

    // Instanciamos la clase EnvModel para leer las variables de entorno
    $envModelInstance = new EnvModel();

    // Configuramos el email
    $email->setFrom(
      $envModelInstance->reader('FROM_EMAIL'),
      $envModelInstance->reader('FROM_NAME')
    );
    $email->setSubject($subject);
    $email->addTo($to);
    $email->addContent("text/html", "<strong>$content</strong>");
    
    
    // Obtenemos la API KEY de Sendgrid
    $sendgridApiKey = $envModelInstance->reader('SENDGRID_API_KEY');
    // Instanciamos la clase SendGrid
    $sendgrid = new SendGrid($sendgridApiKey);
    
    // Vamos a intentar enviar el email
    try {
      // Enviamos el email
      $response = $sendgrid->send($email);
      // Retornamos la respuesta
      return $response;
      // print $response->statusCode() . "\n";
      // print_r($response->headers());
      // print $response->body() . "\n";
    } catch (Exception $e) {
      // En caso de error, lanzamos una excepción
      throw new Exception($e->getMessage());
    }
  }
}
