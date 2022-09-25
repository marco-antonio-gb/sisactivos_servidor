<?php
use Illuminate\Support\Facades\File;
class NumeroLetras
{
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE ',
    ];
    private static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN ',
    ];
    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS ',
    ];
    public static function convertir($number, $currency = '', $format = false, $decimals = '')
    {
        $base_number = $number;
        $converted   = '';
        $decimales   = '';
        if (($base_number < 0) || ($base_number > 999999999)) {
            return 'No es posible convertir el numero en letras';
        }
        $div_decimales = explode('.', $base_number);
        if (count($div_decimales) > 1) {
            $base_number  = $div_decimales[0];
            $decNumberStr = (string) $div_decimales[1];
            if (strlen($decNumberStr) == 2) {
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos       = substr($decNumberStrFill, 6);
                $decimales        = self::convertGroup($decCientos);
            }
        }
        $numberStr     = (string) $base_number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones      = substr($numberStrFill, 0, 3);
        $miles         = substr($numberStrFill, 3, 3);
        $cientos       = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }
        if ($format) {
            if (empty($decimales)) {
                $valor_convertido =  ' (' . ucfirst($converted) . '00/100 ' . $currency . ')';
            } else {
                $valor_convertido =  ' (' . ucfirst($converted) . $decNumberStr . '/100 ' . $currency . ')';
            }
        } else {
            if (empty($decimales)) {
                $valor_convertido = ucfirst($converted) . $currency;
            } else {
                $valor_convertido = ucfirst($converted) . $currency . ' CON ' . $decimales . $decimals;
            }
        }
        # OLD: RETORNA EL NUMERO CON EL LITERAL EN UNA LINEA
        // if ($format) {
        // 	if (empty($decimales)) {
        // 		$valor_convertido = number_format($number, 2, ',', '.') . ' (' . ucfirst($converted) . '00/100 ' . $currency . ')';
        // 	} else {
        // 		$valor_convertido = number_format($number, 2, ',', '.') . ' (' . ucfirst($converted) . $decNumberStr . '/100 ' . $currency . ')';
        // 	}
        // } else {
        // 	if (empty($decimales)) {
        // 		$valor_convertido = ucfirst($converted) . $currency;
        // 	} else {
        // 		$valor_convertido = ucfirst($converted) . $currency . ' CON ' . $decimales . $decimals;
        // 	}
        // }
        return $valor_convertido;
    }
    private static function convertGroup($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n, 1));
        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }
}
function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, $divider);
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function deleteFile($path, $foler, $file) {
    try {
        $full_path = $path . $foler . $file;
        if (file_exists($full_path)) {
            unlink($full_path);
            return true;
        } else {
            return false;
        }
    } catch (\Exception $ex) {
        return false;
    }
}
function createDirecrotory($sub_folder, $root_folder) {
   try {
    if(File::isDirectory($root_folder)){
        if(File::isDirectory($root_folder.'/'.$sub_folder)){
        }else{
            File::makeDirectory($root_folder.'/'.$sub_folder, 0777, true, true);
        }
    }else{
        File::makeDirectory($root_folder, 0777, true, true);
        File::makeDirectory($root_folder.'/'.$sub_folder, 0777, true, true);
    }
    return true;
   } catch (\Throwable $th) {
       return false;
   }
}
function deleteDirecrotory($sub_folder, $root_folder) {
   try {
    if(File::isDirectory($root_folder)){
        if(File::isDirectory($root_folder.'/'.$sub_folder)){
            File::deleteDirectory($root_folder.'/'.$sub_folder);
            return true;
        } 
    }else{
        return false;
    }
    return true;
   } catch (\Throwable $th) {
       return false;
   }
}