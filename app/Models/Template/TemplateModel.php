<?php

namespace Models\Template;

require_once __DIR__ . '/../../../../config/conf.php';

use Models\MasterModel;

if ($enviroment == 'development') {
  define('SUBDOMAIN', '/businessandconnection');
} else {
  define('SUBDOMAIN', '');
}

Class TemplateModel extends MasterModel
{
  static function TemplateNotificationActivationUser(string $userName) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;
    $html = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta http-equiv='X-UA-Compatible' content='ie=edge' />
        <title>Notificación de activación de cuenta</title>
        <style>
          body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
          }
  
          h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          p {
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
          }
  
          .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
          }
  
          .footer {
            margin-top: 40px;
            text-align: center;
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <h1>¡Tu cuenta ha sido activada!</h1>
          <p>Hola " . $userName . ",</p>
          <p>Tu cuenta en nuestra plataforma ha sido activada correctamente.</p>
          <p>A partir de ahora, puedes acceder a todos los servicios y funcionalidades disponibles en nuestra aplicación.</p>
          <p>¡Gracias por unirte a nosotros!</p>
          <div class='footer'>
            <p><a href='http://" . $host . "/PortalUsuarios/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
            <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
          </div>
        </div>
      </body>
    </html>";
    return $html;
  }
  
  static function TemplateNotificationDocumentRequest(string $userName, string $userEmail, string $password) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

    $html = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta http-equiv='X-UA-Compatible' content='ie=edge' />
        <title>Notificación de registro de documentos</title>
        <style>
          body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
          }
  
          h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          p {
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
          }
  
          .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
          }
  
          .footer {
            margin-top: 40px;
            text-align: center;
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <h1>Bienvenido a nuestra plataforma</h1>
          <p>Hola " . $userName . ",</p>
          <p>Te has registrado como cliente en nuestra plataforma.</p>
          <p>Para poder hacer uso completo de nuestro sistema, necesitamos que registres los siguientes documentos:</p>
          <ol>
            <li>Cédula del representante legal</li>
            <li>Cámara de Comercio</li>
            <li>RUT (Registro Único Tributario)</li>
            <li>Formulario de inscripción</li>
            <li>Certificación bancaria</li>
          </ol>
          <p>Por favor, accede a tu cuenta y dirígete a la sección de documentación para cargar los documentos requeridos.</p>
          <p>Tu información de inicio de sesión es la siguiente:</p>
          <p>Correo electrónico: " . $userEmail . "</p>
          <p>Contraseña: " . $password . "</p>
          <div class='footer'>
            <p><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
            <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
          </div>
        </div>
      </body>
    </html>";
    return $html;
}





  static function TemplateRegistrationLink(string $userMail, string $messages) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

    $html = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta http-equiv='X-UA-Compatible' content='ie=edge' />
        <title>Enlace de registro</title>
        <style>
          body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
          }
  
          h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          p {
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
          }
  
          .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
          }
  
          .footer {
            margin-top: 40px;
            text-align: center;
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <h1>¡Bienvenido(a) a nuestro sitio!</h1>
          <p>Hola " . $userMail . ",</p>
          <p>Estás a solo un paso de unirte a nuestra plataforma.</p>
          <p>Para completar tu registro, haz clic en el siguiente enlace:</p>
          <p> <a href='http://" . $host . "/public/ajax.php?module=Access&controller=Access&action=RegisterView'>Click aquí</a></p>
          <p>Adicionalmente:</p>
          <textarea>".$messages."</textarea>
          <p>¡Gracias por elegirnos!</p>
          <div class='footer'>
            <p>© " . date('Y') ." . Todos los derechos reservados.</p>
          </div>
        </div>
      </body>
    </html>";
    return $html;
}


  static function TemplateNotificationInactivationUser(string $userName) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

    $html = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta http-equiv='X-UA-Compatible' content='ie=edge' />
        <title>Notificación de cuenta inactiva</title>
        <style>
          body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
          }
  
          h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          p {
            margin-top: 0;
            margin-bottom: 20px;
          }
  
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
          }
  
          .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
          }
  
          .footer {
            margin-top: 40px;
            text-align: center;
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <h1>Tu cuenta ha sido inactivada</h1>
          <p>Hola " . $userName . ",</p>
          <p>Lamentamos informarte que tu cuenta ha sido inactivada en nuestra plataforma.</p>
          <p>Si crees que ha habido un error o tienes alguna pregunta, por favor, ponte en contacto con nuestro equipo de soporte.</p>
          <p>Gracias por tu comprensión.</p>
          <div class='footer'>
            <p>Ponte en contacto con nosotros <a href='http://" . $host . "/public/index.php'>aquí</a></p>
            <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
          </div>
        </div>
      </body>
    </html>";
    return $html;
  }
  


  static function TemplateNotificationActivation(string $userName) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

    $html = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta http-equiv='X-UA-Compatible' content='ie=edge' />
        <title>Notificación de validación de cuenta</title>
        <style>
          body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
          }
    
          h1 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
          }
    
          p {
            margin-top: 0;
            margin-bottom: 20px;
          }
    
          .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
          }
    
          .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
          }
    
          .footer {
            margin-top: 40px;
            text-align: center;
          }
        </style>
      </head>
      <body>
        <div class='container'>
          <h1>¡Tu cuenta ha sido activada!</h1>
          <p>Hola " . $userName . ",</p>
          <p>Tus documentos han sido validados exitosamente y tu cuenta en nuestra plataforma ha sido activada.</p>
          <p>A partir de ahora, puedes acceder a todos los servicios y funcionalidades disponibles en nuestra aplicación.</p>
          <p>¡Gracias por unirte a nosotros!</p>
          <div class='footer'>
          <p><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
            <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
          </div>
        </div>
        
      </body>
    </html>";
    return $html;
}

