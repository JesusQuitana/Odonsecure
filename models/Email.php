<?php
namespace Model;

use Mailgun\HttpClient\HttpClientConfigurator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mailgun\Mailgun;

abstract class Email {
    public static function enviarConfirmacion($token, $correo) {
        $html = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <style>html{font-size:62.5%}body{font-size:1.6rem;margin:0 auto;font-family:Verdana,Geneva,Tahoma,sans-serif}main{max-width:800px;border:5px solid #148c84;margin:0 auto}h1,h2,p{margin:0}h1{font-size:3.4rem}h2{font-size:3rem}p{font-size:1.5rem}span{font-weight:bold}header{margin:0 auto;padding:4rem;background-color:#16848c;color:#fff;display:block}.inform{text-align:right}.contenido{margin:10px auto}footer{margin:5px auto;text-align:center}@media(max-width:480px){.contenedor{text-align:center;max-width:100%;font-size: 10px}h1{display:block;margin:0 auto}.inform{display:block;text-align:center;margin:0 auto}}</style><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body> <main class="contenedor"> <header> <h1>OdonSecure</h1> <div class="inform"> <p><span>Ubicacion:</span> Av Casanova, en frente del farmatodo del recreo</p> <p><span>Nro Telefono:</span> 04144663318</p> <p><span>Correo:</span> consultorio@odonsecure.com</p> <p><span>Instagram:</span> @odonsecure_</p> </div> </header> <div class="contenido"> <p>En el siguiente enlace &raquo; <a href="'. $_ENV["APP_URL"] .'/confirm?token='.$token.'">Confirmar Cuenta</a>, podras confirmar tu cuenta en <strong>OdonSecure</strong> para obtener todos los beneficios disponibles.</p><br> <p><strong>OdonSecure</strong>, siempre ocupandonos de tu Sonrisa!</p><hr> </div> <footer> <p>Todos los derechos reservados || Jesus Quintana || '.date("Y-m-d").'</p> </footer> </main> </body></html>';

        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host = $_ENV["EMAIL_HOST"];
            $email->SMTPAuth = true;
            $email->Username = $_ENV["EMAIL_USERNAME"];
            $email->Password = $_ENV["EMAIL_PASSWORD"];
            $email->Port = $_ENV["EMAIL_PORT"];

            $email->setFrom($_ENV["EMAIL_USERNAME"], 'OdonSecure');
            $email->addAddress($correo, $correo);

            $email->isHTML(true);
            $email->Subject = "Confirmacion Cuenta";
            $email->Body = $html;
            $email->AltBody = 'Anexo encontraras el link para confirmar tu cuenta';

            $enviado = $email->send();

            if($enviado) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return $e;
        }
        
    }
    public static function enviarReestablecer($token, $correo) {
        $html = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <style>html{font-size:62.5%}body{font-size:1.6rem;margin:0 auto;font-family:Verdana,Geneva,Tahoma,sans-serif}main{max-width:800px;border:5px solid #148c84;margin:0 auto}h1,h2,p{margin:0}h1{font-size:3.4rem}h2{font-size:3rem}p{font-size:1.5rem}span{font-weight:bold}header{margin:0 auto;padding:4rem;background-color:#16848c;color:#fff;display:block}.inform{text-align:right}.contenido{margin:10px auto}footer{margin:5px auto;text-align:center}@media(max-width:480px){.contenedor{text-align:center;max-width:100%;font-size: 10px}h1{display:block;margin:0 auto}.inform{display:block;text-align:center;margin:0 auto}}</style><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body> <main class="contenedor"> <header> <h1>OdonSecure</h1> <div class="inform"> <p><span>Ubicacion:</span> Av Casanova, en frente del farmatodo del recreo</p> <p><span>Nro Telefono:</span> 04144663318</p> <p><span>Correo:</span> consultorio@odonsecure.com</p> <p><span>Instagram:</span> @odonsecure_</p> </div> </header> <div class="contenido"> <p>En el siguiente enlace &raquo; <a href="'. $_ENV["APP_URL"] .'/change?token='.$token.'">Reestablecer Contrase&ntilde;a</a>, podras reestablecer tu contrase&ntilde;a en <strong>OdonSecure</strong> para obtener todos los beneficios disponibles.</p><br> <p><strong>OdonSecure</strong>, siempre ocupandonos de tu Sonrisa!</p><hr> </div> <footer> <p>Todos los derechos reservados || Jesus Quintana || '.date("Y-m-d").'</p> </footer> </main> </body></html>';

        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host = $_ENV["EMAIL_HOST"];
            $email->SMTPAuth = true;
            $email->Username = $_ENV["EMAIL_USERNAME"];
            $email->Password = $_ENV["EMAIL_PASSWORD"];
            $email->Port = $_ENV["EMAIL_PORT"];

            $email->setFrom($_ENV["EMAIL_USERNAME"], 'OdonSecure');
            $email->addAddress($correo, $correo);

            $email->isHTML(true);
            $email->Subject = "Reestablecer Cuenta";
            $email->Body = $html;
            $email->AltBody = 'Anexo encontraras el link para reestablecer tu cuenta';

            $enviado = $email->send();

            if($enviado) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return $e;
        }
    }

