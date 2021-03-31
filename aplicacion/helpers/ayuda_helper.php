<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('ayuda'))
{
        //formateamos la fecha y la hora, función de cesarcancino.com
        function tiempo($tiempo) {
        if ($tiempo < 60) {
            $tiempo = $tiempo;
            $valor = " minutos";
        } elseif ($tiempo > 60 && $tiempo < 1440) {
            $tiempo = $tiempo / 60;
            $tiempo = number_format($tiempo);
            $valor = " horas";
        } elseif ($tiempo > 1440) {
            $tiempo = $tiempo / 1440;
            $tiempo = number_format($tiempo);
            $valor = " días";
        }
        return $tiempo . $valor;
    }

     function fechaseteada($date)
     {
        $dia = explode("-", $date, 3);
        $year = $dia[0];
        $month = (string)(int)$dia[1];
        $day = (string)(int)$dia[2];
        
        $dias = array("domingo","lunes","martes","miercoles" ,"jueves","viernes","sabado");
        $tomadia = $dias[intval((date("w",mktime(0,0,0,$month,$day,$year))))];
        $meses = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        
        return $day." de ".$meses[$month]." de ".$year;
    }

     function slug($url) {
      // Tranformamos todo a minusculas

      $url = strtolower($url);

      //Rememplazamos caracteres especiales latinos

      $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

      $repl = array('a', 'e', 'i', 'o', 'u', 'n');

      $url = str_replace ($find, $repl, $url);

      // Añadimos los guiones

      $find = array(' ', '&', '\r\n', '\n', '+');
      $url = str_replace ($find, '-', $url);

      // Eliminamos y Reemplazamos otros carácteres especiales

      $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

      $repl = array('', '-', '');

      $url = preg_replace ($find, $repl, $url);

      return $url;
    }

    function extension($archivo) 
    {
        $mime_types = array(

            'txt' => 'text/plain',

            'srt' => 'text/plain',

            'htm' => 'text/html',

            'html' => 'text/html',

            'php' => 'text/html',

            'css' => 'text/css',

            'js' => 'application/javascript',

            'json' => 'application/json',

            'xml' => 'application/xml',

            'swf' => 'application/x-shockwave-flash',

            'flv' => 'video/x-flv',


            // images

            'png' => 'image/png',

            'jpe' => 'image/jpeg',

            'jpeg' => 'image/jpeg',

            'jpg' => 'image/jpeg',

            'gif' => 'image/gif',

            'bmp' => 'image/bmp',

            'ico' => 'image/vnd.microsoft.icon',

            'tiff' => 'image/tiff',

            'tif' => 'image/tiff',

            'svg' => 'image/svg+xml',

            'svgz' => 'image/svg+xml',


            // archives

            'zip' => 'application/zip',

            'rar' => 'application/x-rar-compressed',

            'exe' => 'application/x-msdownload',

            'msi' => 'application/x-msdownload',

            'cab' => 'application/vnd.ms-cab-compressed',


            // audio/video

            'mp3' => 'audio/mpeg',

            'qt' => 'video/quicktime',

            'mov' => 'video/quicktime',


            // adobe

            'pdf' => 'application/pdf',

            'psd' => 'image/vnd.adobe.photoshop',

            'ai' => 'application/postscript',

            'eps' => 'application/postscript',

            'ps' => 'application/postscript',


            // ms office

            'doc' => 'Office-Document/Word',

            'docx' => 'Office-Document/Word',

            'rtf' => 'application/rtf',

            'xls' => 'Office-Document/Excel',

            'xlsx' => 'Office-Document/Excel',

            'ppt' => 'Office-Document/Powerpoint',

            'pptx' => 'Office-Document/Powerpoint',


            // open office

            'odt' => 'application/vnd.oasis.opendocument.text',

            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',

        );


        $ext = @strtolower(array_pop(explode('.',$archivo)));

        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        else{
            return 'application/octet-stream';
            echo "error";
        }
    }
}