static function TemplateNotificationPendingValidation(string $userName) {
  $html = "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <meta http-equiv='X-UA-Compatible' content='ie=edge' />
      <title>Notificación de validación de documentos</title>
      <style>
        body {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 16px;
          line-height: 1.5;
          color: #333;
        }
  
        h1 {
          font-size: 24px;
          margin-top: 0;
          margin-bottom: 20px;
        }
  
        p {
          margin-top: 0;
          margin-bottom: 20px;
        }
  
        .container {
          max-width: 600px;
          margin: 0 auto;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }
  
        .header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 20px;
        }
  
        .footer {
          margin-top: 40px;
          text-align: center;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h1>¡Espera la validación de tus documentos!</h1>
        <p>Hola " . $userName . ",</p>
        <p>Gracias por registrarte en nuestra plataforma.</p>
        <p>Tus documentos están siendo revisados y validados por nuestro equipo. Te notificaremos tan pronto como sean validados.</p>
        <p>Agradecemos tu paciencia y comprensión mientras completamos este proceso.</p>
        <div class='footer'>
          <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
          <p>© " . date('Y') . " Business And Connection. Todos los derechos reservados.</p>
        </div>
      </div>
      
    </body>
  </html>";
  return $html;
}

 
static function TemplateNotificationOrderStatus(string $companyName, int $orderId, bool $accepted) {
  $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;
  $status = $accepted ? "Aceptado" : "Rechazado";
  
  $html = "<!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='UTF-8' />
      <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      <meta http-equiv='X-UA-Compatible' content='ie=edge' />
      <title>Notificación de estado de pedido</title>
      <style>
        body {
          font-family: Arial, Helvetica, sans-serif;
          font-size: 16px;
          line-height: 1.5;
          color: #333;
        }

        h1 {
          font-size: 24px;
          margin-top: 0;
          margin-bottom: 20px;
        }

        p {
          margin-top: 0;
          margin-bottom: 20px;
        }

        .container {
          max-width: 600px;
          margin: 0 auto;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }

        .header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-bottom: 20px;
        }

        .footer {
          margin-top: 40px;
          text-align: center;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h1>Estado del pedido</h1>
        <p>Hola <b>" . $companyName . "</b>,</p>
        <p>Tu pedido con ID <b>" . $orderId . "</b> ha sido <b>" . $status . "</b>.</p>
        <p>Para más detalles, por favor inicia sesión en nuestra plataforma.</p>
        <div class='footer'>
        <p><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para más detalles</p>
          <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
        </div>
      </div>
      
    </body>
  </html>";
  
  return $html;
}

    static function TemplateCode(string $code,string $name){
    $html="<!DOCTYPE html>
        <html lang='en'>
          <head>
            <meta charset='UTF-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta http-equiv='X-UA-Compatible' content='ie=edge' />
            <title>Correo electrónico de aplicación</title>
            <style>
              body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                color: #333;
              }
        
              h1 {
                font-size: 24px;
                margin-top: 0;
                margin-bottom: 20px;
              }
        
              p {
                margin-top: 0;
                margin-bottom: 20px;
              }
        
              .button {
                display: inline-block;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
              }
        
              .button:hover {
                background-color: #0069d9;
              }
        
              .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
              }
        
              .logo {
                display: inline-block;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                margin-bottom: 20px;
                background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                background-size: cover;
                background-position: center;
                border:1px solid black;
              }
        
              .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 20px;
              }
        
              .footer {
                margin-top: 40px;
                text-align: center;
              }
            </style>
          </head>
          <body>
            <div class='container'>
            <div class='logo'>

            </div>
            <p>Hola ".$name.",</p>
            <p>Para completar tu inicio de sesión en nuestra aplicación, necesitamos que ingreses el siguiente código de verificación:</p>
            <p><strong>".$code."</strong></p>
            <p>Este código es válido por 5 minutos. Si no lo usas en ese tiempo, tendrás que solicitar uno nuevo.</p>
              <p>Gracias por usar nuestra aplicación.</p>
              <div class='footer'>
                <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
              </div>
            </div>
          </body>
        </html>";
        return $html;
    }
    static function SubscriptionUpdatedTemplate(string $endDate, string $name){
      $html="<!DOCTYPE html>
          <html lang='en'>
            <head>
              <meta charset='UTF-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta http-equiv='X-UA-Compatible' content='ie=edge' />
              <title>Actualización de suscripción</title>
              <style>
                body {
                  font-family: Arial, Helvetica, sans-serif;
                  font-size: 16px;
                  line-height: 1.5;
                  color: #333;
                }
          
                h1 {
                  font-size: 24px;
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                p {
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                .button {
                  display: inline-block;
                  background-color: #007bff;
                  color: #fff;
                  text-decoration: none;
                  padding: 10px 20px;
                  border-radius: 5px;
                }
          
                .button:hover {
                  background-color: #0069d9;
                }
          
                .container {
                  max-width: 600px;
                  margin: 0 auto;
                  padding: 20px;
                  border: 1px solid #ccc;
                  border-radius: 5px;
                }
          
                .logo {
                  display: inline-block;
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
                  background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                  background-size: cover;
                  background-position: center;
                  border:1px solid black;
                }
          
                .header {
                  display: flex;
                  align-items: center;
                  justify-content: space-between;
                  margin-bottom: 20px;
                }
          
                .footer {
                  margin-top: 40px;
                  text-align: center;
                }
              </style>
            </head>
            <body>
              <div class='container'>
              <div class='logo'>
  
              </div>
              <p>Hola ".$name.",</p>
              <p>Tu suscripción al portal de usuarios ha sido actualizada.</p>
              <p>La fecha de finalización de tu plan es: <strong>".$endDate."</strong></p>
              <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>
                <p>Gracias por usar nuestra aplicación.</p>
                <div class='footer'>
                  <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
                </div>
              </div>
            </body>
          </html>";
          return $html;
  }
  
    static function TemplateRegisterCompany(string $name) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

      $html = "<!DOCTYPE html>
          <html lang='en'>
            <head>
              <meta charset='UTF-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta http-equiv='X-UA-Compatible' content='ie=edge' />
              <title>Correo electrónico de aplicación</title>
              <style>
                body {
                  font-family: Arial, Helvetica, sans-serif;
                  font-size: 16px;
                  line-height: 1.5;
                  color: #333;
                }
          
                h1 {
                  font-size: 24px;
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                p {
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                .button {
                  display: inline-block;
                  background-color: #007bff;
                  color: #fff;
                  text-decoration: none;
                  padding: 10px 20px;
                  border-radius: 5px;
                }
          
                .button:hover {
                  background-color: #0069d9;
                }
          
                .container {
                  max-width: 600px;
                  margin: 0 auto;
                  padding: 20px;
                  border: 1px solid #ccc;
                  border-radius: 5px;
                }
          
                .logo {
                  display: inline-block;
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
                  background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                  background-size: cover;
                  background-position: center;
                  border:1px solid black;
                }
          
                .header {
                  display: flex;
                  align-items: center;
                  justify-content: space-between;
                  margin-bottom: 20px;
                }
          
                .footer {
                  margin-top: 40px;
                  text-align: center;
                }
              </style>
            </head>
            <body>
              <div class='container'>
                <div class='logo'></div>
                <p>Hola " . $name . ",</p>
                <p>Gracias por registrar su empresa. Pronto recibirá un correo con su usuario y contraseña una vez que sus datos hayan sido validados.</p>
                <div class='footer'>
                <p ><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
                  <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
                </div>

              </div>
            </body>
          </html>";
      return $html;
  }
    static function TemplateRejectRegistration(string $name, string $reason) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

      $html = "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta http-equiv='X-UA-Compatible' content='ie=edge' />
              <title>Registration Rejected</title>
              <style>
                  body {
                      font-family: Arial, Helvetica, sans-serif;
                      font-size: 16px;
                      line-height: 1.5;
                      color: #333;
                  }
          
                  h1 {
                      font-size: 24px;
                      margin-top: 0;
                      margin-bottom: 20px;
                  }
          
                  p {
                      margin-top: 0;
                      margin-bottom: 20px;
                  }
          
                  .button {
                      display: inline-block;
                      background-color: #007bff;
                      color: #fff;
                      text-decoration: none;
                      padding: 10px 20px;
                      border-radius: 5px;
                  }
          
                  .button:hover {
                      background-color: #0069d9;
                  }
          
                  .container {
                      max-width: 600px;
                      margin: 0 auto;
                      padding: 20px;
                      border: 1px solid #ccc;
                      border-radius: 5px;
                  }
          
                  .logo {
                      display: inline-block;
                      width: 150px;
                      height: 150px;
                      border-radius: 50%;
                      margin-bottom: 20px;
                      background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                      background-size: cover;
                      background-position: center;
                      border:1px solid black;
                  }
          
                  .header {
                      display: flex;
                      align-items: center;
                      justify-content: space-between;
                      margin-bottom: 20px;
                  }
          
                  .footer {
                      margin-top: 40px;
                      text-align: center;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <div class='logo'></div>
                  <p>Hola " . $name . ",</p>
                  <p>Lamentamos informarle que su solicitud de registro ha sido rechazada por el siguiente motivo:</p>
                  <p>" . $reason . "</p>
                  <div class='footer'>
                      <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
                  </div>
              </div>
          </body>
          </html>";
      
      return $html;
  }

    static function TemplateNotification(string $userName, string $companyName) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

      $html = "<!DOCTYPE html>
          <html lang='en'>
            <head>
              <meta charset='UTF-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1.0' />
              <meta http-equiv='X-UA-Compatible' content='ie=edge' />
              <title>Notificación de solicitud de registro</title>
              <style>
                body {
                  font-family: Arial, Helvetica, sans-serif;
                  font-size: 16px;
                  line-height: 1.5;
                  color: #333;
                }
          
                h1 {
                  font-size: 24px;
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                p {
                  margin-top: 0;
                  margin-bottom: 20px;
                }
          
                .container {
                  max-width: 600px;
                  margin: 0 auto;
                  padding: 20px;
                  border: 1px solid #ccc;
                  border-radius: 5px;
                }
          
                .logo {
                  display: inline-block;
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
                  background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                  background-size: cover;
                  background-position: center;
                  border:1px solid black;
                }
          
                .header {
                  display: flex;
                  align-items: center;
                  justify-content: space-between;
                  margin-bottom: 20px;
                }
          
                .footer {
                  margin-top: 40px;
                  text-align: center;
                }
              </style>
            </head>
            <body>
              <div class='container'>
                <div class='logo'></div>
                <p>Hola,</p>
                <p>Se ha recibido una solicitud de registro de un nuevo usuario en el portal.</p>
                <p>El nombre de usuario que ha enviado la solicitud es: <strong>" . $userName . "</strong></p>
                <p>El nombre de la empresa es: <strong>" . $companyName . "</strong></p>
                <p>Por favor, revise la solicitud y tome las acciones necesarias.</p>
                <div class='footer'>
                <p ><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
                  <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
                </div>

              </div>
            </body>
          </html>";
      return $html;
  }

  static function TemplateNotificationComplete(string $userName, string $companyName) {
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

    $html = "<!DOCTYPE html>
        <html lang='en'>
          <head>
            <meta charset='UTF-8' />
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <meta http-equiv='X-UA-Compatible' content='ie=edge' />
            <title>Notificación de finalización del registro</title>
            <style>
              body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
                line-height: 1.5;
                color: #333;
              }
        
              h1 {
                font-size: 24px;
                margin-top: 0;
                margin-bottom: 20px;
              }
        
              p {
                margin-top: 0;
                margin-bottom: 20px;
              }
        
              .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
              }
        
              .logo {
                display: inline-block;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                margin-bottom: 20px;
                background-image: url('https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png');
                background-size: cover;
                background-position: center;
                border:1px solid black;
              }
        
              .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 20px;
              }
        
              .footer {
                margin-top: 40px;
                text-align: center;
              }
            </style>
          </head>
          <body>
            <div class='container'>
              <div class='logo'></div>
              <p>Hola,</p>
              <p>El usuario <strong>" . $userName . "</strong> ha finalizado el registro de la empresa <strong>" . $companyName . "</strong>.</p>
              <p>Por favor, revise la solicitud y tome las acciones necesarias.</p>
              <div class='footer'>
              <p ><a href='http://" . $host . "/public/index.php'>Ingresa aquí</a> para iniciar sesión</p>
                <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
              </div>

            </div>
          </body>
        </html>";
    return $html;
  }

    
    public static function TemplateChangePassword($name, $new_password){
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

      $html = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <title>Nueva contraseña</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  font-size: 14px;
                  color: #333;
              }
              .container {
                  max-width: 600px;
                  margin: 0 auto;
                  padding: 20px;
                  border: 1px solid #ccc;
                  border-radius: 5px;
              }
              .logo {
                  display: inline-block;
                  width: 150px;
                  height: 150px;
                  border-radius: 50%;
                  margin-bottom: 20px;
                  background-image: url("https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png");
                  background-size: cover;
                  background-position: center;
                  border:1px solid black;
              }
              .header {
                  display: flex;
                  align-items: center;
                  justify-content: space-between;
                  margin-bottom: 20px;
              }
              .footer {
                  margin-top: 40px;
                  text-align: center;
              }
          </style>
      </head>
      <body>
      <div class="container">
          <div class="logo"></div>
          <p>Hola <b>'.$name.'</b>,</p>
          <p>Recientemente se ha cambiado tu contraseña de usuario.</p>
          <p>Tu nueva contraseña es:</p>
          <ul>
              <li>Contraseña:<b>'.$new_password.'</b></li>
          </ul>
          <p>Por favor, inicia sesión con esta nueva contraseña y cambiala lo antes posible para mejorar la seguridad de tu cuenta.</p>
          <p>Gracias por utilizar nuestros servicios.</p>
          <div class="footer">
          <p ><a href="http://' . $host . '/public/index.php">Ingresa aquí</a> para iniciar sesión</p>         
              <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
          </div>
      </div>
      </body>
      </html>
  ';

    return $html;
    }

    public static function TemplateRegister($name,$email,$password){
    $host = $_SERVER['HTTP_HOST'] . SUBDOMAIN;

      $html = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Credenciales de registro</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                            color: #333;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #ccc;
                            border-radius: 5px;
                        }
                        .logo {
                            display: inline-block;
                            width: 150px;
                            height: 150px;
                            border-radius: 50%;
                            margin-bottom: 20px;
                            background-image: url("https://i.postimg.cc/L8qD1Dy7/apple-touch-icon.png");
                            background-size: cover;
                            background-position: center;
                            border:1px solid black;
                        }
                        .header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            margin-bottom: 20px;
                        }
                        .footer {
                            margin-top: 40px;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                <div class="container">
                    <div class="logo"></div>
                    <p>Hola '.$name.',</p>
                    <p>Te damos la bienvenida a nuestra aplicación.</p>
                    <p>Tus credenciales de inicio de sesión son:</p>
                    <ul>
                        <li>Usuario: '.$email.'</li>
                        <li>Contraseña: '.$password.'</li>
                    </ul>
                    <p>Por favor, cambia tu contraseña lo antes posible para mejorar la seguridad de tu cuenta.</p>
                    <p>Gracias por confiar en nosotros.</p>
                    <div class="footer">
                    <p><a href="http://' . $host . '/public/index.php">Ingresa aquí</a> para iniciar sesión</p>
                        <p>© 2023 Business And Connection. Todos los derechos reservados.</p>
                    </div>

                </div>
                </body>
                </html>
                ';

      return $html;

    }
}