    public static function enviarResumen($datos, $ruta, $nombreArchivo) {
        $html = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <style>html{font-size:62.5%}body{font-size:1.6rem;margin:0 auto;font-family:Verdana,Geneva,Tahoma,sans-serif}main{max-width:800px;border:5px solid #148c84;margin:0 auto}h1,h2,p{margin:0}h1{font-size:3.4rem}h2{font-size:3rem}p{font-size:1.5rem}span{font-weight:bold}header{margin:0 auto;padding:4rem;background-color:#16848c;color:#fff;display:block}.inform{text-align:right}.contenido{margin:10px auto}footer{margin:5px auto;text-align:center}@media(max-width:480px){.contenedor{text-align:center;max-width:100%;font-size: 10px}h1{display:block;margin:0 auto}.inform{display:block;text-align:center;margin:0 auto}}</style><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body> <main class="contenedor"> <header> <h1>OdonSecure</h1> <div class="inform"> <p><span>Ubicacion:</span> Av Casanova, en frente del farmatodo del recreo</p> <p><span>Nro Telefono:</span> 04144663318</p> <p><span>Correo:</span> consultorio@odonsecure.com</p> <p><span>Instagram:</span> @odonsecure_</p> </div> </header> <div class="contenido"> <p>Anexo encontraras el resumen de tu cita pautada '.$datos["cliente"].'.</p><br> <p><strong>OdonSecure</strong>, siempre ocupandonos de tu Sonrisa!</p><hr> </div> <footer> <p>Todos los derechos reservados || Jesus Quintana || '.date("Y-m-d").'</p> </footer> </main> </body></html>';

        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host = $_ENV["EMAIL_HOST"];
            $email->SMTPAuth = true;
            $email->Username = $_ENV["EMAIL_USERNAME"];
            $email->Password = $_ENV["EMAIL_PASSWORD"];
            $email->Port = $_ENV["EMAIL_PORT"];

            $email->setFrom($_ENV["EMAIL_USERNAME"], 'OdonSecure');
            $email->addAddress($datos["email"], $datos["cliente"]);

            $email->addAttachment($ruta, 'Resumen Cita.pdf');

            $email->isHTML(true);
            $email->Subject = "Resumen Cita || ".$datos["cliente"];
            $email->Body = $html;
            $email->AltBody = 'Anexo encontraras el resumen de tu cita pautada '.$datos["cliente"];

            $enviado = $email->send();

            if($enviado) {
                return true;
            } else {
                return false;
            }
        }
        catch(Exception $e) {
            return $e;
        }
    }
}
