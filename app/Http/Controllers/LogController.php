<?php

namespace App\Http\Controllers;

use File;

class LogController extends Controller
{

    public function parseLog($log_folder)
    {
        $path = public_path('/home/logs/' . strtolower($log_folder));
        $logCollection = [];
        $files = File::files($path);
        foreach ($files as $key => $file) {
            $logCollection[] = $file->getFilename();
        }
        return $logCollection;
    }


    public function getLogFile()
    {
        return response()->json([
            'login' => $this->parseLog('login'),
            'responsables' => $this->parseLog('responsables'),
            'articulos' => $this->parseLog('articulos'),
            'usuarios' => $this->parseLog('usuarios'),
            'asignaciones' => $this->parseLog('asignaciones'),
            'bajas' => $this->parseLog('bajas'),
            'transferencias' => $this->parseLog('transferencias'),
        ], 200);
    }
}
