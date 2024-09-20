<?php
namespace Model;
use Dompdf\Dompdf as DompdfDompdf;
use Dompdf\Options;
use Exception;

class PDF {
    public static function crearPDF($datos) : array {
        if(!is_dir(dirname(__DIR__)."/PDFs")) {
            mkdir(dirname(__DIR__)."/PDFs");
        }

        try {
            $html = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <style> html { font-size: 62.5%; } body { font-size: 1.6rem; margin: 0 auto; font-family: Verdana, Geneva, Tahoma, sans-serif; } .contenedor { max-width: 800px; border: 5px solid #148c84; margin: 0 auto; } h1, h2, p, tr, td { margin: 0; } h1 { font-size: 3.4rem; } h2 { font-size: 3rem; } p, tr, td { font-size: 1.5rem; } span { font-weight: bold; } header { margin: 0 auto; padding: 4rem; display:flex; justify-content: space-between; align-items: center; background-color: #16848c; color: #fff; } .inform { text-align: right; } table { margin: 30px auto; text-align: center; } thead { font-weight: bold; } td { outline: 1px solid #000; padding: 1rem; } td span { color: #1cb435; } footer { margin: 5px auto; text-align: center; }@media (max-width: 480px) {.contenedor {text-align: center;max-width: 100%;}header {flex-direction: column;gap: 10px;justify-content: center;align-items: center;text-align: center;}.inform {text-align: center;}}</style><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body> <main class="contenedor"> <header> <h1>OdonSecure</h1> <div class="inform"> <p><span>Ubicacion:</span> Av Casanova, en frente del farmatodo del recreo</p> <p><span>Nro Telefono:</span> 04144663318</p> <p><span>Correo:</span> consultorio@odonsecure.com</p> <p><span>Instagram:</span> @odonsecure_</p> </div> </header> <table> <thead> <tr> <td>Nro de Cita</td> <td>Paciente</td> <td>Fecha</td> <td>Hora</td> <td>Servicios</td> <td>Precio</td> </tr> </thead> <tbody> <tr> <td>000'.$datos["id"].'</td> <td>'.$datos["cliente"].'</td> <td>'.$datos["fecha"].'</td> <td>'.$datos["hora"].'</td> <td>'.$datos["servicios"].'</td> <td>'.$datos["total"].'<span>$</span></td> </tr> </table> <footer> <p>Todos los derechos reservados || Jesus Quintana || '.date("Y-m-d").'</p> </footer> </main> </body></html>';

            $option = new Options();
            $option->set("defaultFont", "Arial");

            $pdf = new DompdfDompdf($option);
            $pdf->loadHtml($html);
            $pdf->setPaper("A4", "portrait");
            $pdf->render();

            $dir = dirname(__DIR__) . "/PDFs/".explode(" ", $datos["cliente"])[0]."_".date("Y-m-d")."_".uniqid().".pdf";

            $nombreArchivo = explode(" ", $datos["cliente"])[0]."_".date("Y-m-d")."_".uniqid().".pdf";
            
            file_put_contents($dir, $pdf->output());
            
            return ["respuesta"=>true, "dir"=>$dir, "nombreArchivo"=>$nombreArchivo];
        }
        catch(Exception $e) {
            return ["respuesta"=>false, "dir"=>""];
        }
    }

    public static function crearPDFUSER($datos) : array {
        if(!is_dir(dirname(__DIR__)."/PDFs")) {
            mkdir(dirname(__DIR__)."/PDFs");
        }
        
        try {
            $total=0;
            foreach($datos["servicios"] as $dato) {
                $servicios[] = $dato->nombre;
                $total += floatval($dato->precio);
            };

            $html = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <style> html { font-size: 62.5%; } body { font-size: 1.6rem; margin: 0 auto; font-family: Verdana, Geneva, Tahoma, sans-serif; } .contenedor { max-width: 800px; border: 5px solid #148c84; margin: 0 auto; } h1, h2, p, tr, td { margin: 0; } h1 { font-size: 3.4rem; } h2 { font-size: 3rem; } p, tr, td { font-size: 1.5rem; } span { font-weight: bold; } header { margin: 0 auto; padding: 4rem; display:flex; justify-content: space-between; align-items: center; background-color: #16848c; color: #fff; } .inform { text-align: right; } table { margin: 30px auto; text-align: center; } thead { font-weight: bold; } td { outline: 1px solid #000; padding: 1rem; } td span { color: #1cb435; } footer { margin: 5px auto; text-align: center; }@media (max-width: 480px) {.contenedor {text-align: center;max-width: 100%;}header {flex-direction: column;gap: 10px;justify-content: center;align-items: center;text-align: center;}.inform {text-align: center;}}</style><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body> <main class="contenedor"> <header> <h1>OdonSecure</h1> <div class="inform"> <p><span>Ubicacion:</span> Av Casanova, en frente del farmatodo del recreo</p> <p><span>Nro Telefono:</span> 04144663318</p> <p><span>Correo:</span> consultorio@odonsecure.com</p> <p><span>Instagram:</span> @odonsecure_</p> </div> </header> <table> <thead> <tr> <td>Nro de Cita</td> <td>Paciente</td> <td>Fecha</td> <td>Hora</td> <td>Servicios</td> <td>Precio</td> </tr> </thead> <tbody> <tr> <td>000'.$datos["cita"].'</td> <td>'.$datos["cliente"].'</td> <td>'.$datos["fecha"].'</td> <td>'.$datos["hora"].'</td> <td>'.join(", ", $servicios).'</td> <td>'.$total.'<span>$</span></td> </tr> </table> <footer> <p>Todos los derechos reservados || Jesus Quintana || '.date("Y-m-d").'</p> </footer> </main> </body></html>';

            $option = new Options();
            $option->set("defaultFont", "Arial");

            $pdf = new DompdfDompdf($option);
            $pdf->loadHtml( $html );
            $pdf->setPaper("A4", "portrait");
            $pdf->render();

            $nombreArchivo = $datos["cliente"]."_".date("Y-m-d")."_".uniqid().".pdf";
            $dir = dirname(__DIR__) . "/PDFs/".$nombreArchivo;

            file_put_contents($dir, $pdf->output());
            
            return ["respuesta"=>true, "dir"=>$dir, "nombreArchivo"=>$nombreArchivo];
        }
        catch(Exception $e) {
            return ["respuesta"=>false, "dir"=>""];
        }
    }
}