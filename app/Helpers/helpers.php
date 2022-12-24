<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

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

function SKU_gen($string){

    $results = $string!=null ? $string : "0";
    if(preg_match_all('/\b(\w)/',strtoupper($string),$m)) {
        $results = implode('',$m[1]); // $v is now SOQTU
    }
    return substr($results,0,1);
}

function getcolorAvatar($name) {
    $acro = substr($name, 0,5);
    $colors = [
        "#F44336",
        "#E91E63",
        "#9C27B0",
        "#673AB7",
        "#3F51B5",
        "#2196F3",
        "#03A9F4",
        "#00BCD4",
        "#009688",
        "#4CAF50",
        "#8BC34A",
        "#FFC107",
        "#FF9800",
        "#FF5722",
        "#4527A0",
        "#01579B",
        "#B71C1C",
        "#880E4F",
        "#283593",
        "#1565C0",
        "#0277BD",
        "#4A148C",
        "#00796B",
        "#2E7D32",
        "#558B2F",
        "#FF6F00",
    ];
    $sum = 0;
    for($j=0; $j<strlen($acro); $j++){
        $sum+=ord($acro);
    }
    $ascii = $sum;
    $colortest = $ascii%26;
    return  $colors[$colortest];
}
#@Params:  Imagen, Carpeta destino
function storeImage($imagen, $folder, $w=500, $h=500) {
    $result = null;
    try {
        if ($imagen) {
            #Generar codigo UUID
            $randomString = Str::uuid();
            #Creando una imagen codificado en JPG
            $image = Image::make($imagen)->encode('jpg');
            #directorio para imagenes originales
            $originalPath = '/' . $folder . '/';
            #Redimencionando imagenes a 600x600
            // $image->fit(500, 500, function ($constraint) {
            //     $constraint->upsize();
            //     $constraint->aspectRatio();
            // });
            $result = $randomString . '.jpg';
            #Almacenar imagen en carpeta con tamano Original
            $image->save(public_path() . $originalPath . $result);
            $image->destroy();
        }
    } catch (\Exception $th) {
        $result = $th->getMessage();
    }
    return $result;
}
function deleteImage($folder, $file) {
    try {
        $originalPath = '/' . $folder . '/';
        $full_path    = public_path() . $originalPath . $file;
        if (file_exists($full_path)) {
            unlink($full_path);
            return [
                'success' => true,
                'message' => "El archivo se elimino",
            ];
        } else {
            return [
                'success' => false,
                'message' => "El archivo no existe",
            ];
        }
    } catch (\Exception $ex) {
        return [
            'success' => false,
            'message' => $ex->getMessage(),
        ];
    }
}
function storageAnotherFile($file, $folder) {
	$result = null;
	try {
		if ($file) {
			$randomString = Str::uuid();
			$extension    = $file->getClientOriginalExtension();
			$originalPath = '/' . $folder . '/';
			$result       = $randomString . '.' . $extension;
			$destinationPath = public_path() . $originalPath . $result;
			$file->move(public_path($originalPath), $result);
		}
	} catch (\Exception $th) {
		$result = $th->getMessage();
	}
	return $result;
}

